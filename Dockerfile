# Dùng image PHP chính thức với Apache
FROM php:8.3-fpm

# Cài đặt các thư viện cần thiết
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git libxml2-dev libicu-dev libonig-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql xml intl opcache && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug

# Cài đặt Composer (nếu chưa có)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Thiết lập thư mục làm việc
WORKDIR /var/www/html

# Sao chép tất cả các file vào container
COPY . .

# Cài đặt các package PHP cho Laravel
RUN composer install

# Mở port 9000 (PHP-FPM)
EXPOSE 9000
