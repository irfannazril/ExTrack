<?php
// ============================================
// CATEGORY HANDLER - Add, Edit, Delete
// ============================================

require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../pages/statistics.php');
}

$action = $_POST['action'] ?? '';

try {
    switch ($action) {
        case 'add':
            handle_add_category();
            break;
        case 'edit':
            handle_edit_category();
            break;
        case 'delete':
            handle_delete_category();
            break;
        default:
            set_flash('error', 'Aksi tidak valid!');
            redirect('../pages/statistics.php');
    }
} catch (Exception $e) {
    set_flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
    redirect('../pages/statistics.php');
}

function handle_add_category() {
    global $conn, $user_id;
    
    $category_name = clean_input($_POST['category_name'] ?? '');
    $category_type = $_POST['category_type'] ?? '';
    $icon = clean_input($_POST['icon'] ?? '');
    
    if (empty($category_name)) {
        set_flash('error', 'Nama kategori wajib diisi!');
        redirect('../pages/statistics.php');
    }
    
    if (!in_array($category_type, ['income', 'expense'])) {
        set_flash('error', 'Tipe kategori tidak valid!');
        redirect('../pages/statistics.php');
    }
    
    if (empty($icon)) {
        set_flash('error', 'Icon wajib diisi!');
        redirect('../pages/statistics.php');
    }
    
    // Validasi icon hanya 1 karakter emoji
    if (mb_strlen($icon) > 2) {
        set_flash('error', 'Icon hanya boleh 1 emoji!');
        redirect('../pages/statistics.php');
    }
    
    $stmt = $conn->prepare("INSERT INTO categories (user_id, category_name, category_type, icon, is_default) VALUES (?, ?, ?, ?, 0)");
    $stmt->execute([$user_id, $category_name, $category_type, $icon]);
    
    set_flash('success', 'Kategori berhasil ditambahkan!');
    redirect('../pages/statistics.php');
}

function handle_edit_category() {
    global $conn, $user_id;
    
    $category_id = intval($_POST['category_id'] ?? 0);
    $category_name = clean_input($_POST['category_name'] ?? '');
    $icon = clean_input($_POST['icon'] ?? '');
    
    if (empty($category_name)) {
        set_flash('error', 'Nama kategori wajib diisi!');
        redirect('../pages/statistics.php');
    }
    
    if (empty($icon)) {
        set_flash('error', 'Icon wajib diisi!');
        redirect('../pages/statistics.php');
    }
    
    if (mb_strlen($icon) > 2) {
        set_flash('error', 'Icon hanya boleh 1 emoji!');
        redirect('../pages/statistics.php');
    }
    
    // Cek ownership
    $stmt = $conn->prepare("SELECT category_id FROM categories WHERE category_id = ? AND user_id = ?");
    $stmt->execute([$category_id, $user_id]);
    if (!$stmt->fetch()) {
        set_flash('error', 'Kategori tidak ditemukan!');
        redirect('../pages/statistics.php');
    }
    
    $stmt = $conn->prepare("UPDATE categories SET category_name = ?, icon = ? WHERE category_id = ? AND user_id = ?");
    $stmt->execute([$category_name, $icon, $category_id, $user_id]);
    
    set_flash('success', 'Kategori berhasil diupdate!');
    redirect('../pages/statistics.php');
}

function handle_delete_category() {
    global $conn, $user_id;
    
    $category_id = intval($_POST['category_id'] ?? 0);
    
    // Cek apakah category digunakan di transactions
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM transactions WHERE category_id = ? AND user_id = ?");
    $stmt->execute([$category_id, $user_id]);
    $result = $stmt->fetch();
    
    if ($result['count'] > 0) {
        set_flash('error', 'Kategori tidak bisa dihapus karena masih digunakan di transaksi!');
        redirect('../pages/statistics.php');
    }
    
    $stmt = $conn->prepare("DELETE FROM categories WHERE category_id = ? AND user_id = ?");
    $stmt->execute([$category_id, $user_id]);
    
    set_flash('success', 'Kategori berhasil dihapus!');
    redirect('../pages/statistics.php');
}
