FROM richarvey/nginx-php-fpm:3.1.6

# Install Node.js for frontend asset compilation (npm run build)
RUN apk add --no-cache nodejs npm

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

# Copy application code
COPY . .

# Install PHP dependencies at BUILD time (not runtime)
RUN composer install --no-dev --working-dir=/var/www/html --optimize-autoloader

# Install and build frontend assets at BUILD time
RUN npm ci --prefix /var/www/html && npm run build --prefix /var/www/html

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
