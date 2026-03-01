FROM richarvey/nginx-php-fpm:3.1.6

# Install Node.js for frontend asset compilation
RUN apk add --no-cache nodejs npm

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

# Copy application code
COPY . .

# Create a minimal .env so artisan commands don't crash during build
RUN cp .env.example .env && \
    php artisan key:generate --no-interaction

# Install PHP dependencies at BUILD time
# --no-scripts: skip post-install artisan commands that need DB
# Then run dump-autoload separately to generate classmap
RUN composer install --no-dev --optimize-autoloader --no-scripts --working-dir=/var/www/html && \
    composer dump-autoload --optimize --no-scripts --working-dir=/var/www/html

# Install and build frontend assets at BUILD time
# Use npm install (not npm ci) for better Alpine musl compatibility
RUN npm install --prefix /var/www/html && npm run build --prefix /var/www/html

# Remove build-only .env (runtime env vars come from Render dashboard)
RUN rm -f .env

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

CMD ["/start.sh"]
