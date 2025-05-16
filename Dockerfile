# Gunakan image PHP 8.2 + Apache
FROM php:8.2-apache

# Install dependencies dan ekstensi PHP
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    git \
    && docker-php-ext-install pdo pdo_mysql mysqli mbstring exif pcntl bcmath gd xml zip intl

# Aktifkan mod_rewrite
RUN a2enmod rewrite

# Set Apache listen ke port 8080 (Cloud Run expects this)
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf

# Perbaikan untuk CodeIgniter 4: Set DocumentRoot ke direktori public
RUN sed -i 's/\/var\/www\/html/\/var\/www\/html\/public/g' /etc/apache2/sites-enabled/000-default.conf
RUN sed -i 's/<VirtualHost \*:80>/<VirtualHost \*:8080>/g' /etc/apache2/sites-enabled/000-default.conf

# Ubah konfigurasi PHP untuk environment production
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN sed -i 's/memory_limit = 128M/memory_limit = 512M/g' "$PHP_INI_DIR/php.ini"
RUN sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 20M/g' "$PHP_INI_DIR/php.ini"
RUN sed -i 's/post_max_size = 8M/post_max_size = 20M/g' "$PHP_INI_DIR/php.ini"

# Tambahkan konfigurasi direktori yang benar
RUN echo '<Directory /var/www/html>\n\
    Options -Indexes +FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>\n\
<Directory /var/www/html/public>\n\
    Options -Indexes +FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
    DirectoryIndex index.php\n\
</Directory>' >> /etc/apache2/apache2.conf

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Buat direktori untuk aplikasi
WORKDIR /var/www/html

# Tambahkan definisi variabel bucket - tambahan untuk mengatasi error Undefined variable $bucketName
ENV BUCKET_NAME="pentadosen-bucket"

# Salin composer files dulu untuk mengoptimalkan layer caching
COPY composer.json composer.lock ./

# Install dependensi dengan Composer
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Salin seluruh source code
COPY . .

# Jalankan post-install scripts
RUN composer dump-autoload --optimize

# Set base URL untuk Cloud Run
ENV APP_BASE_URL="https://pentadosen-26883336152.asia-southeast2.run.app"

# Buat file .env jika tidak ada dan sesuaikan konfigurasi
RUN if [ -f env ]; then \
        cp env .env; \
    elif [ ! -f .env ]; then \
        echo "CI_ENVIRONMENT = production" > .env; \
    fi

# Update .env dengan baseURL yang benar dan tambahkan BUCKET_NAME
RUN sed -i '/app.baseURL/d' .env || true
RUN echo "app.baseURL = '${APP_BASE_URL}'" >> .env
RUN echo "app.forceGlobalSecureRequests = true" >> .env
# Tambahkan definisi bucket name dalam .env
RUN echo "BUCKET_NAME = '${BUCKET_NAME}'" >> .env

# Perbaiki URL localhost di kode sumber PHP
RUN find /var/www/html/app -type f -name "*.php" -exec sed -i "s|http://localhost:8080|${APP_BASE_URL}|g" {} \;
RUN find /var/www/html/app -type f -name "*.php" -exec sed -i "s|http://localhost|${APP_BASE_URL}|g" {} \;
RUN find /var/www/html/app -type f -name "*.php" -exec sed -i "s|localhost:8080|pentadosen-26883336152.asia-southeast2.run.app|g" {} \;
RUN find /var/www/html/app -type f -name "*.php" -exec sed -i "s|localhost|pentadosen-26883336152.asia-southeast2.run.app|g" {} \;

# Perbaiki URL localhost di JavaScript
RUN find /var/www/html/public -type f -name "*.js" -exec sed -i "s|http://localhost:8080|${APP_BASE_URL}|g" {} \;
RUN find /var/www/html/public -type f -name "*.js" -exec sed -i "s|http://localhost|${APP_BASE_URL}|g" {} \;
RUN find /var/www/html/public -type f -name "*.js" -exec sed -i "s|localhost:8080|pentadosen-26883336152.asia-southeast2.run.app|g" {} \;
RUN find /var/www/html/public -type f -name "*.js" -exec sed -i "s|localhost|pentadosen-26883336152.asia-southeast2.run.app|g" {} \;

