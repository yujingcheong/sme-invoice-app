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

# Seed demo data on first deploy (only if no users exist yet)
echo "🌱 Checking if seed data needed..."
USER_COUNT=$(php artisan tinker --execute="echo \App\Models\User::count();" 2>/dev/null || echo "0")
if [ "$USER_COUNT" = "0" ]; then
    echo "🌱 First deploy detected - seeding demo data..."
    php artisan db:seed --force
else
    echo "✅ Database already has data - skipping seed"
fi

echo "✅ Deployment complete!"
