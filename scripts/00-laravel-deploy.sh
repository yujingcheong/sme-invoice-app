#!/usr/bin/env bash
# Laravel runtime setup script for richarvey/nginx-php-fpm
# This runs BEFORE nginx starts, so it must complete quickly
# to avoid Render's port scan timeout.

echo "🚀 Starting Laravel runtime setup..."

echo "⚙️  Caching configuration..."
php artisan config:cache

echo "🛣️  Caching routes..."
php artisan route:cache

echo "👁️  Caching views..."
php artisan view:cache

echo "✅ Caches built — nginx will start now"

# Run migrations + seed in BACKGROUND so nginx can start immediately
# This prevents Render's port scan timeout (migrations can take 30s+ on Neon cold start)
(
    echo "🗄️  [background] Running database migrations..."
    
    # Retry migration up to 3 times (Neon cold start can cause first connection to timeout)
    MAX_RETRIES=3
    RETRY_COUNT=0
    
    while [ $RETRY_COUNT -lt $MAX_RETRIES ]; do
        if php artisan migrate --force 2>&1; then
            echo "✅ [background] Migrations completed successfully"
            break
        else
            RETRY_COUNT=$((RETRY_COUNT + 1))
            echo "⚠️  [background] Migration attempt $RETRY_COUNT/$MAX_RETRIES failed, retrying in 5s..."
            sleep 5
        fi
    done
    
    if [ $RETRY_COUNT -eq $MAX_RETRIES ]; then
        echo "❌ [background] Migrations failed after $MAX_RETRIES attempts"
        exit 1
    fi
    
    # Seed demo data on first deploy (only if no users exist yet)
    echo "🌱 [background] Checking if seed data needed..."
    USER_COUNT=$(php artisan tinker --execute="echo \App\Models\User::count();" 2>/dev/null || echo "0")
    if [ "$USER_COUNT" = "0" ]; then
        echo "🌱 [background] First deploy detected - seeding demo data..."
        php artisan db:seed --force
        echo "✅ [background] Seed complete"
    else
        echo "✅ [background] Database already has data - skipping seed"
    fi
    
    echo "✅ [background] Runtime setup fully complete!"
) &

echo "🏁 Script finished — migrations running in background"
