# Team Fortuna - Aplikasi Manajemen Penelitian Dosen

Proyek ini dikembangkan oleh *Team Fortuna*, yang terdiri dari:
- Muhammad Syafi'ul Umam
- Rafly Eryan Azis
- Rafi Daniswara Anggoro Putra

## Tentang Proyek

Ini adalah aplikasi web yang dirancang untuk mengelola dan memfasilitasi kegiatan penelitian dosen. Sistem ini memungkinkan para dosen untuk mengelola proposal penelitian, melacak laporan kemajuan, mengakses pendanaan, dan mendokumentasikan hasil penelitian secara efisien dan transparan.

Dibangun menggunakan *CodeIgniter 4 (CI4)*, proyek ini bertujuan untuk mempermudah proses manajemen penelitian bagi dosen di universitas.

---

## Fitur
- Mengelola proposal penelitian.
- Melacak laporan kemajuan penelitian yang sedang berjalan.
- Mengakses dan mengelola pendanaan penelitian.
- Mendokumentasikan dan mempublikasikan hasil penelitian.
- Peran untuk dosen dan administrator dengan tingkat akses yang berbeda.

---

## Panduan Instalasi

### Langkah 1: Clone Repository

Untuk memulai dengan proyek ini, pertama-tama clone repository ini ke komputer lokalmu.

bash
git clone https://github.com/Umam07/Team-Fortuna.git

### Langkah 2: Setup CodeIgniter 4
#### 1. Masuk ke folder proyek:
 bash
cd Team-Fortuna
`
#### 2. Install dependencies Composer:
Jika belum menginstall Composer, unduh dari sini [composer](https://getcomposer.org/download/). 
Setelah Composer terinstall, jalankan perintah berikut untuk menginstall dependencies:
 bash 
composer install

#### 3. Salin file contoh .env untuk membuat file .env milikmu sendiri:
 bash 
cp env.example .env

#### 4. Buka file .env dan sesuaikan pengaturan database dengan mengganti baris berikut:
 bash
database.default.hostname = localhost
database.default.database = nama_database_anda
database.default.username = username_database_anda
database.default.password = password_database_anda
database.default.DBDriver = MySQLi


#### 5. Jalankan migrasi database:
 bash
php spark migrate


#### 6. Jalankan server bawaan CodeIgniter:
 bash
php spark serve


### Langkah 3: Menjalankan Aplikasi
Setelah menyelesaikan langkah instalasi, buka browser dan akses:
 bash 
http://localhost:8080


Semoga README ini dapat membantu pengguna memahami proyek dengan baik!
