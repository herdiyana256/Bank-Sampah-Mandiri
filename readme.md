![image](https://github.com/user-attachments/assets/259d3631-03b3-4c8d-957b-43d26486c9cc)
# Aplikasi Web Bank Sampah Mandiri
Bank Sampah Mandiri adalah aplikasi berbasis web yang dirancang untuk membantu pengelolaan aktivitas bank sampah secara digital. Aplikasi ini mempermudah administrasi, transaksi, monitoring, dan pelaporan pada Bank Sampah Mandiri dengan melibatkan berbagai aktor seperti Admin, Master Admin, dan Dinas Lingkungan Hidup (DLH).

#Fitur Utama
Pengelolaan Data Nasabah
Tambah, ubah, dan hapus data nasabah.
Monitoring informasi saldo tabungan sampah.
Pengelolaan Data Sampah
Input data sampah berdasarkan jenis dan berat.
Status distribusi sampah.
Transaksi Setor dan Tarik Sampah
Proses pencatatan transaksi setor sampah.
Proses pencairan saldo melalui transaksi tarik.
Monitoring dan Pelaporan
Rekapitulasi sampah berdasarkan periode tertentu.
Monitoring distribusi sampah oleh Dinas Lingkungan Hidup.
Manajemen Akses
Admin: Mengelola data nasabah, sampah, dan transaksi.
Master Admin: Akses penuh ke semua data dan fitur.
DLH: Monitoring distribusi sampah dan laporan rekapitulasi.

## Tampilan Aplikasi
![image](https://github.com/user-attachments/assets/4371e06e-e4a8-4b98-9dd4-0bfb33f80972)
![image](https://github.com/user-attachments/assets/9b627fa1-5928-48e1-a704-23823ad85153)
![image](https://github.com/user-attachments/assets/92869ee2-8203-40a4-9b99-1c10ca7813ea)
![image](https://github.com/user-attachments/assets/4469f78b-7149-4106-9db6-ffd8b56c1720)
![image](https://github.com/user-attachments/assets/05b353fd-12dd-4068-b11c-f62f4c08cc98)
![image](https://github.com/user-attachments/assets/d55458d5-6b99-476d-9850-157133f127fd)



## Admin Account
|   Level   | Username  | Password   |
|:---------:|:---------:|-----------:|
| Master Admin     | admin123  | admin123   
| Admin            | ADM241000     | admin123
| dinas lingkungan hidup |   ADM241100 |    admin123

# Aktor dalam Sistem
Admin:
Mengelola data nasabah, data sampah, dan transaksi.

Master Admin:
Memiliki akses penuh, termasuk monitoring semua aktivitas."


Dinas Lingkungan Hidup (DLH):
Memantau distribusi sampah dan menghasilkan laporan rekapitulasi.

## Roadmap Pengembangan
Versi 1.0:
Pengelolaan data nasabah dan transaksi.
Rekapitulasi sampah dan monitoring distribusi.
Versi 1.1:
Penambahan fitur pencarian data dan filter laporan.
Optimasi desain antarmuka pengguna.
Versi 2.0:
Penambahan fitur API untuk integrasi dengan pihak ketiga.
Modul notifikasi untuk nasabah.

## Sistem Requirement
- Database MySQL
- XAMPP / PHP 5.6

## library dan Framework:
jQuery, DataTables, SweetAlert2
Select2 untuk elemen form yang interaktif

## Server:
Apache HTTP Server 2.4.58

## CDN:
jsDelivr, cdnjs, Google Fonts API

Cara Instalasi : 
Clone Repository
bash
git clone https://github.com/herdiyana256/Bank-Sampah-Mandiri.git
Konfigurasi Database
Import file database.sql yang terdapat di folder config/ ke MySQL.
Edit file konfigurasi database di config/database.php sesuai dengan pengaturan lokal Anda.
Jalankan Server Lokal
Gunakan Apache (via XAMPP, Laragon, dll.).
Pastikan PHP 8.1.25 sudah terpasang.
Akses Aplikasi
Buka browser dan akses: http://localhost/BankSampahMandiri/.
