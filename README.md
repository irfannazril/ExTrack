# ExTrack - Expense Tracker Application

Aplikasi pelacak pengeluaran berbasis web menggunakan PHP 8.2 native, Bootstrap, dan MySQL.

## 🚀 Fitur Utama

- ✅ **Authentication System**
  - Login & Register
  - Email Verification (opsional)
  - Remember Me (30 hari)
  - Session Management (24 jam)
  - Logout dengan konfirmasi

- 💰 **Transaction Management**
  - Income, Expense, Transfer
  - Validasi balance (tidak boleh minus)
  - Filter by type (All, Income, Expense, Transfer)
  - Group by date
  - CRUD operations

- 💼 **Asset Management**
  - Multiple assets (Cash, Bank, E-Wallet, dll)
  - Manual balance adjustment
  - Total balance calculation
  - Cannot delete if used in transactions

- 📊 **Statistics & Categories**
  - 2 Pie Charts (Income & Expense) menggunakan Highcharts
  - Custom categories dengan emoji
  - Income & Expense categories
  - Cannot delete if used in transactions

- ⚙️ **Settings**
  - Update profile & username
  - Upload profile photo (max 2MB, auto resize 300x300)
  - Change password
  - Danger zone (delete data)

- 🎨 **UI/UX**
  - Dark theme
  - Responsive design
  - Bootstrap 5.3
  - Auto-hide alerts (10 detik)
  - Loading spinners
  - Confirmation modals

## 📋 Requirements

- PHP 8.2+
- MySQL/MariaDB
- Composer
- Web Server (Apache/Nginx)

## 🛠️ Installation

### 1. Clone/Download Project

```bash
cd C:\xampp\htdocs
# Copy folder extrack ke sini
```

### 2. Install Dependencies

```bash
cd extrack
composer install
```

### 3. Setup Database

1. Buka HeidiSQL atau phpMyAdmin
2. Create database `extrack`
3. Import file `extrack.sql`
4. Jalankan migration `migration_v2.sql`

```sql
-- Di HeidiSQL, jalankan query ini:
SOURCE C:/xampp/htdocs/extrack/extrack.sql;
SOURCE C:/xampp/htdocs/extrack/migration_v2.sql;
```

### 4. Konfigurasi Environment (.env)

Copy file `.env.example` menjadi `.env`:

```bash
copy .env.example .env
```

Edit file `.env` dan sesuaikan konfigurasi:

```env
# Database
DB_HOST=localhost
DB_NAME=extrack
DB_USER=root
DB_PASS=

# Email (untuk verification)
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
```

**Cara mendapatkan App Password Gmail:**
1. Buka Google Account → Security
2. Enable 2-Step Verification
3. Generate App Password
4. Copy 16 digit password ke `MAIL_PASSWORD`

### 5. Jalankan Aplikasi

```bash
# Start Apache & MySQL di XAMPP
# Buka browser:
http://localhost/extrack
```

## 📁 Struktur Folder Baru

```
extrack/
├── assets/              # Frontend assets (CSS, JS, images)
├── auth/                # Authentication pages
│   ├── login.php
│   ├── register.php
│   └── verify-email.php
├── config/              # Configuration files
│   ├── database.php     # Database connection
│   └── email.php        # Email configuration
├── data/                # Data processing
│   ├── get_chart_data.php
│   └── chart_template.php
├── handlers/            # Form handlers (POST processing)
│   ├── login_handler.php
│   ├── register_handler.php
│   ├── logout_handler.php
│   ├── transaction_handler.php
│   ├── asset_handler.php
│   ├── category_handler.php
│   └── settings_handler.php
├── includes/            # Reusable components
│   ├── functions.php    # Helper functions
│   ├── session.php      # Session management
│   ├── auth_check.php   # Auth protection
│   ├── sidebar.php      # Sidebar component
│   └── alert.php        # Alert component
├── pages/               # Main application pages
│   ├── dashboard.php
│   ├── transactions.php
│   ├── assets.php
│   ├── statistics.php
│   └── settings.php
├── uploads/             # User uploads
│   └── profiles/        # Profile photos
├── vendor/              # Composer dependencies
├── index.php            # Landing page (entry point)
├── composer.json
├── extrack.sql          # Database schema
├── migration_v2.sql     # Database migration
└── README.md
```

