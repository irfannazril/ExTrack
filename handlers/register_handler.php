<?php
// ============================================
// REGISTER HANDLER
// ============================================

require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/database.php';

// Import email functions
require_once __DIR__ . '/../config/email.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../auth/register.php');
}

// Ambil data dari form
$username = clean_input($_POST['username'] ?? '');
$email = clean_input($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Validasi input
if (empty($username) || empty($email) || empty($password)) {
    set_flash('error', 'Semua field wajib diisi!');
    redirect('../auth/register.php');
}

if (!validate_email($email)) {
    set_flash('error', 'Format email tidak valid!');
    redirect('../auth/register.php');
}

if ($password !== $confirm_password) {
    set_flash('error', 'Password tidak cocok!');
    redirect('../auth/register.php');
}

if (strlen($password) < 6) {
    set_flash('error', 'Password minimal 6 karakter!');
    redirect('../auth/register.php');
}

try {
    // Cek email sudah terdaftar
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        set_flash('error', 'Email sudah terdaftar!');
        redirect('../auth/register.php');
    }
    
    // Cek username sudah digunakan
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        set_flash('error', 'Username sudah digunakan!');
        redirect('../auth/register.php');
    }
    
    // Hash password
    $hashed_password = hash_password($password);
    
    // Generate verification token
    $verification_token = generate_token();
    $token_expires_at = date('Y-m-d H:i:s', strtotime('+24 hours'));
    
    // Insert user baru (is_verified = 0 karena opsional)
    $stmt = $conn->prepare("
        INSERT INTO users (username, email, password, is_verified, verification_token, token_expires_at) 
        VALUES (?, ?, ?, 0, ?, ?)
    ");
    $stmt->execute([$username, $email, $hashed_password, $verification_token, $token_expires_at]);
    $user_id = $conn->lastInsertId();
    
    // Buat default categories (Other Expense & Other Income)
    $stmt = $conn->prepare("
        INSERT INTO categories (user_id, category_name, category_type, icon, is_default) 
        VALUES (?, ?, ?, ?, 1)
    ");
    
    $stmt->execute([$user_id, 'Lainnya', 'expense', '📦']);
    $stmt->execute([$user_id, 'Lainnya', 'income', '💰']);
    
    // Buat default asset (Dompet Saya)
    $stmt = $conn->prepare("
        INSERT INTO assets (user_id, asset_name, balance) 
        VALUES (?, 'Dompet Saya', 0)
    ");
    $stmt->execute([$user_id]);
    
    // Kirim email verification (opsional, tidak blocking)
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'malingpangsitasdf@gmail.com';
        $mail->Password = 'thyzktvvgdcjcnla';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        $mail->setFrom('noreply@extrack.com', 'ExTrack');
        $mail->addAddress($email, $username);
        $mail->isHTML(true);
        $mail->Subject = 'Verifikasi Email Anda - ExTrack';
        
        $verification_link = "http://localhost/extrack/auth/verify-email.php?token=" . $verification_token;
        
        $mail->Body = "
            <h2>Selamat datang di ExTrack, $username!</h2>
            <p>Terima kasih telah mendaftar. Silakan verifikasi email Anda dengan klik tombol di bawah:</p>
            <p><a href='$verification_link' style='background: #4e9f3d; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;'>Verifikasi Email</a></p>
            <p>Atau copy link ini: $verification_link</p>
            <p>Link ini akan kadaluarsa dalam 24 jam.</p>
        ";
        
        $mail->send();
    } catch (Exception $e) {
        // Email gagal kirim, tapi registrasi tetap berhasil
        error_log('Email verification gagal: ' . $e->getMessage());
    }
    
    set_flash('success', 'Registrasi berhasil! Silakan login.');
    redirect('../auth/login.php');
    
} catch (PDOException $e) {
    set_flash('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
    redirect('../auth/register.php');
}
