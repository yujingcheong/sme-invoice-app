#!/usr/bin/env bash
set -e

echo "🚀 Starting Laravel deployment..."

echo "📦 Installing Composer dependencies..."
composer install --no-dev --working-dir=/var/www/html --optimize-autoloader

echo "🎨 Installing and building frontend assets..."
npm ci --prefix /var/www/html
npm run build --prefix /var/www/html

echo "⚙️  Caching configuration..."
php artisan config:cache

echo "🛣️  Caching routes..."
php artisan route:cache

echo "👁️  Caching views..."
php artisan view:cache

echo "🗄️  Running database migrations..."
php artisan migrate --force

echo "✅ Deployment complete!"
