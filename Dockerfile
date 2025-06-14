FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

RUN chmod -R 775 storage bootstrap/cache

RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

WORKDIR /var/www/html

RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && cp .env.example .env \
    && php artisan key:generate

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

RUN npm install && npm run build

RUN echo "upload_max_filesize=10M\npost_max_size=10M" > /usr/local/etc/php/conf.d/uploads.ini
