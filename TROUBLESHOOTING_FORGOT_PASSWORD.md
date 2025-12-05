# 🔧 Troubleshooting - Forgot Password

## 🚨 Error: "Terjadi kesalahan sistem. Silakan coba lagi."

### Kemungkinan Penyebab:

#### 1. **Tabel `password_resets` Belum Dibuat**

**Gejala:**
- Error muncul saat submit form forgot password
- Pesan: "Terjadi kesalahan sistem"

**Solusi:**
1. Buka phpMyAdmin atau HeidiSQL
2. Pilih database `extrack`
3. Klik tab "SQL"
4. Copy-paste isi file `database/password_resets_table.sql`
5. Klik "Go" atau "Execute"

**Via Command Line:**
```bash
mysql -u root -p extrack < database/password_resets_table.sql
```

**Cek apakah tabel sudah ada:**
```sql
SHOW TABLES LIKE 'password_resets';
```

---

#### 2. **Konfigurasi Email Salah/Tidak Lengkap**

**Gejala:**
- Email tidak terkirim
- Error log menunjukkan SMTP error

**Solusi:**

1. **Cek file `.env`:**
   ```env
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your-email@gmail.com
   MAIL_PASSWORD=your-app-password
   MAIL_FROM_ADDRESS=noreply@extrack.com
   MAIL_FROM_NAME=ExTrack
   APP_URL=http://localhost/extrack
   ```

2. **Pastikan menggunakan Gmail App Password:**
   - Buka: https://myaccount.google.com/security
   - Enable "2-Step Verification"
   - Klik "App passwords"
   - Generate password untuk "Mail"
   - Copy 16 digit password (tanpa spasi)
   - Paste ke `.env` → `MAIL_PASSWORD`

3. **JANGAN gunakan password Gmail biasa!**
   - Gmail akan block jika pakai password biasa
   - Harus pakai App Password

---

#### 3. **PHPMailer Tidak Terinstall**

**Gejala:**
- Error: "Class 'PHPMailer' not found"

**Solusi:**
```bash
cd C:\xampp\htdocs\extrack
composer install
```

---

#### 4. **Port 587 Diblokir Firewall**

**Gejala:**
- Email tidak terkirim
- Timeout error

**Solusi:**
1. Buka Windows Firewall
2. Allow port 587 (SMTP)
3. Atau coba ganti port ke 465 di `.env`:
   ```env
   MAIL_PORT=465
   ```
4. Update `config/email.php`:
   ```php
   $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Ganti dari STARTTLS
   ```

---

## 🔍 Cara Debug

### 1. **Gunakan Checker Tool**

Buka di browser:
```
http://localhost/extrack/check_forgot_password_setup.php
```

Tool ini akan mengecek:
- ✅ Database connection
- ✅ Tabel password_resets
- ✅ Email configuration
- ✅ PHPMailer installation
- ✅ Test send email

### 2. **Cek Error Log**

**PHP Error Log:**
```
C:\xampp\php\logs\php_error_log
```

**Apache Error Log:**
```
C:\xampp\apache\logs\error.log
```

**Enable PHP Error Display:**
1. Buka `C:\xampp\php\php.ini`
2. Cari `display_errors = Off`
3. Ubah jadi `display_errors = On`
4. Restart Apache

### 3. **Test Email Manual**

Buka di browser:
```
http://localhost/extrack/test_send_email.php
```

Masukkan email Anda dan klik "Test Send Email"

---

## 📧 Email Tidak Terkirim

### Checklist:

