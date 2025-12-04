<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';

// Jika sudah login, redirect ke dashboard
if (is_logged_in()) {
  redirect('../pages/dashboard.php');
}

$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lupa Password - ExTrack</title>
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

      <!-- Header -->
      <div class="auth-header">
        <h2>Lupa Password?</h2>
        <p>Masukkan email Anda untuk reset password</p>
      </div>

      <!-- Alert -->
      <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show" role="alert">
          <i class="bi bi-<?= $flash['type'] === 'success' ? 'check-circle' : ($flash['type'] === 'error' ? 'exclamation-circle' : 'info-circle') ?>"></i>
          <?= htmlspecialchars($flash['message']) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <!-- Forgot Password Form -->
      <form method="POST" action="../handlers/forgot_password_handler.php" class="auth-form">
        <div class="mb-3">
          <label for="email" class="form-label">
            <i class="bi bi-envelope-fill"></i> Email
          </label>
          <input
            type="email"
            class="form-control"
            id="email"
            name="email"
            placeholder="Masukkan email Anda"
            required
            autocomplete="email">
          <small class="text-muted">Kami akan mengirim link reset password ke email Anda</small>
        </div>

        <button type="submit" class="btn-save">
          <span class="btn-text">Kirim Link Reset</span>
          <span class="btn-loading d-none">
            <span class="spinner-border spinner-border-sm me-2"></span>
            Mengirim...
          </span>
        </button>
      </form>

      <!-- Back to Login -->
      <div class="auth-footer">
        <a href="login.php" class="auth-link">
          <i class="bi bi-arrow-left me-1"></i> Kembali ke Login
        </a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Auto hide alert after 10 seconds
    setTimeout(() => {
      const alert = document.querySelector('.alert');
      if (alert) {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
      }
    }, 10000);

    // Loading state on submit
    document.querySelector('.auth-form').addEventListener('submit', function() {
      const btn = this.querySelector('.btn-save');
      btn.querySelector('.btn-text').classList.add('d-none');
      btn.querySelector('.btn-loading').classList.remove('d-none');
      btn.disabled = true;
    });
  </script>
</body>

</html>
