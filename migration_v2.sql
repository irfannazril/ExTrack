-- Migration V2 - ExTrack Database Updates
-- Jalankan script ini di HeidiSQL untuk update database

-- ============================================
-- 1. Update tabel users untuk remember me & email verification
-- ============================================
ALTER TABLE users 
ADD COLUMN remember_token VARCHAR(100) DEFAULT NULL AFTER verification_token,
ADD COLUMN token_expires_at DATETIME DEFAULT NULL AFTER remember_token;

-- ============================================
-- 2. Update tabel categories untuk track default categories
-- ============================================
ALTER TABLE categories
ADD COLUMN is_default TINYINT(1) DEFAULT 0 AFTER icon;

-- ============================================
-- 3. Insert default categories (Other Expense & Other Income)
-- ============================================
-- Note: Ini akan dijalankan otomatis saat user register
-- Tapi jika ingin manual insert untuk testing:
-- INSERT INTO categories (user_id, category_name, category_type, icon, is_default) 
-- VALUES (1, 'Lainnya', 'expense', '📦', 1);
-- INSERT INTO categories (user_id, category_name, category_type, icon, is_default) 
-- VALUES (1, 'Lainnya', 'income', '💰', 1);

-- ============================================
-- SELESAI
-- ============================================
