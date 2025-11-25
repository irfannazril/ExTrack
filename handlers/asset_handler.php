<?php
// ============================================
// ASSET HANDLER - Add, Edit, Delete
// ============================================

require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../pages/assets.php');
}

$action = $_POST['action'] ?? '';

try {
    switch ($action) {
        case 'add':
            handle_add_asset();
            break;
        case 'edit':
            handle_edit_asset();
            break;
        case 'delete':
            handle_delete_asset();
            break;
        default:
            set_flash('error', 'Aksi tidak valid!');
            redirect('../pages/assets.php');
    }
} catch (Exception $e) {
    set_flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
    redirect('../pages/assets.php');
}

function handle_add_asset() {
    global $conn, $user_id;
    
    $asset_name = clean_input($_POST['asset_name'] ?? '');
    $balance = floatval($_POST['balance'] ?? 0);
    
    if (empty($asset_name)) {
        set_flash('error', 'Nama asset wajib diisi!');
        redirect('../pages/assets.php');
    }
    
    if ($balance < 0) {
        set_flash('error', 'Balance tidak boleh negatif!');
        redirect('../pages/assets.php');
    }
    
    $stmt = $conn->prepare("INSERT INTO assets (user_id, asset_name, balance) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $asset_name, $balance]);
    
    set_flash('success', 'Asset berhasil ditambahkan!');
    redirect('../pages/assets.php');
}

function handle_edit_asset() {
    global $conn, $user_id;
    
    $asset_id = intval($_POST['asset_id'] ?? 0);
    $asset_name = clean_input($_POST['asset_name'] ?? '');
    $balance = floatval($_POST['balance'] ?? 0);
    
    if (empty($asset_name)) {
        set_flash('error', 'Nama asset wajib diisi!');
        redirect('../pages/assets.php');
    }
    
    if ($balance < 0) {
        set_flash('error', 'Balance tidak boleh negatif!');
        redirect('../pages/assets.php');
    }
    
    // Cek ownership
    $stmt = $conn->prepare("SELECT asset_id FROM assets WHERE asset_id = ? AND user_id = ?");
    $stmt->execute([$asset_id, $user_id]);
    if (!$stmt->fetch()) {
        set_flash('error', 'Asset tidak ditemukan!');
        redirect('../pages/assets.php');
    }
    
    $stmt = $conn->prepare("UPDATE assets SET asset_name = ?, balance = ? WHERE asset_id = ? AND user_id = ?");
    $stmt->execute([$asset_name, $balance, $asset_id, $user_id]);
    
    set_flash('success', 'Asset berhasil diupdate!');
    redirect('../pages/assets.php');
}

function handle_delete_asset() {
    global $conn, $user_id;
    
    $asset_id = intval($_POST['asset_id'] ?? 0);
    
    // Cek apakah asset digunakan di transactions
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM transactions WHERE (asset_id = ? OR from_asset_id = ? OR to_asset_id = ?) AND user_id = ?");
    $stmt->execute([$asset_id, $asset_id, $asset_id, $user_id]);
    $result = $stmt->fetch();
    
    if ($result['count'] > 0) {
        set_flash('error', 'Asset tidak bisa dihapus karena masih digunakan di transaksi!');
        redirect('../pages/assets.php');
    }
    
    $stmt = $conn->prepare("DELETE FROM assets WHERE asset_id = ? AND user_id = ?");
    $stmt->execute([$asset_id, $user_id]);
    
    set_flash('success', 'Asset berhasil dihapus!');
    redirect('../pages/assets.php');
}
