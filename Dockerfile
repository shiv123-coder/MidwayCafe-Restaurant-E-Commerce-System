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
# Apache config (IMPORTANT FIX)
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
# Workdir + code
# -----------------------------
WORKDIR /var/www/html
COPY . .

# -----------------------------
# Composer
# -----------------------------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# -----------------------------
# Permissions (CRITICAL)
# -----------------------------
RUN chmod -R 775 storage bootstrap/cache

# -----------------------------
# Storage link (safe)
# -----------------------------
RUN php artisan storage:link || true

# -----------------------------
# Expose
# -----------------------------
EXPOSE 80

# -----------------------------
# Runtime start (IMPORTANT FIX)
# -----------------------------
CMD php artisan config:cache && \
    php artisan route:cache || true && \
    php artisan migrate --force || true && \
    apache2-foreground
