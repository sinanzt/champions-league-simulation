FROM php:latest

WORKDIR /var/www/html

# Composer kurulumu
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# PHP eklentileri
RUN docker-php-ext-install pdo pdo_mysql

# Projeyi Docker içine kopyalama
COPY . .

# Composer ile bağımlılıkların yüklenmesi
RUN composer install

# Giriş komutu
CMD php artisan serve --host=0.0.0.0 --port=8001