- [ ] Tabel `password_resets` sudah dibuat
- [ ] File `.env` sudah ada dan terisi lengkap
- [ ] `MAIL_USERNAME` = email Gmail Anda
- [ ] `MAIL_PASSWORD` = App Password (16 digit, bukan password biasa)
- [ ] `APP_URL` = URL aplikasi Anda (http://localhost/extrack)
- [ ] PHPMailer sudah terinstall (`composer install`)
- [ ] Port 587 tidak diblokir firewall
- [ ] Koneksi internet aktif
- [ ] Gmail 2-Step Verification sudah aktif

### Test Koneksi SMTP:

```php
<?php
// test_smtp.php
require_once 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'your-email@gmail.com';
$mail->Password = 'your-app-password';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;
$mail->SMTPDebug = 2; // Enable verbose debug output

try {
    $mail->smtpConnect();
    echo "✅ SMTP Connection successful!";
} catch (Exception $e) {
    echo "❌ SMTP Connection failed: " . $e->getMessage();
}
?>
```

---

## 🔐 Token Tidak Valid

### Gejala:
- Link di email tidak berfungsi
- Error: "Token tidak valid atau sudah digunakan"

### Penyebab & Solusi:

#### 1. **Token Sudah Digunakan**
- Token hanya bisa digunakan 1x
- Jika sudah reset password, token otomatis invalid
- **Solusi:** Request link baru

#### 2. **Token Expired (>1 jam)**
- Token kadaluarsa setelah 1 jam
- **Solusi:** Request link baru

#### 3. **Token Tidak Ada di Database**
- Mungkin terhapus atau tidak tersimpan
- **Solusi:** Request link baru

#### 4. **URL Tidak Lengkap**
- Link di email terpotong
- **Solusi:** Copy full URL dari email

---

## ⏱️ Rate Limiting Error

### Gejala:
- Error: "Terlalu banyak permintaan reset password"
- Tidak bisa request lagi

### Penyebab:
- Sudah request 3x dalam 1 jam

### Solusi:

**Opsi 1: Tunggu**
- Tunggu sampai 1 jam dari request pertama

**Opsi 2: Hapus Manual dari Database**
```sql
-- Hapus semua request untuk email tertentu
DELETE FROM password_resets WHERE email = 'your-email@example.com';

-- Atau hapus semua yang sudah expired
DELETE FROM password_resets WHERE expires_at < NOW();
```

---

## 🐛 Error Lainnya

### "Failed to connect to smtp.gmail.com"

**Penyebab:**
- Koneksi internet bermasalah
- Port diblokir
- Gmail credentials salah

**Solusi:**
1. Cek koneksi internet
2. Ping smtp.gmail.com
3. Cek firewall
4. Cek credentials di `.env`

### "SMTP Error: Could not authenticate"

**Penyebab:**
- Password salah
- Bukan App Password
- 2-Step Verification belum aktif

**Solusi:**
1. Generate App Password baru
2. Copy-paste dengan benar (tanpa spasi)
3. Pastikan 2-Step Verification aktif

### "Message could not be sent"

**Penyebab:**
- Email tujuan tidak valid
- SMTP server down
- Rate limit Gmail

**Solusi:**
1. Cek email tujuan valid
2. Coba lagi nanti
3. Cek Gmail quota (max 500 email/day)

---

## 📞 Masih Bermasalah?

1. **Jalankan checker:**
   ```
   http://localhost/extrack/check_forgot_password_setup.php
   ```

2. **Test email:**
   ```
   http://localhost/extrack/test_send_email.php
   ```

3. **Cek error log:**
   - PHP: `C:\xampp\php\logs\php_error_log`
   - Apache: `C:\xampp\apache\logs\error.log`

4. **Enable debug mode:**
   - Edit `handlers/forgot_password_handler.php`
   - Uncomment error display untuk debugging

5. **Contact:**
   - GitHub: [@irfannazril](https://github.com/irfannazril)
   - Email: irfannazrilasdf@gmail.com

---

## ✅ Checklist Setup

Pastikan semua ini sudah dilakukan:

- [ ] Import `database/password_resets_table.sql`
- [ ] File `.env` sudah ada dan terisi lengkap
- [ ] Gmail App Password sudah dibuat
- [ ] `composer install` sudah dijalankan
- [ ] Apache & MySQL running
- [ ] Test email berhasil terkirim
- [ ] Link forgot password muncul di login page
- [ ] Form forgot password bisa diakses
- [ ] Email reset password terkirim
- [ ] Link di email berfungsi
- [ ] Form reset password bisa diakses
- [ ] Password berhasil direset
- [ ] Bisa login dengan password baru

---

**Last Updated:** 4 Desember 2025
