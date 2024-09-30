FROM php:8.2-fpm

RUN docker-php-ext-install pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-interaction --prefer-dist

RUN chown -R www-data:www-data /var/www/html

# CMD ["php", "/var/www/html/src/create_tables.php"]  docker exec -it php php /var/www/html/src/create_tables.php
