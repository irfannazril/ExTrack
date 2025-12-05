<?php
// ============================================
// CHECK FORGOT PASSWORD SETUP
// ============================================
// File ini untuk mengecek apakah setup forgot password sudah benar

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/env.php';

echo "<h1>ExTrack - Forgot Password Setup Checker</h1>";
echo "<hr>";

// 1. Cek koneksi database
echo "<h2>1. Database Connection</h2>";
try {
    $conn->query("SELECT 1");
    echo "✅ <strong>Database connected successfully</strong><br>";
} catch (PDOException $e) {
    echo "❌ <strong>Database connection failed:</strong> " . $e->getMessage() . "<br>";
    exit;
}

// 2. Cek tabel password_resets
echo "<h2>2. Password Resets Table</h2>";
try {
    $stmt = $conn->query("SHOW TABLES LIKE 'password_resets'");
    if ($stmt->rowCount() > 0) {
        echo "✅ <strong>Table 'password_resets' exists</strong><br>";
        
        // Cek struktur tabel
        $stmt = $conn->query("DESCRIBE password_resets");
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        echo "<br><strong>Table structure:</strong><br>";
        echo "<ul>";
        foreach ($columns as $column) {
            echo "<li>$column</li>";
        }
        echo "</ul>";
        
        // Cek jumlah data
        $stmt = $conn->query("SELECT COUNT(*) as count FROM password_resets");
        $count = $stmt->fetch()['count'];
        echo "<br><strong>Total records:</strong> $count<br>";
        
    } else {
        echo "❌ <strong>Table 'password_resets' NOT FOUND!</strong><br>";
        echo "<br><strong>Solution:</strong><br>";
        echo "1. Buka phpMyAdmin atau HeidiSQL<br>";
        echo "2. Pilih database 'extrack'<br>";
        echo "3. Import file: <code>database/password_resets_table.sql</code><br>";
        echo "<br>Atau jalankan query ini:<br>";
        echo "<textarea style='width:100%; height:200px; font-family:monospace;'>";
        echo file_get_contents(__DIR__ . '/database/password_resets_table.sql');
        echo "</textarea>";
    }
} catch (PDOException $e) {
    echo "❌ <strong>Error checking table:</strong> " . $e->getMessage() . "<br>";
}

// 3. Cek konfigurasi email
echo "<h2>3. Email Configuration</h2>";
$mail_host = env('MAIL_HOST');
$mail_username = env('MAIL_USERNAME');
$mail_password = env('MAIL_PASSWORD');
$mail_from = env('MAIL_FROM_ADDRESS');
$app_url = env('APP_URL');

if (empty($mail_host) || empty($mail_username) || empty($mail_password)) {
    echo "❌ <strong>Email configuration incomplete!</strong><br>";
    echo "<br><strong>Missing:</strong><br>";
    if (empty($mail_host)) echo "- MAIL_HOST<br>";
    if (empty($mail_username)) echo "- MAIL_USERNAME<br>";
    if (empty($mail_password)) echo "- MAIL_PASSWORD<br>";
    echo "<br><strong>Solution:</strong> Edit file <code>.env</code> dan isi konfigurasi email<br>";
} else {
    echo "✅ <strong>Email configuration found</strong><br>";
    echo "<ul>";
    echo "<li>MAIL_HOST: $mail_host</li>";
    echo "<li>MAIL_USERNAME: $mail_username</li>";
    echo "<li>MAIL_PASSWORD: " . (strlen($mail_password) > 0 ? str_repeat('*', strlen($mail_password)) : 'NOT SET') . "</li>";
    echo "<li>MAIL_FROM_ADDRESS: $mail_from</li>";
    echo "<li>APP_URL: $app_url</li>";
    echo "</ul>";
}

// 4. Cek function email
echo "<h2>4. Email Function</h2>";
if (function_exists('send_password_reset_email')) {
    echo "✅ <strong>Function 'send_password_reset_email' exists</strong><br>";
} else {
    echo "❌ <strong>Function 'send_password_reset_email' NOT FOUND!</strong><br>";
    echo "<br><strong>Solution:</strong> Pastikan file <code>config/email.php</code> sudah benar<br>";
}

// 5. Cek PHPMailer
echo "<h2>5. PHPMailer</h2>";
if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
    echo "✅ <strong>PHPMailer installed</strong><br>";
} else {
    echo "❌ <strong>PHPMailer NOT FOUND!</strong><br>";
    echo "<br><strong>Solution:</strong> Jalankan <code>composer install</code><br>";
}

// 6. Test email (opsional)
echo "<h2>6. Test Email (Optional)</h2>";
echo "<form method='POST' action='test_send_email.php' style='margin-top:10px;'>";
echo "Email tujuan: <input type='email' name='test_email' placeholder='your-email@gmail.com' required style='padding:5px; width:300px;'>";
echo " <button type='submit' style='padding:5px 15px;'>Test Send Email</button>";
echo "</form>";
echo "<small>* Email test akan dikirim ke email yang Anda masukkan</small>";

echo "<hr>";
echo "<h2>Summary</h2>";
echo "<p>Jika semua checklist di atas ✅, maka setup forgot password sudah benar.</p>";
echo "<p>Jika ada yang ❌, ikuti solution yang diberikan.</p>";
echo "<br>";
echo "<a href='auth/forgot-password.php' style='padding:10px 20px; background:#4e9f3d; color:#fff; text-decoration:none; border-radius:5px;'>Test Forgot Password</a>";
echo " ";
echo "<a href='index.php' style='padding:10px 20px; background:#666; color:#fff; text-decoration:none; border-radius:5px;'>Back to Home</a>";
?>