# Perbaiki App Config untuk auto-detect baseURL jika diperlukan
RUN if [ -f "app/Config/App.php" ]; then \
        sed -i 's/public $baseURL = '\''http:\/\/localhost:8080\/'\'';\|public $baseURL = '\'''\'';\|public $baseURL = '\''.*'\'';/public $baseURL = '\''${APP_BASE_URL}'\'';/g' app/Config/App.php; \
        if ! grep -q "public function __construct" app/Config/App.php; then \
            sed -i '/public $baseURL/a\\n    public function __construct()\n    {\n        // Auto-detect URL for Cloud Run\n        if (isset($_SERVER['\''HTTP_HOST'\''])) {\n            $this->baseURL = (isset($_SERVER['\''HTTPS'\'']) && $_SERVER['\''HTTPS'\''] === '\''on'\'' ? "https" : "http") . "://" . $_SERVER['\''HTTP_HOST'\''] . "/";\n        }\n    }' app/Config/App.php; \
        fi \
    fi

# Tambahkan langkah untuk membuat file konfigurasi bucket jika diperlukan
RUN echo "<?php\n\$bucketName = getenv('BUCKET_NAME') ?: '${BUCKET_NAME}';\n" > /var/www/html/app/Config/Bucket.php

# Set hak akses
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html
RUN chmod -R 777 /var/www/html/writable

# Buat file .htaccess di direktori public jika belum ada
RUN if [ ! -f public/.htaccess ]; then \
        echo "# Disable directory browsing" > public/.htaccess; \
        echo "Options -Indexes" >> public/.htaccess; \
        echo "" >> public/.htaccess; \
        echo "# ----------------------------------------------------------------------" >> public/.htaccess; \
        echo "# Rewrite engine" >> public/.htaccess; \
        echo "# ----------------------------------------------------------------------" >> public/.htaccess; \
        echo "" >> public/.htaccess; \
        echo "# Turn on rewrite engine" >> public/.htaccess; \
        echo "<IfModule mod_rewrite.c>" >> public/.htaccess; \
        echo "    RewriteEngine On" >> public/.htaccess; \
        echo "    " >> public/.htaccess; \
        echo "    # If the request is not for a valid directory" >> public/.htaccess; \
        echo "    RewriteCond %{REQUEST_FILENAME} !-d" >> public/.htaccess; \
        echo "    # If the request is not for a valid file" >> public/.htaccess; \
        echo "    RewriteCond %{REQUEST_FILENAME} !-f" >> public/.htaccess; \
        echo "    # If the request is not for a valid link" >> public/.htaccess; \
        echo "    RewriteCond %{REQUEST_FILENAME} !-l" >> public/.htaccess; \
        echo "    " >> public/.htaccess; \
        echo "    # Then send to index.php" >> public/.htaccess; \
        echo "    RewriteRule ^(.*)$ index.php/$1 [L]" >> public/.htaccess; \
        echo "</IfModule>" >> public/.htaccess; \
    fi

# Expose port 8080
EXPOSE 8080

# Modifikasi file boot untuk menampilkan error di production saat troubleshooting
RUN sed -i 's/error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);/error_reporting(E_ALL);/g' app/Config/Boot/production.php || true
RUN sed -i 's/ini_set('\''display_errors'\'', '\''0'\'');/ini_set('\''display_errors'\'', '\''1'\'');/g' app/Config/Boot/production.php || true
RUN sed -i 's/defined('\''CI_DEBUG'\'') || define('\''CI_DEBUG'\'', false);/defined('\''CI_DEBUG'\'') || define('\''CI_DEBUG'\'', true);/g' app/Config/Boot/production.php || true

# Tambahkan log debug di index.php
RUN sed -i '2i // Debug di awal file index.php\nerror_reporting(E_ALL);\nini_set('\''display_errors'\'', 1);\n\n// Log error ke file\nini_set('\''log_errors'\'', 1);\nini_set('\''error_log'\'', '\''/var/www/html/writable/logs/php-errors.log'\'');\n\n// Log awal eksekusi\nfile_put_contents('\''/var/www/html/writable/logs/debug.log'\'', '\''Starting application: '\'' . date('\''Y-m-d H:i:s'\'') . "\\n", FILE_APPEND);' public/index.php || true

# Jalankan Apache
CMD ["apache2-foreground"]