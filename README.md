# Vehicle Reservation Application

Aplikasi ini dirancang untuk mempermudah proses pemesanan dan pemantauan kendaraan di perusahaan tambang nikel. Aplikasi ini memungkinkan admin untuk mengatur pemesanan kendaraan, sementara pihak yang berwenang dapat menyetujui atau menolak pemesanan.

## Informasi Teknologi

-   **Database**: MySQL v8.0
-   **PHP Version**: 8.2
-   **Framework**: Laravel 11, Filament 3

## Akun Pengguna

Aplikasi ini memiliki beberapa pengguna dengan peran berbeda. Berikut adalah daftar username dan password yang dapat digunakan untuk masuk ke aplikasi.

| Role     | Username              | Password |
| -------- | --------------------- | -------- |
| Admin    | admin@email.com       | password |
| Approver | supervisor@email.com  | password |
| Approver | supervisor2@email.com | password |
| Approver | manager@email.com     | password |

> **Catatan:** Password di atas adalah default. Silakan ubah password setelah login pertama untuk keamanan lebih lanjut.

## Panduan Penggunaan

### 1. Setup Aplikasi

-   **Clone Repository**:

    ```bash
    git clone https://github.com/addinseptyan/vehicle-reservation-app.git
    cd vehicle-reservation-app
    ```

-   **Instal Dependensi**:

    ```bash
    composer install
    npm install
    npm run build
    ```

-   **Konfigurasi File `.env`**:

    -   Salin file `.env.example` menjadi `.env`.
    -   Atur konfigurasi database sesuai dengan setup lokal Anda.
    -   Atur `APP_URL` untuk mendukung akses ke aplikasi ini.

-   **Generate Key**:

    ```bash
    php artisan key:generate
    ```

-   **Migrasi Database**:
    ```bash
    php artisan migrate --seed
    ```

### 2. Menjalankan Aplikasi

-   Jalankan server Laravel:

    ```bash
    php artisan serve
    ```

-   Jalankan fitur export excel di terminal berbeda:

    ```bash
    php artisan queue:work
    ```

-   Aplikasi dapat diakses di [http://localhost:8000/dashboard](http://localhost:8000/dashboard).

### 3. Menggunakan Aplikasi

-   **Login**:

    -   Masuk menggunakan akun Admin atau Approver yang tercantum di atas.
    -   Admin dapat mengatur pemesanan, mengelola driver, dan melihat laporan.
    -   Approver dapat menyetujui atau menolak pemesanan kendaraan.

-   **Dashboard**:

    -   Pada halaman Dashboard, admin dapat melihat grafik pemakaian kendaraan, total pemakaian bahan bakar, dan performa kendaraan secara visual.

-   **Pemesanan Kendaraan**:

    -   Admin dapat menambahkan pemesanan kendaraan, memilih driver, serta memilih approver untuk persetujuan.
    -   Pemesanan kendaraan harus disetujui minimal dua level (misalnya Supervisor dan Manager).

-   **Persetujuan**:
    -   Setelah pemesanan diinput, pihak approver akan menerima notifikasi untuk melakukan persetujuan.
    -   Approver dapat melihat status pemesanan dan memberikan persetujuan atau penolakan melalui aplikasi.

### 4. Fitur Export Laporan

-   Admin dapat mengekspor laporan pemesanan kendaraan secara periodik dalam format Excel melalui halaman Laporan.

## Catatan Tambahan

-   Pastikan untuk memeriksa konfigurasi server jika Anda menggunakan aplikasi ini di lingkungan produksi.
-   Gantilah password default untuk menghindari akses yang tidak sah.

---

### Troubleshooting

Jika terjadi kendala, pastikan:

-   **Database** telah dikonfigurasi dengan benar dan layanan sedang berjalan.
-   Versi **PHP** dan **Composer** yang digunakan sudah sesuai.
-   **Environment File** (`.env`) sudah diatur dengan benar.

Jika masih mengalami kendala, silakan hubungi tim pengembang atau cek dokumentasi Laravel untuk solusi lebih lanjut.
