#!/usr/bin/env bash
set -e

echo "🚀 Starting Laravel runtime setup..."

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

echo "✅ Runtime setup complete!"
