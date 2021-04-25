# Change to the project directory
#cd /var/www/html/devvistaderm

# Turn on maintenance mode
php artisan down

# Pull the latest changes from the git repository
# git reset --hard
# git clean -df
git pull origin dev

# Install/update composer dependecies
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Run database migrations
#php artisan migrate --force

# Config Clear caches
php artisan config:cache

# Clear expired password reset tokens
php artisan auth:clear-resets

# Clear and cache routes
php artisan route:clear
php artisan route:cache

# Clear and cache config
php artisan config:clear
php artisan config:cache

# Clear and cache views
php artisan view:clear
php artisan view:cache

#clear Compile
php artisan clear-compiled

#composer dumpauto

# Turn off maintenance mode
php artisan up