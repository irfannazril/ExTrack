<?php
// ============================================
// RESEND VERIFICATION EMAIL HANDLER
// ============================================

require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/email.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../auth/login.php');
}

$email = clean_input($_POST['email'] ?? '');

// Validasi
if (empty($email)) {
    set_flash('error', 'Email wajib diisi!');
    redirect('../auth/login.php');
}

if (!validate_email($email)) {
    set_flash('error', 'Format email tidak valid!');
    redirect('../auth/login.php');
}

try {
    // Cari user berdasarkan email
    $stmt = $conn->prepare("SELECT user_id, username, email, is_verified, verification_token, token_expires_at FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if (!$user) {
        set_flash('error', 'Email tidak terdaftar!');
        redirect('../auth/login.php');
    }
    
    // Cek apakah sudah verified
    if ($user['is_verified'] == 1) {
        set_flash('info', 'Email Anda sudah diverifikasi. Silakan login.');
        redirect('../auth/login.php');
    }
    
    // Generate token baru
    $verification_token = generate_token();
    $token_expires_at = date('Y-m-d H:i:s', strtotime('+24 hours'));
    
    // Update token di database
    $stmt = $conn->prepare("UPDATE users SET verification_token = ?, token_expires_at = ? WHERE user_id = ?");
    $stmt->execute([$verification_token, $token_expires_at, $user['user_id']]);
    
    // Kirim email verification
    $email_result = send_verification_email($email, $user['username'], $verification_token);
    
    if ($email_result['success']) {
        set_flash('success', 'Email verifikasi baru telah dikirim! Silakan cek inbox Anda.');
    } else {
        set_flash('error', 'Gagal mengirim email verifikasi. Silakan coba lagi nanti.');
    }
    
    redirect('../auth/login.php');
    
} catch (PDOException $e) {
    set_flash('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
    redirect('../auth/login.php');
}
