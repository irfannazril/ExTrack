<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/database.php';

$token = $_GET['token'] ?? '';
$message = '';
$success = false;

if (empty($token)) {
    $message = 'Token verifikasi tidak valid';
} else {
    try {
        // Cari user dengan token
        $stmt = $conn->prepare("SELECT user_id, username, email, token_expires_at FROM users WHERE verification_token = ?");
        $stmt->execute([$token]);
        $user = $stmt->fetch();
        
        if (!$user) {
            $message = 'Token verifikasi tidak valid';
        } elseif (strtotime($user['token_expires_at']) < time()) {
            $message = 'Token verifikasi sudah kedaluwarsa';
        } else {
            // Update user sebagai verified
            $stmt = $conn->prepare("UPDATE users SET is_verified = 1, verification_token = NULL, token_expires_at = NULL WHERE user_id = ?");
            $stmt->execute([$user['user_id']]);
            
            $success = true;
            $message = 'Email berhasil diverifikasi!';
        }
    } catch (PDOException $e) {
        $message = 'Terjadi kesalahan sistem';
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Email Verification - ExTrack</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../assets/css/auth.css">
</head>

<body class="auth-body">
  <div class="auth-container">
    <div class="auth-card">
      <!-- Logo -->
      <div class="auth-logo">
        <span class="logo-color">Ex</span>Track
      </div>

      <!-- Verification Result -->
      <div class="verification-result">
        <?php if ($success): ?>
          <div class="verification-icon success">
            <i class="bi bi-check-circle"></i>
          </div>
          <h2 class="verification-title">Email Verified!</h2>
          <p class="verification-message"><?= htmlspecialchars($message) ?></p>
          <a href="login.php" class="btn-save">
            <i class="bi bi-box-arrow-in-right me-2"></i>Login to Your Account
          </a>
        <?php else: ?>
          <div class="verification-icon error">
            <i class="bi bi-x-circle"></i>
          </div>
          <h2 class="verification-title">Verification Failed</h2>
          <p class="verification-message"><?= htmlspecialchars($message) ?></p>
          <a href="register.php" class="btn-save mt-3">
            <i class="bi bi-arrow-left me-2"></i>Back to Register
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
