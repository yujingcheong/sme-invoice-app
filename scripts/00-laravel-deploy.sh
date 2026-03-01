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

# Run migrate:fresh + seed in BACKGROUND so nginx can start immediately
# This prevents Render's port scan timeout (migrations can take 30s+ on Neon cold start)
# Using migrate:fresh because previous failed deploys may have left partial tables
# in the Neon DB, causing "table already exists" / transaction abort errors.
# This is safe for a demo app — every deploy gets clean, predictable state.
(
    echo "🗄️  [background] Running fresh database migrations..."
    
    # Retry up to 3 times (Neon cold start can cause first connection to timeout)
    MAX_RETRIES=3
    RETRY_COUNT=0
    
    while [ $RETRY_COUNT -lt $MAX_RETRIES ]; do
        if php artisan migrate:fresh --force --seed 2>&1; then
            echo "✅ [background] migrate:fresh + seed completed successfully"
            break
        else
            RETRY_COUNT=$((RETRY_COUNT + 1))
            echo "⚠️  [background] Attempt $RETRY_COUNT/$MAX_RETRIES failed, retrying in 5s..."
            sleep 5
        fi
    done
    
    if [ $RETRY_COUNT -eq $MAX_RETRIES ]; then
        echo "❌ [background] migrate:fresh failed after $MAX_RETRIES attempts"
        exit 1
    fi
    
    echo "✅ [background] Runtime setup fully complete!"
) &

echo "🏁 Script finished — migrations running in background"
