<?php
// ============================================
// LOGIN HANDLER
// ============================================

require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../auth/login.php');
}

// Ambil data dari form
$email = clean_input($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$remember_me = isset($_POST['remember_me']);

// Validasi input
if (empty($email) || empty($password)) {
    set_flash('error', 'Email dan password wajib diisi!');
    redirect('../auth/login.php');
}

if (!validate_email($email)) {
    set_flash('error', 'Format email tidak valid!');
    redirect('../auth/login.php');
}

try {
    // Cari user berdasarkan email
    $stmt = $conn->prepare("SELECT user_id, username, email, password, profile_photo, is_verified FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if (!$user) {
        set_flash('error', 'Email tidak terdaftar!');
        redirect('../auth/login.php');
    }
    
    // Verify password
    if (!verify_password($password, $user['password'])) {
        set_flash('error', 'Password salah!');
        redirect('../auth/login.php');
    }
    
    // Check email verification (wajib)
    if ($user['is_verified'] == 0) {
        set_flash('error', 'Email Anda belum diverifikasi! Silakan cek email Anda untuk link verifikasi.');
        redirect('../auth/login.php');
    }
    
    // Set session
    set_user_session($user);
    
    // Remember me
    if ($remember_me) {
        $token = generate_token();
        $expires = date('Y-m-d H:i:s', strtotime('+30 days'));
        
        // Simpan token ke database
        $stmt = $conn->prepare("UPDATE users SET remember_token = ?, token_expires_at = ? WHERE user_id = ?");
        $stmt->execute([$token, $expires, $user['user_id']]);
        
        // Set cookie
        set_remember_me_cookie($user['user_id'], $token);
    }
    
    set_flash('success', 'Login berhasil! Selamat datang, ' . $user['username'] . '!');
    redirect('../pages/dashboard.php');
    
} catch (PDOException $e) {
    set_flash('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
    redirect('../auth/login.php');
}
