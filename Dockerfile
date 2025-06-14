# Gunakan base image PHP 8.2 dengan Apache
FROM php:8.2-apache

# Set variabel environment untuk non-interaktif, mencegah prompt saat instalasi
ENV DEBIAN_FRONTEND=noninteractive

# 1. Instalasi Dependensi Sistem & Ekstensi PHP
#    - Instal paket yang umum dibutuhkan oleh Laravel & Composer.
#    - Instal ekstensi PHP yang dibutuhkan: pdo_mysql, zip, gd.
#    - Bersihkan cache apt untuk menjaga ukuran image tetap kecil.
RUN apt-get update && apt-get install -y \
      git \
      unzip \
      zip \
      libzip-dev \
      libpng-dev \
      libonig-dev \
      libxml2-dev \
      && docker-php-ext-install pdo_mysql zip gd \
      && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Konfigurasi Apache
#    - Aktifkan mod_rewrite untuk URL yang bersih (pretty URLs) di Laravel.
#    - Set document root ke direktori public Laravel.
RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 3. Set direktori kerja
WORKDIR /var/www/html

# 4. Instal Composer (Global)
#    - Salin binary Composer dari image resmi Composer.
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Salin file proyek
#    - Salin semua file dari konteks build ke direktori kerja.
#    - .dockerignore akan mencegah penyalinan file/folder yang tidak perlu (vendor, node_modules, .env).
COPY . /var/www/html

# 6. Instal dependensi Composer
#    - Jalankan composer install untuk mengunduh package dari composer.json.
#    - --no-dev: Hanya instal dependensi production.
#    - --optimize-autoloader: Mengoptimalkan class autoloader untuk kecepatan.
#    - --no-interaction: Tidak mengajukan pertanyaan interaktif.
#    - --no-plugins & --no-scripts: Mencegah eksekusi plugin/script saat build (lebih aman).
RUN composer install --no-interaction --optimize-autoloader --no-dev --no-plugins --no-scripts

# 7. Atur kepemilikan dan izin file
#    - Berikan kepemilikan folder storage dan bootstrap/cache kepada user Apache (www-data).
#    - Atur izin agar server bisa menulis ke folder tersebut. Ini penting untuk log, cache, dan file upload.
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 8. Siapkan Entrypoint Script
#    - Salin script yang akan dijalankan setiap kali container dimulai.
#    - Berikan izin eksekusi pada script tersebut.
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# 9. Expose Port
#    - Railway akan secara otomatis mendeteksi port 80 dan melakukan mapping.
EXPOSE 80

# 10. Set Entrypoint
#     - Tentukan script entrypoint sebagai perintah yang akan dijalankan saat container start.
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
