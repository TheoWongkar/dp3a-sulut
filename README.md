# 🏷️ Elapor DP3A Sulut

Website Dinas Pemberdayaan Perempuan dan Perlindungan Anak (DP3A), Sulawesi Utara. Dirancang untuk sistem informasi pelaporan kekerasan terhadap anak.

## ✨ Fitur

-   🧑‍💼 Multi-role Login (Admin, Petugas)
-   👤 Manajemen Pengguna (CRUD User)
-   🧑🏻‍💼 Manajemen Pegawai (CRUD Employee)
-   🗂️ Manajemen Kategori Berita (CRUD Post Category)
-   📰 Manajemen Berita (CRUD Post)
-   🆘 Manajemen Laporan (CRUD Report)
-   📜 Cek Riwayat Status
-   📊 Dashboard Admin dan Statistik
-   📤 Export Laporan Kasus ke format PDF

## ⚙️ Teknologi

-   Laravel 12
-   PHP 8.3
-   Tailwind CSS
-   Alpine.js
-   MySQL
-   Bootstrap Icon
-   DOMPDF
-   LangCommon
-   Sluggable
-   Ibnux Data Indonesia

## 🛠️ Instalasi & Setup

1. Clone repository:

    ```bash
    git clone https://github.com/theowongkar/elapor-dp3a-sulut.git
    cd elapor-dp3a-sulut
    ```

2. Install dependency:

    ```bash
    composer install
    npm install && npm run build
    ```

3. Salin file `.env`:

    ```bash
    cp .env.example .env
    ```

4. Atur konfigurasi `.env` (database, mail, dsb)

5. Generate key dan migrasi database:

    ```bash
    php artisan key:generate
    php artisan storage:link
    php artisan migrate:fresh --seed
    ```

6. Jalankan server lokal:

    ```bash
    php artisan serve
    ```

7. Buka browser dan akses http://127.0.0.1:8000

## 👥 Role & Akses

| Role    | Akses                                                 |
| ------- | ----------------------------------------------------- |
| Admin   | CRUD data user, employee, post category, post, report |
| Petugas | CRU data user, post, report                           |

## 📎 Catatan Tambahan

-   Pastikan folder `storage` dan `bootstrap/cache` writable.
-   Dapat dikembangkan lebih lanjut untuk integrasi API unit tracking (GPS, IoT, dsb)
