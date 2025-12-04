<?php
// ============================================
// EMAIL CONFIGURATION - ExTrack
// ============================================

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/env.php';

// Function untuk kirim verification email
function send_verification_email($to_email, $username, $verification_token)
{
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration from .env
        $mail->isSMTP();
        $mail->Host = env('MAIL_HOST', 'smtp.gmail.com');
        $mail->SMTPAuth = true;
        $mail->Username = env('MAIL_USERNAME');
        $mail->Password = env('MAIL_PASSWORD');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = env('MAIL_PORT', 587);

        // Sender & Recipient
        $mail->setFrom(env('MAIL_FROM_ADDRESS', 'noreply@extrack.com'), env('MAIL_FROM_NAME', 'ExTrack'));
        $mail->addAddress($to_email, $username);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Verifikasi Email Anda - ExTrack';

        $app_url = env('APP_URL');
        $verification_link = "$app_url/auth/verify-email.php?token=" . $verification_token;

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

// Function untuk kirim password reset email
function send_password_reset_email($to_email, $username, $reset_token)
{
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration from .env
        $mail->isSMTP();
        $mail->Host = env('MAIL_HOST', 'smtp.gmail.com');
        $mail->SMTPAuth = true;
        $mail->Username = env('MAIL_USERNAME');
        $mail->Password = env('MAIL_PASSWORD');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = env('MAIL_PORT', 587);

        // Sender & Recipient
        $mail->setFrom(env('MAIL_FROM_ADDRESS', 'noreply@extrack.com'), env('MAIL_FROM_NAME', 'ExTrack'));
        $mail->addAddress($to_email, $username);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Reset Password - ExTrack';

        $app_url = env('APP_URL');
        $reset_link = "$app_url/auth/reset-password.php?token=" . $reset_token;

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
                    .warning { background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; border-radius: 5px; }
                    .footer { text-align: center; margin-top: 30px; color: #888; font-size: 12px; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <div class='logo'><span class='logo-color'>Ex</span>Track</div>
                    </div>
                    <div class='content'>
                        <h2>Reset Password</h2>
                        <p>Halo " . htmlspecialchars($username) . ",</p>
                        <p>Kami menerima permintaan untuk reset password akun Anda. Klik tombol di bawah untuk melanjutkan:</p>
                        <p style='text-align: center;'>
                            <a href='" . $reset_link . "' class='button'>Reset Password</a>
                        </p>
                        <p>Atau copy link ini ke browser Anda: " . $reset_link . "</p>
                        <div class='warning'>
                            <strong>⚠️ Penting:</strong>
                            <ul style='margin: 10px 0; padding-left: 20px;'>
                                <li>Link ini akan kadaluarsa dalam <strong>1 jam</strong></li>
                                <li>Link hanya dapat digunakan <strong>satu kali</strong></li>
                                <li>Jika Anda tidak meminta reset password, abaikan email ini</li>
                            </ul>
                        </div>
                        <p style='color: #666; font-size: 14px; margin-top: 20px;'>
                            Untuk keamanan akun Anda, jangan bagikan link ini kepada siapapun.
                        </p>
                    </div>
                    <div class='footer'>
                        <p>&copy; 2025 ExTrack. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>
        ";

        $mail->AltBody = "Hi $username,\n\nKami menerima permintaan untuk reset password akun Anda.\n\nKlik link ini untuk reset password: $reset_link\n\nLink ini akan kadaluarsa dalam 1 jam dan hanya dapat digunakan satu kali.\n\nJika Anda tidak meminta reset password, abaikan email ini.";

        $mail->send();
        return ['success' => true, 'message' => 'Email reset password berhasil dikirim'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Email gagal dikirim: ' . $mail->ErrorInfo];
    }
}
