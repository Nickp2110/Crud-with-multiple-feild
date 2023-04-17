please add port whichever you used i used 4306 thats why i added 4306

after that run below command
php artisan config:cache
php artisan config:clear
composer install
php artisan migrate
php artisan serve
