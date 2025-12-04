# 🚀 Quick Start - Fitur Lupa Password

## 📦 Instalasi (3 Langkah)

### 1️⃣ Import Database
Jalankan file SQL untuk membuat tabel `password_resets`:

**Via phpMyAdmin:**
- Buka phpMyAdmin
- Pilih database `extrack`
- Klik tab "SQL"
- Copy-paste isi file `database/password_resets_table.sql`
- Klik "Go"

**Via Command Line:**
```bash
mysql -u root -p extrack < database/password_resets_table.sql
```

### 2️⃣ Cek Konfigurasi Email
Pastikan file `.env` sudah ada konfigurasi email:
```env
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_FROM_ADDRESS=noreply@extrack.com
MAIL_FROM_NAME=ExTrack
APP_URL=http://localhost/extrack
```

### 3️⃣ Test Fitur
1. Buka halaman login: `http://localhost/extrack/auth/login.php`
2. Klik link "Lupa Password?"
3. Masukkan email yang terdaftar
4. Cek inbox email
5. Klik link reset password
6. Masukkan password baru
7. Login dengan password baru

## ✅ Fitur yang Tersedia

- ✅ Request reset password via email
- ✅ Token expired dalam 1 jam
- ✅ Rate limiting (max 3x request per jam)
- ✅ Validasi password (min 6 char, 1 angka, 1 huruf)
- ✅ Token hanya bisa digunakan 1x
- ✅ Auto cleanup expired tokens
- ✅ Email template styled dengan tema ExTrack

## 🔗 URL Penting

- **Forgot Password:** `/auth/forgot-password.php`
- **Reset Password:** `/auth/reset-password.php?token=xxx`
- **Login:** `/auth/login.php`

## 📧 Gmail Setup (Jika Pakai Gmail)

1. Buka https://myaccount.google.com/security
2. Enable "2-Step Verification"
3. Klik "App passwords"
4. Generate password untuk "Mail"
5. Copy password ke `.env` → `MAIL_PASSWORD`

## 🐛 Troubleshooting

**Email tidak terkirim?**
- Cek `.env` sudah benar
- Cek Gmail App Password
- Cek port 587 tidak diblokir

**Token tidak valid?**
- Pastikan tabel `password_resets` sudah dibuat
- Cek token belum expired (>1 jam)
- Cek token belum pernah digunakan

**Rate limiting error?**
- Tunggu 1 jam dari request terakhir
- Atau hapus manual dari database

## 📝 Validasi Password Baru

Password harus memenuhi:
- ✅ Minimal 6 karakter
- ✅ Minimal 1 angka (0-9)
- ✅ Minimal 1 huruf (a-z atau A-Z)
- ✅ Tidak boleh sama dengan password lama

Contoh password valid:
- `password123` ✅
- `mypass1` ✅
- `Test123` ✅

Contoh password tidak valid:
- `pass` ❌ (terlalu pendek)
- `password` ❌ (tidak ada angka)
- `123456` ❌ (tidak ada huruf)
- `[password_lama]` ❌ (sama dengan password lama)

## 🎉 Done!

Fitur forgot password siap digunakan!

Untuk dokumentasi lengkap, lihat: `FORGOT_PASSWORD_IMPLEMENTATION.md`
