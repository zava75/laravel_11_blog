# Строим на основе официального образа PHP
FROM php:8.4.2-fpm

# Устанавливаем необходимые зависимости и расширения
RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    git \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    default-mysql-client \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd \
    # Устанавливаем Redis через PECL
    && pecl install redis \
    && docker-php-ext-enable redis \
    # Устанавливаем Xdebug через PECL
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    # Убираем ненужные файлы
    && apt-get clean && rm -rf /var/lib/apt/lists/* \
    && chown -R www-data:www-data /var/www/html

# Копируем Composer из официального образа Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Копируем пользовательские конфиги PHP, если они есть
COPY conf.d/*.ini $PHP_INI_DIR/conf.d/

RUN apt-get install -y nodejs npm

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Запуск PHP-FPM
CMD ["php-fpm"]