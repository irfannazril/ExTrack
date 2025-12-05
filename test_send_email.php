<?php
// ============================================
// TEST SEND EMAIL
// ============================================

require_once __DIR__ . '/config/email.php';
require_once __DIR__ . '/config/env.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: check_forgot_password_setup.php');
    exit;
}

$test_email = $_POST['test_email'] ?? '';

if (empty($test_email)) {
    die('Email tidak boleh kosong!');
}

echo "<h1>Test Send Email</h1>";
echo "<hr>";
echo "<p>Mengirim test email ke: <strong>$test_email</strong></p>";
echo "<p>Mohon tunggu...</p>";

try {
    // Generate test token
    $test_token = bin2hex(random_bytes(32));
    
    // Kirim email
    $result = send_password_reset_email($test_email, 'Test User', $test_token);
    
    if ($result['success']) {
        echo "<h2 style='color:green;'>✅ Email berhasil dikirim!</h2>";
        echo "<p>" . $result['message'] . "</p>";
        echo "<p>Silakan cek inbox atau spam folder di email Anda.</p>";
    } else {
        echo "<h2 style='color:red;'>❌ Email gagal dikirim!</h2>";
        echo "<p><strong>Error:</strong> " . $result['message'] . "</p>";
        echo "<br><h3>Troubleshooting:</h3>";
        echo "<ul>";
        echo "<li>Pastikan MAIL_USERNAME dan MAIL_PASSWORD di .env sudah benar</li>";
        echo "<li>Jika pakai Gmail, pastikan menggunakan App Password (bukan password biasa)</li>";
        echo "<li>Cek koneksi internet</li>";
        echo "<li>Cek port 587 tidak diblokir firewall</li>";
        echo "</ul>";
    }
} catch (Exception $e) {
    echo "<h2 style='color:red;'>❌ Error!</h2>";
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
}

echo "<br><hr>";
echo "<a href='check_forgot_password_setup.php' style='padding:10px 20px; background:#4e9f3d; color:#fff; text-decoration:none; border-radius:5px;'>Back to Checker</a>";
?>
