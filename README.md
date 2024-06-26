To run project

Steps:

1. cp .env.example .env
2. composer install
3. php artisan key:generate
4. php artisan migrate --seed
5. php artisan passport:client --personal (Leave the default name)

To view the endpoints and documentation upload paysera.postman_collection.json to postman
Left click paysera collection and press view documentation.
