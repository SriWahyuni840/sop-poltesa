FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN a2dismod mpm_event || true
RUN a2dismod mpm_worker || true
RUN a2enmod mpm_prefork
RUN a2enmod rewrite

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD php artisan key:generate --force && \
    php artisan migrate --force && \
    php artisan storage:link && \
    php artisan config:clear && \
    php artisan cache:clear && \
    apache2-foreground