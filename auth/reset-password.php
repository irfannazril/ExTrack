<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/database.php';

// Jika sudah login, redirect ke dashboard
if (is_logged_in()) {
  redirect('../pages/dashboard.php');
}

// Ambil token dari URL
$token = $_GET['token'] ?? '';

if (empty($token)) {
  set_flash('error', 'Token tidak valid.');
  redirect('forgot-password.php');
}

// Validasi token
try {
  $stmt = $conn->prepare("
    SELECT pr.*, u.username, u.email 
    FROM password_resets pr
    JOIN users u ON pr.email = u.email
    WHERE pr.token = ? AND pr.is_used = 0
  ");
  $stmt->execute([$token]);
  $reset_data = $stmt->fetch();

  if (!$reset_data) {
    $token_error = 'used';
  } elseif (strtotime($reset_data['expires_at']) < time()) {
    $token_error = 'expired';
  } else {
    $token_error = null;
  }
} catch (PDOException $e) {
  set_flash('error', 'Terjadi kesalahan sistem.');
  redirect('forgot-password.php');
}

$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password - ExTrack</title>
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

      <?php if ($token_error === 'used'): ?>
        <!-- Token Already Used -->
        <div class="auth-header">
          <h2>Link Tidak Valid</h2>
          <p>Link reset password sudah digunakan atau tidak valid</p>
        </div>
        <div class="error-message">
          <i class="bi bi-exclamation-triangle"></i>
          <div>
            <strong>Link sudah digunakan</strong><br>
            Link reset password ini sudah pernah digunakan atau tidak valid. Silakan request link baru jika Anda masih ingin reset password.
          </div>
        </div>
        <a href="forgot-password.php" class="btn-save">
          <i class="bi bi-arrow-clockwise me-2"></i>Request Link Baru
        </a>
        <div class="auth-footer mt-3">
          <a href="login.php" class="auth-link">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Login
          </a>
        </div>

      <?php elseif ($token_error === 'expired'): ?>
        <!-- Token Expired -->
        <div class="auth-header">
          <h2>Link Kadaluarsa</h2>
          <p>Link reset password sudah tidak berlaku</p>
        </div>
        <div class="error-message">
          <i class="bi bi-clock-history"></i>
          <div>
            <strong>Link sudah kadaluarsa</strong><br>
            Link reset password ini sudah melewati batas waktu 1 jam. Silakan request link baru untuk melanjutkan reset password.
          </div>
        </div>
        <a href="forgot-password.php" class="btn-save">
          <i class="bi bi-arrow-clockwise me-2"></i>Request Link Baru
        </a>
        <div class="auth-footer mt-3">
          <a href="login.php" class="auth-link">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Login
          </a>
        </div>

      <?php else: ?>
        <!-- Valid Token - Show Reset Form -->
        <div class="auth-header">
          <h2>Reset Password</h2>
          <p>Masukkan password baru untuk akun <strong><?= htmlspecialchars($reset_data['email']) ?></strong></p>
        </div>

        <!-- Alert -->
        <?php if ($flash): ?>
          <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show" role="alert">
            <i class="bi bi-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
            <?= htmlspecialchars($flash['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <!-- Reset Password Form -->
        <form method="POST" action="../handlers/reset_password_handler.php" class="auth-form" id="resetForm">
          <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

          <div class="mb-3">
            <label for="password" class="form-label">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4m0 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3" />
              </svg> Password Baru
            </label>
            <div class="password-input-wrapper">
              <input
                type="password"
                class="form-control"
                id="password"
                name="password"
                placeholder="Masukkan password baru"
                required
                autocomplete="new-password">
              <button type="button" class="toggle-password" id="togglePassword">
                <i class="bi bi-eye" id="eyeIcon"></i>
              </button>
            </div>
            <small class="text-muted">Minimal 6 karakter, harus ada minimal 1 angka dan 1 huruf. Password baru tidak boleh sama dengan password lama.</small>
          </div>

          <div class="mb-3">
            <label for="confirmPassword" class="form-label">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4m0 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3" />
              </svg> Konfirmasi Password
            </label>
            <div class="password-input-wrapper">
              <input
                type="password"
                class="form-control"
                id="confirmPassword"
                name="confirm_password"
                placeholder="Konfirmasi password baru"
                required
                autocomplete="new-password">
              <button type="button" class="toggle-password" id="toggleConfirmPassword">
                <i class="bi bi-eye" id="eyeIconConfirm"></i>
              </button>
            </div>
          </div>

          <button type="submit" class="btn-save">
            <span class="btn-text">Reset Password</span>
            <span class="btn-loading d-none">
              <span class="spinner-border spinner-border-sm me-2"></span>
              Memproses...
            </span>
          </button>
        </form>

        <div class="auth-footer">
          <a href="login.php" class="auth-link">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Login
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/auth.js"></script>
  <script>
    // Auto hide alert
    setTimeout(() => {
      const alert = document.querySelector('.alert');
      if (alert) {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
      }
    }, 10000);

    // Loading state on submit
    const form = document.getElementById('resetForm');
    if (form) {
      form.addEventListener('submit', function() {
        const btn = this.querySelector('.btn-save');
        btn.querySelector('.btn-text').classList.add('d-none');
        btn.querySelector('.btn-loading').classList.remove('d-none');
        btn.disabled = true;
      });
    }
  </script>
</body>

</html>