## 🔐 Default Login (Untuk Testing)

Setelah register, gunakan akun yang Anda buat.

**Catatan:** Email verification bersifat opsional. Anda bisa langsung login tanpa verifikasi email.

## 📝 Cara Penggunaan

### 1. Register & Login

1. Buka `http://localhost/extrack`
2. Klik "Get Started" atau "Sign Up"
3. Isi form registrasi
4. Login dengan email & password

### 2. Tambah Asset

1. Masuk ke halaman "Assets"
2. Klik "Add Asset"
3. Isi nama asset dan balance awal
4. Save

### 3. Tambah Category

1. Masuk ke halaman "Statistics"
2. Klik "Add Category"
3. Pilih type (Income/Expense)
4. Pilih emoji (Windows + .)
5. Isi nama category
6. Save

### 4. Tambah Transaction

1. Masuk ke halaman "Transactions"
2. Klik "Add Transaction"
3. Pilih type (Income/Expense/Transfer)
4. Isi amount, description, category, asset, date
5. Save

**Validasi:**
- Expense: Balance asset harus cukup
- Transfer: Balance from_asset harus cukup
- Balance tidak boleh minus

### 5. Lihat Statistics

1. Masuk ke halaman "Statistics"
2. Lihat 2 pie charts (Income & Expense)
3. Manage categories

### 6. Settings

1. Update profile & photo
2. Change password
3. Danger zone (delete data/account)

## 🎨 Customization

### Ubah Warna Theme

Edit `assets/css/style.css`:

```css
:root {
  --primary-color: #4e9f3d;  /* Hijau */
  --secondary-color: #1e5128;
}
```

### Ubah Session Timeout

Edit `includes/session.php`:

```php
ini_set('session.gc_maxlifetime', 86400); // 24 jam
```

### Ubah Remember Me Duration

Edit `includes/session.php`:

```php
$expire = time() + (30 * 24 * 60 * 60); // 30 hari
```

## 🐛 Troubleshooting

### Error: "Database connection failed"

- Cek MySQL sudah running
- Cek credentials di `config/database.php`
- Pastikan database `extrack` sudah dibuat

### Error: "Failed to upload photo"

- Cek folder `uploads/profiles/` ada dan writable
- Cek file size < 2MB
- Cek format JPG/PNG/GIF

### Email verification tidak terkirim

- Cek konfigurasi di `config/email.php`
- Pastikan App Password Gmail benar
- Email verification bersifat opsional, bisa skip

### Session expired terus

- Cek `session.gc_maxlifetime` di `includes/session.php`
- Clear browser cookies
- Restart Apache

## 📚 Tech Stack

- **Backend:** PHP 8.2 (Procedural)
- **Database:** MySQL/MariaDB
- **Frontend:** HTML5, CSS3, JavaScript
- **Framework:** Bootstrap 5.3
- **Icons:** Bootstrap Icons
- **Charts:** Highcharts
- **Email:** PHPMailer

## 🔒 Security Features

- Password hashing (bcrypt)
- SQL injection protection (PDO prepared statements)
- XSS protection (htmlspecialchars)
- CSRF protection (session validation)
- File upload validation
- Session regeneration
- Remember me token

## 📄 License

This project is for educational purposes.

## 👨‍💻 Developer

**Irfan Nazril**
- GitHub: [@irfannazril](https://github.com/irfannazril)
- Email: irfannazrilasdf@gmail.com

## 🙏 Credits

- Bootstrap Team
- Highcharts
- PHPMailer
- Bootstrap Icons

---

**Happy Tracking! 💰📊**
