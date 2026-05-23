FROM php:8.2-apache

# -----------------------------
# System dependencies
# -----------------------------
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# -----------------------------
# PHP extensions
# -----------------------------
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    gd \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    zip

# -----------------------------
# Apache config
# -----------------------------
RUN a2enmod rewrite

RUN echo "<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
    </Directory>" > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# -----------------------------
# App code
# -----------------------------
WORKDIR /var/www/html
COPY . .

# -----------------------------
# Composer
# -----------------------------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# -----------------------------
# CRITICAL FIX: permissions
# -----------------------------
RUN mkdir -p storage/logs \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/framework/cache \
    && mkdir -p storage/framework/sessions

RUN touch storage/logs/laravel.log

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# -----------------------------
# Storage link
# -----------------------------
RUN rm -rf public/storage && php artisan storage:link || true

# -----------------------------
# Expose port
# -----------------------------
EXPOSE 80

# -----------------------------
# Start (SAFE VERSION)
# -----------------------------
CMD php artisan config:clear && \
    php artisan cache:clear && \
    php artisan migrate --force && \
    php artisan db:seed --force || true && \
    apache2-foreground
