# Tugas Pemrograman Basis Data


## Cara menjalakan aplikasi

1. clone repository
    ```
    git clone https://github.com/hadigun007-projects/411241111_Hadi-Gunawan.git
    cd 411241111_Hadi-Gunawan
    ```
2. install depedensi
    ```
    composer install
    ```
3. copy dan update .env
    ```
    cp .env.example .env
    # update konfigurasi database
    ```
4. jalankan migrasi dan seed
    ```
    php artisan migrate --seed
    ```
5. jalankan aplikasi
    ```
    php artisan serve
    ```