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
   └── migration_v2.sql
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

14. Ulangi untuk file `migration_v2.sql`:
    - Buka file `migration_v2.sql`
    - Copy semua isinya
    - Paste di Query tab
    - Klik **Run** (F9)

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

11. Ulangi untuk `migration_v2.sql`:
    - Klik tab **Import**
    - Pilih file `migration_v2.sql`
    - Klik **Go**

### Step 4: Konfigurasi Database Connection

1. Buka file `config/database.php`
2. Cek konfigurasi database:
   ```php
   $host = 'localhost';
   $dbname = 'extrack';
   $username = 'root';
   $password = '';
   ```

3. Jika MySQL Anda pakai password, ubah `$password`:
   ```php
   $password = 'your_mysql_password';
   ```

### Step 5: Konfigurasi Email (Opsional)

Email verification bersifat **opsional**. Anda bisa skip step ini dan langsung ke Step 6.

Jika ingin aktifkan email verification:

1. Buka file `config/email.php`
2. Ubah konfigurasi:
   ```php
   $this->mailer->Username = 'your-email@gmail.com';
   $this->mailer->Password = 'your-app-password';
   ```

#### Cara Mendapatkan Gmail App Password:

1. Buka https://myaccount.google.com/security
2. Aktifkan **2-Step Verification**
3. Scroll ke bawah, klik **App passwords**
4. Pilih app: **Mail**
5. Pilih device: **Windows Computer**
6. Klik **Generate**
7. Copy 16 digit password (contoh: `abcd efgh ijkl mnop`)
8. Paste ke `config/email.php` (tanpa spasi):
   ```php
   $this->mailer->Password = 'abcdefghijklmnop';
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

4. **Note:** Email verification bersifat opsional. Anda bisa langsung login tanpa verifikasi email.

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

### Step 11: Explore Fitur

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

## 📞 Need Help?

Jika masih ada masalah:

1. Cek file `README.md` untuk dokumentasi lengkap
2. Cek file `CHANGELOG.md` untuk list perubahan
3. Buka browser Console (F12) untuk lihat JavaScript error
4. Cek Apache error log di `C:\xampp\apache\logs\error.log`

## 🎉 Selamat!

Anda berhasil setup ExTrack! Sekarang Anda bisa mulai tracking expense Anda.

**Happy Tracking! 💰📊**
