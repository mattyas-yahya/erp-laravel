set -eu
set -o pipefail
echo "Deploy script started"
#cd /usr/share/nginx/html/soft_ui_dashboard_laravel_pro/ # go to project repository on the server
#git fetch --all
#php8.0 artisan down
#git reset --hard origin/main
#php8.0 /usr/local/bin/composer install --no-interaction #install php part
#php8.0 artisan migrate:fresh --seed
php artisan optimize:clear
php artisan config:cache
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan config:clear
php artisan view:cache
#php artisan route:cache
#php artisan storage:link
#chown -R www-data:www-data /usr/share/nginx/html/soft_ui_dashboard_laravel_pro/ #change here too project repository
#php8.0 artisan up
#source ~/.nvm/nvm.sh
#npm install
#npm run prod
echo "Deploy script finished execution"
