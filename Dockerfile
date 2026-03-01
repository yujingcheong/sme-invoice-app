# ============================================================
# Stage 1: Install PHP dependencies
# ============================================================
FROM composer:2 AS vendor

WORKDIR /app
COPY composer.json composer.lock ./
COPY database/ database/
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction --prefer-dist

# ============================================================
# Stage 2: Build frontend assets (Vite + Tailwind)
# ============================================================
FROM node:20-alpine AS frontend

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci

# Copy Vite config + source files
COPY vite.config.js ./
COPY resources/ resources/
COPY public/ public/

# Tailwind CSS references vendor files for scanning + flux.css import
COPY --from=vendor /app/vendor/ vendor/

RUN npm run build

# ============================================================
# Stage 3: Final production image
# ============================================================
FROM richarvey/nginx-php-fpm:3.1.6

# Copy application code
COPY . .

# Copy vendor from stage 1 (overwrites excluded /vendor from .dockerignore)
COPY --from=vendor /app/vendor/ vendor/

# Copy built assets from stage 2
COPY --from=frontend /app/public/build/ public/build/

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
ENV COMPOSER_ALLOW_SUPERUSER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

CMD ["/start.sh"]
