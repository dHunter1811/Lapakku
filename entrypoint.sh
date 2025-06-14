#!/bin/sh

# Hentikan eksekusi jika ada perintah yang gagal
set -e

# Jalankan perintah artisan yang bergantung pada environment variables
# Perintah-perintah ini akan menggunakan variabel yang kamu set di dashboard Railway.

echo "Running Laravel startup commands..."

# Buat cache untuk konfigurasi, route, dan view untuk meningkatkan performa.
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Jalankan migrasi database.
# Opsi --force dibutuhkan karena aplikasi berjalan di environment production.
php artisan migrate --force

echo "Laravel startup commands finished."

# Perintah ini akan menjalankan server Apache di foreground.
# Ini harus menjadi perintah terakhir di script agar container tetap berjalan.
exec apache2-foreground
