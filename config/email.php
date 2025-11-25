<?php
// ============================================
// EMAIL CONFIGURATION - ExTrack
// ============================================

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

// Function untuk kirim verification email
function send_verification_email($to_email, $username, $verification_token) {
    $mail = new PHPMailer(true);
    
    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'malingpangsitasdf@gmail.com'; // Ganti dengan email Anda
        $mail->Password = 'thyzktvvgdcjcnla'; // 16 digit App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        // Sender & Recipient
        $mail->setFrom('noreply@extrack.com', 'ExTrack');
        $mail->addAddress($to_email, $username);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Verifikasi Email Anda - ExTrack';
        
        $verification_link = "http://localhost/extrack/auth/verify-email.php?token=" . $verification_token;
        
        $mail->Body = "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background: linear-gradient(135deg, #4e9f3d 0%, #5fb94b 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
                    .logo { font-size: 32px; font-weight: bold; }
                    .logo-color { color: #1e5128; }
                    .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
                    .button { display: inline-block; background: linear-gradient(135deg, #4e9f3d 0%, #5fb94b 100%); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 20px 0; font-weight: bold; }
                    .footer { text-align: center; margin-top: 30px; color: #888; font-size: 12px; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <div class='logo'><span class='logo-color'>Ex</span>Track</div>
                    </div>
                    <div class='content'>
                        <h2>Selamat datang di ExTrack, " . htmlspecialchars($username) . "!</h2>
                        <p>Terima kasih telah mendaftar. Silakan verifikasi email Anda dengan klik tombol di bawah:</p>
                        <p style='text-align: center;'>
                            <a href='" . $verification_link . "' class='button'>Verifikasi Email</a>
                        </p>
                        <p>Atau copy link ini: " . $verification_link . "</p>
                        <p><strong>Link ini akan kadaluarsa dalam 24 jam.</strong></p>
                        <p>Jika Anda tidak membuat akun ini, abaikan email ini.</p>
                    </div>
                    <div class='footer'>
                        <p>&copy; 2025 ExTrack. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>
        ";
        
        $mail->AltBody = "Hi $username,\n\nSilakan verifikasi email Anda dengan klik link ini: $verification_link\n\nLink ini akan kadaluarsa dalam 24 jam.";
        
        $mail->send();
        return ['success' => true, 'message' => 'Email verifikasi berhasil dikirim'];
        
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Email gagal dikirim: ' . $mail->ErrorInfo];
    }
}

// Function untuk kirim password reset email (untuk fitur forgot password nanti)
function send_password_reset_email($to_email, $username, $reset_token) {
    $mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'malingpangsitasdf@gmail.com';
        $mail->Password = 'thyzktvvgdcjcnla';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        $mail->setFrom('noreply@extrack.com', 'ExTrack');
        $mail->addAddress($to_email, $username);
        
        $mail->isHTML(true);
        $mail->Subject = 'Reset Password - ExTrack';
        
        $reset_link = "http://localhost/extrack/auth/reset-password.php?token=" . $reset_token;
        
        $mail->Body = "
            <h2>Reset Password</h2>
            <p>Hi " . htmlspecialchars($username) . ",</p>
            <p>Kami menerima permintaan untuk reset password Anda. Klik tombol di bawah untuk reset:</p>
            <p><a href='" . $reset_link . "' style='background: #4e9f3d; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;'>Reset Password</a></p>
            <p>Link ini akan kadaluarsa dalam 1 jam.</p>
            <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
        ";
        
        $mail->send();
        return ['success' => true, 'message' => 'Email reset password berhasil dikirim'];
        
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Email gagal dikirim: ' . $mail->ErrorInfo];
    }
}
