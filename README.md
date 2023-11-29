## Installation

composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
<!-- mkdir storage/framework/{sessions,views,cache} -->
php artisan storage:link
