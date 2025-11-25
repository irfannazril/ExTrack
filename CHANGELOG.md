# Changelog - ExTrack

## Version 2.0.0 - Backend Refactor (25 Nov 2025)

### 🎉 Major Changes

#### Struktur Project
- ✅ Refactor struktur folder menjadi lebih terorganisir
- ✅ Pisahkan auth pages, main pages, dan handlers
- ✅ Buat reusable components (sidebar, alert)
- ✅ Ubah dari OOP ke Procedural PHP (lebih mudah dipahami pemula)

#### Authentication System
- ✅ Login dengan form POST (bukan JSON API)
- ✅ Register dengan email verification (opsional)
- ✅ Remember Me (30 hari)
- ✅ Session management (24 jam)
- ✅ Logout dengan confirmation modal
- ✅ Auto-login via remember me cookie

#### Transaction Management
- ✅ CRUD transactions (Income, Expense, Transfer)
- ✅ Validasi balance (tidak boleh minus)
- ✅ Filter by type dengan tabs
- ✅ Group transactions by date
- ✅ Default transaction date = hari ini
- ✅ Balance adjustment otomatis saat add/edit/delete

#### Asset Management
- ✅ CRUD assets
- ✅ Manual balance adjustment dengan warning
- ✅ Total balance calculation
- ✅ Validasi: tidak bisa delete jika digunakan di transactions

#### Categories & Statistics
- ✅ Custom categories dengan emoji (Income & Expense)
- ✅ 2 Pie charts (Income & Expense) menggunakan Highcharts
- ✅ Default categories saat register (Lainnya - Income & Expense)
- ✅ Validasi: tidak bisa delete jika digunakan di transactions
- ✅ Emoji input dengan hint (Windows + .)

#### Settings
- ✅ Update profile & username
- ✅ Upload profile photo (max 2MB, auto resize 300x300)
- ✅ UI Avatars untuk default profile photo
- ✅ Change password
- ✅ Danger zone: delete transactions, assets, categories, account
- ✅ Confirmation dengan ketik "DELETE"

#### UI/UX Improvements
- ✅ Auto-hide alerts (10 detik)
- ✅ Loading spinners pada form submit
- ✅ Confirmation modals untuk delete actions
- ✅ Logout confirmation modal
- ✅ Bootstrap alerts dengan close button
- ✅ Responsive sidebar
- ✅ Dark theme

#### Database
- ✅ Migration V2 untuk field tambahan
- ✅ remember_token & token_expires_at
- ✅ is_default untuk categories
- ✅ Cascade delete untuk relasi

#### Security
- ✅ Password hashing (bcrypt)
- ✅ SQL injection protection (PDO prepared statements)
- ✅ XSS protection (htmlspecialchars)
- ✅ File upload validation
- ✅ Session regeneration
- ✅ Remember me token validation

### 📝 Files Created

**Core Files:**
- `config/database.php` - Database connection
- `includes/functions.php` - Helper functions
- `includes/session.php` - Session management
- `includes/auth_check.php` - Auth protection
- `includes/sidebar.php` - Sidebar component
- `includes/alert.php` - Alert component

**Handlers:**
- `handlers/login_handler.php`
- `handlers/register_handler.php`
- `handlers/logout_handler.php`
- `handlers/transaction_handler.php`
- `handlers/asset_handler.php`
- `handlers/category_handler.php`
- `handlers/settings_handler.php`

**Auth Pages:**
- `auth/login.php`
- `auth/register.php`
- `auth/verify-email.php`

**Main Pages:**
- `pages/dashboard.php`
- `pages/transactions.php`
- `pages/assets.php`
- `pages/statistics.php`
- `pages/settings.php`

**Data Files:**
- `data/get_chart_data.php` - API untuk chart data
- `data/chart_template.php` - Highcharts template

**Others:**
- `index.php` - Landing page (entry point)
- `migration_v2.sql` - Database migration
- `README.md` - Documentation
- `.gitignore` - Git ignore rules
- `CHANGELOG.md` - This file

### 🗑️ Files Removed/Deprecated

- `controller/database.php` - Replaced with `config/database.php`
- `controller/reg-auth.php` - Replaced with `handlers/register_handler.php`
- `controller/verify-email.php` - Moved to `auth/verify-email.php`
- `public/welcome.php` - Merged into `index.php`
- `public/test.php` - Removed (sandbox file)

### 🔄 Files Moved

- `public/index.php` → `pages/dashboard.php`
- `public/transaction.php` → `pages/transactions.php`
- `public/assets.php` → `pages/assets.php`
- `public/statistics.php` → `pages/statistics.php`
- `public/settings.php` → `pages/settings.php`
- `public/login.php` → `auth/login.php`
- `public/register.php` → `auth/register.php`

### 🐛 Bug Fixes

- Fixed balance calculation saat edit/delete transaction
- Fixed category filter by type
- Fixed asset validation saat delete
- Fixed session timeout issue
- Fixed profile photo upload path

### 📚 Documentation

- Added comprehensive README.md
- Added installation instructions
- Added usage guide
- Added troubleshooting section
- Added CHANGELOG.md

---

## Version 1.0.0 - Initial Release

### Features
- Basic frontend dengan Bootstrap
- Database schema
- Dummy data untuk testing
- Landing page
- Auth pages (frontend only)
- Dashboard layout
- Transaction layout
- Assets layout
- Statistics layout dengan Highcharts dummy
- Settings layout

---

**Note:** Version 2.0.0 adalah major refactor yang mengubah hampir seluruh backend dari OOP ke Procedural dan menambahkan semua fitur yang functional.
