# Instalasi Project Laravel dari GitHub

## **1. Persyaratan (Requirements)**
Sebelum meng-clone repository, pastikan Anda memiliki:
- **Git**: [Download & Install Git](https://git-scm.com/)
- **Composer**: [Download & Install Composer](https://getcomposer.org/)
- **PHP** (Minimal versi 8.0 direkomendasikan)
- **MySQL** atau database lain yang didukung Laravel

## **2. Clone Repository**
Pertama, buka terminal atau command prompt dan jalankan perintah berikut untuk meng-clone project dari GitHub:  
```bash
git clone https://github.com/arissaturrohman/sop.git
```

## **3. Masuk ke Direktori Project**
Setelah cloning selesai, pindah ke folder project:  
```bash
cd sop
```

## **4. Instal Dependensi Composer**
Jalankan perintah berikut untuk menginstal dependensi Laravel yang diperlukan:  
```bash
composer install
```
Jika composer belum terinstal, unduh dan instal terlebih dahulu dari [Composer](https://getcomposer.org/).

## **5. Copy File `.env`**
Laravel menggunakan file `.env` untuk konfigurasi. Buat salinan file `.env.example` dengan perintah:  
```bash
cp .env.example .env
```

## **6. Generate Application Key**
Jalankan perintah berikut untuk membuat application key:  
```bash
php artisan key:generate
```

## **7. Konfigurasi Database**
- Buka file `.env` dan sesuaikan pengaturan database seperti berikut:
  ```
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=nama_database
  DB_USERNAME=root
  DB_PASSWORD=
  ```
- Buat database di MySQL dengan nama yang sesuai.

## **8. Jalankan Migrasi Database**
Untuk membuat tabel di database, jalankan perintah berikut:  
```bash
php artisan migrate
```
Jika terjadi error karena tabel sudah ada, gunakan:  
```bash
php artisan migrate:fresh --seed
```
(Command ini akan menghapus semua tabel sebelum melakukan migrasi ulang.)

## **9. Jalankan Server**
Setelah semua selesai, jalankan Laravel menggunakan perintah:  
```bash
php artisan serve
```
Akses aplikasi melalui `http://127.0.0.1:8000`.

---

## **Akses Login**
Username : admin@gmail.com
Password : 123

