# 📖 Setup Guide - ExTrack

Panduan lengkap setup ExTrack untuk pemula.

## 📋 Prerequisites

Sebelum mulai, pastikan Anda sudah install:

1. **XAMPP** (sudah terinstall di komputer Anda)

   - PHP 8.2+
   - MySQL/MariaDB
   - Apache

2. **Composer** (untuk install dependencies)

   - Download: https://getcomposer.org/download/
   - Install dan pastikan bisa diakses via command line

3. **HeidiSQL** atau **phpMyAdmin** (untuk manage database)

## 🚀 Step-by-Step Installation

### Step 1: Persiapan Folder

1. Buka folder `C:\xampp\htdocs\`
2. Pastikan folder `extrack` sudah ada di sana
3. Struktur folder harus seperti ini:
   ```
   C:\xampp\htdocs\extrack\
   ├── assets/
   ├── auth/
   ├── config/
   ├── handlers/
   ├── includes/
   ├── pages/
   ├── uploads/
   ├── vendor/
   ├── index.php
   ├── composer.json
   ├── extrack.sql
   ```

### Step 2: Install Dependencies

1. Buka **Command Prompt** atau **PowerShell**
2. Masuk ke folder project:

   ```bash
   cd C:\xampp\htdocs\extrack
   ```

3. Install dependencies dengan Composer:

   ```bash
   composer install
   ```

4. Tunggu sampai selesai. Folder `vendor/` akan otomatis dibuat.

### Step 3: Setup Database

#### Opsi A: Menggunakan HeidiSQL (Recommended)

1. Buka **HeidiSQL**
2. Connect ke MySQL (biasanya: localhost, root, no password)
3. Klik kanan di sidebar → **Create new** → **Database**
4. Nama database: `extrack`
5. Charset: `utf8mb4`
6. Collation: `utf8mb4_general_ci`
7. Klik **OK**
8. Klik database `extrack` yang baru dibuat
9. Klik tab **Query**
10. Buka file `extrack.sql` dengan text editor
11. Copy semua isinya
12. Paste di Query tab HeidiSQL
13. Klik **Run** (F9)

#### Opsi B: Menggunakan phpMyAdmin

1. Buka browser: `http://localhost/phpmyadmin`
2. Klik tab **Databases**
3. Nama database: `extrack`
4. Collation: `utf8mb4_general_ci`
5. Klik **Create**
6. Klik database `extrack` di sidebar
7. Klik tab **Import**
8. Klik **Choose File**
9. Pilih file `extrack.sql`
10. Klik **Go**

### Step 4: Konfigurasi Environment (.env)

1. Copy file `.env.example` menjadi `.env`:

   ```bash
   copy .env.example .env
   ```

2. Buka file `.env` dengan text editor

3. Sesuaikan konfigurasi database (jika perlu):

   ```env
   DB_HOST=localhost
   DB_NAME=extrack
   DB_USER=root
   DB_PASS=
   ```

4. Jika MySQL Anda pakai password, isi `DB_PASS`:
   ```env
   DB_PASS=your_mysql_password
   ```

### Step 5: Konfigurasi Email (WAJIB)

Email verification dan forgot password memerlukan konfigurasi email yang benar.

1. Pastikan file `.env` sudah ada konfigurasi email:
   ```env
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your-email@gmail.com
   MAIL_PASSWORD=your-app-password
   MAIL_FROM_ADDRESS=noreply@extrack.com
   MAIL_FROM_NAME=ExTrack
   APP_URL=http://localhost/extrack
   ```

#### Cara Mendapatkan Gmail App Password:

1. Buka https://myaccount.google.com/security
2. Aktifkan **2-Step Verification**
3. Scroll ke bawah, klik **App passwords**
4. Pilih app: **Mail**
5. Pilih device: **Windows Computer**
6. Klik **Generate**
7. Copy 16 digit password (contoh: `abcd efgh ijkl mnop`)
8. Paste ke `.env` → `MAIL_PASSWORD` (tanpa spasi):
   ```env
   MAIL_PASSWORD=abcdefghijklmnop
   ```

### Step 6: Start Apache & MySQL

