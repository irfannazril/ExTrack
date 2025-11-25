<?php
// ============================================
// SETTINGS HANDLER
// ============================================

require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../pages/settings.php');
}

$action = $_POST['action'] ?? '';

try {
    switch ($action) {
        case 'update_profile':
            handle_update_profile();
            break;
        case 'change_password':
            handle_change_password();
            break;
        case 'delete_transactions':
            handle_delete_all_transactions();
            break;
        case 'delete_assets':
            handle_delete_all_assets();
            break;
        case 'delete_categories':
            handle_delete_all_categories();
            break;
        case 'delete_account':
            handle_delete_account();
            break;
        default:
            set_flash('error', 'Aksi tidak valid!');
            redirect('../pages/settings.php');
    }
} catch (Exception $e) {
    set_flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
    redirect('../pages/settings.php');
}

function handle_update_profile() {
    global $conn, $user_id;
    
    $username = clean_input($_POST['username'] ?? '');
    
    if (empty($username)) {
        set_flash('error', 'Username wajib diisi!');
        redirect('../pages/settings.php');
    }
    
    // Cek username sudah digunakan user lain
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ? AND user_id != ?");
    $stmt->execute([$username, $user_id]);
    if ($stmt->fetch()) {
        set_flash('error', 'Username sudah digunakan!');
        redirect('../pages/settings.php');
    }
    
    // Handle photo upload
    $profile_photo = null;
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
        $upload_result = upload_profile_photo($_FILES['profile_photo'], $user_id);
        
        if (!$upload_result['success']) {
            set_flash('error', $upload_result['message']);
            redirect('../pages/settings.php');
        }
        
        $profile_photo = $upload_result['filename'];
        
        // Delete old photo
        $stmt = $conn->prepare("SELECT profile_photo FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $old_photo = $stmt->fetch()['profile_photo'];
        if ($old_photo) {
            delete_profile_photo($old_photo);
        }
    }
    
    // Update profile
    if ($profile_photo) {
        $stmt = $conn->prepare("UPDATE users SET username = ?, profile_photo = ? WHERE user_id = ?");
        $stmt->execute([$username, $profile_photo, $user_id]);
        update_session_data('profile_photo', $profile_photo);
    } else {
        $stmt = $conn->prepare("UPDATE users SET username = ? WHERE user_id = ?");
        $stmt->execute([$username, $user_id]);
    }
    
    update_session_data('username', $username);
    
    set_flash('success', 'Profile berhasil diupdate!');
    redirect('../pages/settings.php');
}

function handle_change_password() {
    global $conn, $user_id;
    
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        set_flash('error', 'Semua field wajib diisi!');
        redirect('../pages/settings.php');
    }
    
    if ($new_password !== $confirm_password) {
        set_flash('error', 'Password baru tidak cocok!');
        redirect('../pages/settings.php');
    }
    
    if (strlen($new_password) < 6) {
        set_flash('error', 'Password minimal 6 karakter!');
        redirect('../pages/settings.php');
    }
    
    // Verify current password
    $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    
    if (!verify_password($current_password, $user['password'])) {
        set_flash('error', 'Password lama salah!');
        redirect('../pages/settings.php');
    }
    
    // Update password
    $hashed_password = hash_password($new_password);
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
    $stmt->execute([$hashed_password, $user_id]);
    
    set_flash('success', 'Password berhasil diubah!');
    redirect('../pages/settings.php');
}

function handle_delete_all_transactions() {
    global $conn, $user_id;
    
    // Reset all asset balances to 0
    $stmt = $conn->prepare("UPDATE assets SET balance = 0 WHERE user_id = ?");
    $stmt->execute([$user_id]);
    
    // Delete all transactions
    $stmt = $conn->prepare("DELETE FROM transactions WHERE user_id = ?");
    $stmt->execute([$user_id]);
    
    set_flash('success', 'Semua transaksi berhasil dihapus!');
    redirect('../pages/settings.php');
}

function handle_delete_all_assets() {
    global $conn, $user_id;
    
    // Cek apakah ada transactions
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM transactions WHERE user_id = ?");
    $stmt->execute([$user_id]);
    if ($stmt->fetch()['count'] > 0) {
        set_flash('error', 'Hapus semua transaksi terlebih dahulu!');
        redirect('../pages/settings.php');
    }
    
    $stmt = $conn->prepare("DELETE FROM assets WHERE user_id = ?");
    $stmt->execute([$user_id]);
    
    set_flash('success', 'Semua asset berhasil dihapus!');
    redirect('../pages/settings.php');
}

function handle_delete_all_categories() {
    global $conn, $user_id;
    
    // Hanya hapus custom categories (is_default = 0)
    $stmt = $conn->prepare("DELETE FROM categories WHERE user_id = ? AND is_default = 0");
    $stmt->execute([$user_id]);
    
    set_flash('success', 'Semua kategori custom berhasil dihapus!');
    redirect('../pages/settings.php');
}

function handle_delete_account() {
    global $conn, $user_id;
    
    // Delete profile photo
    $stmt = $conn->prepare("SELECT profile_photo FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $photo = $stmt->fetch()['profile_photo'];
    if ($photo) {
        delete_profile_photo($photo);
    }
    
    // Delete user (cascade akan hapus semua data terkait)
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    
    // Logout
    destroy_user_session();
    delete_remember_me_cookie();
    
    set_flash('success', 'Akun berhasil dihapus!');
    redirect('../index.php');
}
