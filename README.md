# 📌 ABSENIN 
Sistem Absensi QR Code Berbasis Web
adalah aplikasi berbasis web yang digunakan untuk mencatat kehadiran siswa secara **real-time**, **aman**, dan **terkontrol** menggunakan teknologi QR Code.  
Sistem ini dirancang untuk mencegah kecurangan absensi, mendukung monitoring langsung oleh admin, serta menyediakan riwayat kehadiran yang akurat.

---

## 🎯 Tujuan Sistem

- Mengganti absensi manual menjadi **digital dan otomatis**
- Mencegah titip absen menggunakan **QR Token & Device Lock**
- Memberikan **monitoring real-time** untuk admin
- Menyediakan **dashboard siswa dan admin** yang informatif
- Mendukung rekap absensi harian, mingguan, dan bulanan

---

## 🧩 Fitur Utama

### 👨‍🎓 Fitur Siswa
- Login siswa
- Scan QR Code untuk absensi
- Status absensi hari ini (Hadir / Terlambat / Alpha)
- Riwayat absensi pribadi
- Informasi waktu dan metode absensi
- Dashboard responsif (mobile friendly)

### 👨‍💼 Fitur Admin
- Dashboard admin (overview kehadiran hari ini)
- Generate QR Code (token dinamis & expired)
- Live Monitoring absensi (real-time)
- Absensi manual (izin, sakit, alpha)
- Kalender absensi
- Buku absensi & rekap data
- Manajemen siswa
- Pengaturan jam absensi (jam awal, tepat waktu, terlambat)
- Export data absensi (siap dikembangkan)

---

## 🔐 Sistem Keamanan

Sistem ini menerapkan beberapa lapisan keamanan:

- **QR Token Dinamis**
  - Token hanya aktif dalam waktu tertentu
  - Token otomatis kedaluwarsa

- **Session Validation**
  - Siswa harus login untuk melakukan scan

- **Device Lock (Opsional)**
  - Satu akun hanya dapat digunakan pada satu perangkat
  - Admin dapat melakukan reset device bila diperlukan

- **IP Address Tracking**
  - IP disimpan untuk keperluan audit & monitoring

---

## ⏱️ Penentuan Status Absensi

Status absensi ditentukan **satu kali saat proses scan QR** dan disimpan ke database:

| Waktu Absen | Status |
|------------|--------|
| ≤ Jam Tepat | Hadir |
| > Jam Tepat & ≤ Jam Terlambat | Terlambat |
| > Jam Terlambat | Alpha |

Semua tampilan (Admin & Siswa) **mengambil data langsung dari database**  
(tidak ada perhitungan ulang di sisi tampilan).

---

## 🏗️ Teknologi yang Digunakan

- **Framework**: Laravel
- **Bahasa**: PHP
- **Database**: MySQL
- **Frontend**: Blade Template + Tailwind CSS
- **QR Code**: SimpleSoftwareIO QrCode
- **Chart**: Chart.js
- **Realtime Update**: AJAX / Fetch API
- **Time Handling**: Carbon (Asia/Jakarta)

---

## 📂 Struktur Direktori Penting

```

app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── ScanQrController.php
│   │   ├── AbsensiController.php
│   │   ├── AdminController.php
│   │   └── UserController.php
│
resources/
├── views/
│   ├── admin/
│   ├── user/
│   ├── auth/
│   └── layouts/
│
database/
├── migrations/
│
routes/
├── web.php


````

---

## ⚙️ Pengaturan Sistem

Admin dapat mengatur:
- Jam awal absensi
- Jam batas tepat waktu
- Jam batas terlambat
- Mode absensi

Semua pengaturan disimpan di database dan **langsung memengaruhi sistem** tanpa perlu restart.

---

## 🚀 Cara Menjalankan Project

1. Clone repository
```bash
git clone <repo-url>
````

2. Install dependency

```bash
composer install
npm install
```

3. Setup environment

```bash
cp .env.example .env
php artisan key:generate
```

4. Migrasi database

```bash
php artisan migrate
```

5. Jalankan server

```bash
php artisan serve
```

---

## 📌 Catatan Pengembangan

* Sistem sudah mendukung skala sekolah
* Mudah dikembangkan ke:

  * Notifikasi WhatsApp
  * Face recognition
  * Export laporan PDF / Excel
  * Multi kelas & jurusan

---

## 👨‍💻 Author

Dikembangkan sebagai proyek sistem informasi absensi modern berbasis web dengan fokus pada **keamanan, real-time monitoring, dan akurasi data**.