1. Buka **XAMPP Control Panel**
2. Klik **Start** pada **Apache**
3. Klik **Start** pada **MySQL**
4. Pastikan keduanya running (hijau)

### Step 7: Test Aplikasi

1. Buka browser
2. Akses: `http://localhost/extrack`
3. Anda akan melihat landing page ExTrack
4. Klik **Get Started** atau **Sign Up**

### Step 8: Register Akun Pertama

1. Isi form registrasi:

   - Username: `admin` (atau terserah)
   - Email: `admin@extrack.com` (atau email Anda)
   - Password: `password123` (minimal 6 karakter)
   - Confirm Password: `password123`

2. Klik **Create Account**

3. Jika berhasil, Anda akan diarahkan ke halaman login

4. **Note:** Email verification sekarang **wajib**. Anda harus verify email sebelum bisa login.

5. **Cek email Anda:**
   - Buka inbox (atau spam folder)
   - Cari email dari ExTrack
   - Klik link "Verifikasi Email"
6. **Jika email tidak masuk:**
   - Cek spam/junk folder
   - Klik "Kirim Ulang Email Verifikasi" di halaman login
   - Pastikan konfigurasi email di `.env` sudah benar

### Step 9: Login

1. Masukkan email dan password yang tadi dibuat
2. Centang **Remember Me** jika ingin auto-login (30 hari)
3. Klik **Login**

4. Anda akan masuk ke **Dashboard**

### Step 10: Setup Data Awal

#### A. Tambah Asset

1. Klik menu **Assets** di sidebar
2. Klik **Add Asset**
3. Isi:
   - Name: `Cash` atau `Dompet`
   - Initial Balance: `1000000` (1 juta)
4. Klik **Save**

5. Tambah asset lain (opsional):
   - Name: `Bank BCA`
   - Balance: `5000000`

#### B. Tambah Category

1. Klik menu **Statistics** di sidebar
2. Klik **Add Category**
3. Isi:
   - Type: **Expense**
   - Icon: `🍕` (tekan Windows + . untuk emoji picker)
   - Name: `Makanan`
4. Klik **Save**

5. Tambah category lain:
   - Type: **Expense**, Icon: `🚗`, Name: `Transport`
   - Type: **Income**, Icon: `💰`, Name: `Gaji`

#### C. Tambah Transaction

1. Klik menu **Transactions** di sidebar
2. Klik **Add Transaction**
3. Pilih tab **Income**
4. Isi:
   - Amount: `5000000`
   - Description: `Gaji Bulan November`
   - Category: `💰 Gaji`
   - Asset: `Bank BCA`
   - Date: (biarkan default = hari ini)
5. Klik **Save**

6. Tambah expense:
   - Tab: **Expense**
   - Amount: `50000`
   - Description: `Makan siang`
   - Category: `🍕 Makanan`
   - Asset: `Cash`
7. Klik **Save**

### Step 11: Test Forgot Password (Opsional)

1. Logout dari akun
2. Di halaman login, klik **"Lupa Password?"**
3. Masukkan email yang terdaftar
4. Klik **"Kirim Link Reset"**
5. Cek inbox email (atau spam folder)
6. Klik link reset password di email
7. Masukkan password baru (min 6 char, 1 angka, 1 huruf)
8. Password baru tidak boleh sama dengan password lama
9. Klik **"Reset Password"**
10. Login dengan password baru

**Catatan:**

- Link reset expired dalam 1 jam
- Link hanya bisa digunakan 1x
- Max 3x request per email per jam (rate limiting)

### Step 12: Explore Fitur

1. **Dashboard**: Lihat total balance, last transactions, top expenses
2. **Transactions**: Filter by type, lihat semua transaksi
3. **Assets**: Lihat semua asset dan balance
4. **Statistics**: Lihat pie chart income & expense
5. **Settings**: Update profile, change password

## ✅ Verification Checklist

Pastikan semua ini berfungsi:

- [ ] Landing page muncul di `http://localhost/extrack`
- [ ] Bisa register akun baru
- [ ] Bisa login
- [ ] Dashboard menampilkan data
- [ ] Bisa tambah asset
- [ ] Bisa tambah category
- [ ] Bisa tambah transaction
- [ ] Balance asset berubah setelah transaction
- [ ] Pie chart muncul di Statistics
- [ ] Bisa update profile di Settings
- [ ] Bisa logout

