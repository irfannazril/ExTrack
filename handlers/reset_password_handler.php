<?php
// ============================================
// RESET PASSWORD HANDLER
// ============================================

require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../auth/forgot-password.php');
}

// Ambil data dari form
$token = clean_input($_POST['token'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Validasi input
if (empty($token) || empty($password) || empty($confirm_password)) {
    set_flash('error', 'Semua field wajib diisi!');
    redirect("../auth/reset-password.php?token=$token");
}

// Validasi password match
if ($password !== $confirm_password) {
    set_flash('error', 'Password tidak cocok!');
    redirect("../auth/reset-password.php?token=$token");
}

// Validasi panjang password
if (strlen($password) < 6) {
    set_flash('error', 'Password minimal 6 karakter!');
    redirect("../auth/reset-password.php?token=$token");
}

// Validasi password harus ada minimal 1 angka
if (!preg_match('/[0-9]/', $password)) {
    set_flash('error', 'Password harus mengandung minimal 1 angka!');
    redirect("../auth/reset-password.php?token=$token");
}

// Validasi password harus ada minimal 1 huruf
if (!preg_match('/[a-zA-Z]/', $password)) {
    set_flash('error', 'Password harus mengandung minimal 1 huruf!');
    redirect("../auth/reset-password.php?token=$token");
}

try {
    // Validasi token
    $stmt = $conn->prepare("
        SELECT pr.*, u.user_id, u.email 
        FROM password_resets pr
        JOIN users u ON pr.email = u.email
        WHERE pr.token = ? AND pr.is_used = 0
    ");
    $stmt->execute([$token]);
    $reset_data = $stmt->fetch();

    if (!$reset_data) {
        set_flash('error', 'Token tidak valid atau sudah digunakan.');
        redirect('../auth/forgot-password.php');
    }

    // Cek apakah token sudah expired
    if (strtotime($reset_data['expires_at']) < time()) {
        set_flash('error', 'Token sudah kadaluarsa. Silakan request link baru.');
        redirect('../auth/forgot-password.php');
    }

    // Ambil password lama dari database
    $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->execute([$reset_data['user_id']]);
    $user_data = $stmt->fetch();
    $old_password_hash = $user_data['password'];

    // Cek apakah password baru sama dengan password lama
    if (password_verify($password, $old_password_hash)) {
        set_flash('error', 'Password baru tidak boleh sama dengan password lama!');
        redirect("../auth/reset-password.php?token=$token");
    }

    // Hash password baru
    $hashed_password = hash_password($password);

    // Update password user
    $stmt = $conn->prepare("UPDATE users SET password = ?, updated_at = NOW() WHERE user_id = ?");
    $stmt->execute([$hashed_password, $reset_data['user_id']]);

    // Tandai token sebagai sudah digunakan
    $stmt = $conn->prepare("UPDATE password_resets SET is_used = 1 WHERE token = ?");
    $stmt->execute([$token]);

    // Auto-delete token yang sudah expired (cleanup)
    $stmt = $conn->prepare("DELETE FROM password_resets WHERE expires_at < NOW()");
    $stmt->execute();

    // Hapus semua remember token untuk user ini (force logout dari semua device)
    $stmt = $conn->prepare("UPDATE users SET remember_token = NULL WHERE user_id = ?");
    $stmt->execute([$reset_data['user_id']]);

    set_flash('success', 'Password berhasil direset! Silakan login dengan password baru Anda.');
    redirect('../auth/login.php');

} catch (PDOException $e) {
    error_log('Reset password error: ' . $e->getMessage());
    set_flash('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
    redirect("../auth/reset-password.php?token=$token");
}
