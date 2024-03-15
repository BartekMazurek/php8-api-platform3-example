docker compose up -d
docker exec promo_php bin/console --no-interaction doctrine:migrations:migrate
docker exec promo_php sh -c 'cd /var/www/app/postman && newman run collection.json -e environment.json'
