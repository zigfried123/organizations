composer i<br>
npm i<br>
sudo docker compose -f compose.dev.yaml up -d --build<br>
sudo docker compose -f compose.dev.yaml exec workspace bash<br>
php artisan migrate<br>
php artisan app:test-data<br>


Запросы находятся на главной странице vue по адресу localhost