## 🐛 Troubleshooting

### Error: "Database connection failed"

**Penyebab:**

- MySQL belum running
- Database `extrack` belum dibuat
- Credentials salah

**Solusi:**

1. Cek MySQL running di XAMPP
2. Cek database `extrack` ada di HeidiSQL/phpMyAdmin
3. Cek `config/database.php` credentials benar

### Error: "Class 'PHPMailer' not found"

**Penyebab:**

- Composer dependencies belum diinstall

**Solusi:**

```bash
cd C:\xampp\htdocs\extrack
composer install
```

### Error: "Failed to upload photo"

**Penyebab:**

- Folder `uploads/profiles/` tidak ada atau tidak writable

**Solusi:**

1. Pastikan folder `uploads/profiles/` ada
2. Klik kanan folder → Properties → Security
3. Pastikan user Anda punya Write permission

### Halaman blank/error 500

**Penyebab:**

- PHP error

**Solusi:**

1. Buka `C:\xampp\php\php.ini`
2. Cari `display_errors = Off`
3. Ubah jadi `display_errors = On`
4. Restart Apache
5. Refresh halaman, lihat error message

### Session expired terus

**Penyebab:**

- Session timeout terlalu pendek

**Solusi:**

1. Buka `includes/session.php`
2. Ubah:
   ```php
   ini_set('session.gc_maxlifetime', 86400); // 24 jam
   ```
3. Atau centang **Remember Me** saat login

### Chart tidak muncul

**Penyebab:**

- Belum ada data transaksi
- JavaScript error

**Solusi:**

1. Tambah beberapa transaksi dulu
2. Buka browser Console (F12) → lihat error
3. Pastikan internet connect (Highcharts load dari CDN)

## 🔐 Forgot Password - Quick Guide

### Setup (One-time)

1. **Import tabel password_resets** (jika belum):

   ```sql
   -- Via HeidiSQL atau phpMyAdmin
   SOURCE C:/xampp/htdocs/extrack/database/password_resets_table.sql;
   ```

2. **Pastikan email configuration sudah benar** di `.env`:
   ```env
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your-email@gmail.com
   MAIL_PASSWORD=your-app-password
   APP_URL=http://localhost/extrack
   ```

### Usage

1. Buka halaman login
2. Klik **"Lupa Password?"**
3. Masukkan email terdaftar
4. Cek inbox email (atau spam)
5. Klik link reset password
6. Masukkan password baru
7. Login dengan password baru

### Password Requirements

Password harus memenuhi:

- ✅ Minimal 6 karakter
- ✅ Minimal 1 angka (0-9)
- ✅ Minimal 1 huruf (a-z atau A-Z)
- ✅ Tidak boleh sama dengan password lama

### Security Features

- 🔒 Token expires dalam 1 jam
- 🔒 Token hanya bisa digunakan 1x
- 🔒 Rate limiting: max 3 request per jam
- 🔒 Auto-delete expired tokens
- 🔒 Force logout dari semua device setelah reset

### Troubleshooting

**Email tidak terkirim?**

- Cek `.env` sudah benar
- Cek Gmail App Password (bukan password biasa)
- Cek spam/junk folder
- Cek port 587 tidak diblokir

**Token tidak valid?**

- Pastikan tabel `password_resets` sudah dibuat
- Cek token belum expired (>1 jam)
- Cek token belum pernah digunakan

**Rate limiting error?**

- Tunggu 1 jam dari request terakhir
- Atau hapus manual dari database

---

## 📞 Need Help?

Jika masih ada masalah:

1. Cek file `README.md` untuk dokumentasi lengkap
2. Cek file `CHANGELOG.md` untuk list perubahan
3. Cek file `FORGOT_PASSWORD_IMPLEMENTATION.md` untuk detail forgot password
4. Buka browser Console (F12) untuk lihat JavaScript error
5. Cek Apache error log di `C:\xampp\apache\logs\error.log`

## 🎉 Selamat!

Anda berhasil setup ExTrack! Sekarang Anda bisa mulai tracking expense Anda.

**Happy Tracking! 💰📊**
