<?php
// ============================================
// FORGOT PASSWORD HANDLER
// ============================================

require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/email.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../auth/forgot-password.php');
}

// Ambil email dari form
$email = clean_input($_POST['email'] ?? '');

// Validasi input
if (empty($email)) {
    set_flash('error', 'Email wajib diisi!');
    redirect('../auth/forgot-password.php');
}

if (!validate_email($email)) {
    set_flash('error', 'Format email tidak valid!');
    redirect('../auth/forgot-password.php');
}

try {
    // Cek apakah email terdaftar
    $stmt = $conn->prepare("SELECT user_id, username, email FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        // Untuk keamanan, tetap tampilkan pesan sukses meskipun email tidak terdaftar
        set_flash('success', 'Jika email terdaftar, link reset password akan dikirim ke email Anda.');
        redirect('../auth/forgot-password.php');
    }

    // Rate limiting: Cek berapa kali user request dalam 1 jam terakhir
    $stmt = $conn->prepare("
        SELECT COUNT(*) as request_count 
        FROM password_resets 
        WHERE email = ? 
        AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)
    ");
    $stmt->execute([$email]);
    $rate_limit = $stmt->fetch();

    if ($rate_limit['request_count'] >= 3) {
        // Hitung waktu tunggu
        $stmt = $conn->prepare("
            SELECT created_at 
            FROM password_resets 
            WHERE email = ? 
            ORDER BY created_at DESC 
            LIMIT 1
        ");
        $stmt->execute([$email]);
        $last_request = $stmt->fetch();
        
        $wait_until = strtotime($last_request['created_at']) + 3600; // +1 jam
        $minutes_left = ceil(($wait_until - time()) / 60);
        
        set_flash('error', "Terlalu banyak permintaan reset password. Silakan coba lagi dalam {$minutes_left} menit.");
        redirect('../auth/forgot-password.php');
    }

    // Auto-delete token yang sudah expired (cleanup)
    $stmt = $conn->prepare("DELETE FROM password_resets WHERE expires_at < NOW()");
    $stmt->execute();

    // Generate reset token
    $reset_token = generate_token();
    $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

    // Simpan token ke database
    $stmt = $conn->prepare("
        INSERT INTO password_resets (email, token, expires_at) 
        VALUES (?, ?, ?)
    ");
    $stmt->execute([$email, $reset_token, $expires_at]);

    // Kirim email reset password
    $email_result = send_password_reset_email($email, $user['username'], $reset_token);

    if (!$email_result['success']) {
        error_log('Email reset password gagal: ' . $email_result['message']);
        set_flash('error', 'Gagal mengirim email. Silakan coba lagi atau hubungi admin.');
        redirect('../auth/forgot-password.php');
    }

    set_flash('success', 'Link reset password telah dikirim ke email Anda. Silakan cek inbox atau folder spam.');
    redirect('../auth/forgot-password.php');

} catch (PDOException $e) {
    error_log('Forgot password error: ' . $e->getMessage());
    
    // Tampilkan error lebih spesifik untuk debugging
    if (strpos($e->getMessage(), 'password_resets') !== false) {
        set_flash('error', 'Tabel password_resets belum dibuat. Silakan jalankan file database/password_resets_table.sql terlebih dahulu.');
    } else {
        set_flash('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
    }
    redirect('../auth/forgot-password.php');
} catch (Exception $e) {
    error_log('Forgot password error (general): ' . $e->getMessage());
    set_flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
    redirect('../auth/forgot-password.php');
}
