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
  <title>Login - ExTrack</title>
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

      <!-- Welcome Text -->
      <div class="auth-header">
        <h2>Welcome</h2>
        <p>Please login to your account</p>
      </div>

      <!-- Alert -->
      <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show" role="alert">
          <i class="bi bi-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
          <?= htmlspecialchars($flash['message']) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <!-- Login Form -->
      <form method="POST" action="../handlers/login_handler.php" class="auth-form">
        <div class="mb-3">
          <label for="email" class="form-label">
            <i class="bi bi-envelope-fill"></i> Email
          </label>
          <input
            type="email"
            class="form-control"
            id="email"
            name="email"
            placeholder="Enter your email"
            required
            autocomplete="email">
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">
            <i class="bi bi-lock-fill"></i> Password
          </label>
          <div class="password-input-wrapper">
            <input
              type="password"
              class="form-control"
              id="password"
              name="password"
              placeholder="Enter your password"
              required
              autocomplete="current-password">
            <button type="button" class="toggle-password" id="togglePassword">
              <i class="bi bi-eye" id="eyeIcon"></i>
            </button>
          </div>
        </div>

        <div class="form-options">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="rememberMe" name="remember_me">
            <label class="form-check-label" for="rememberMe">
              Remember me
            </label>
          </div>
        </div>

        <button type="submit" class="btn-save">
          <span class="btn-text">Login</span>
          <span class="btn-loading d-none">
            <span class="spinner-border spinner-border-sm me-2"></span>
            Logging in...
          </span>
        </button>
      </form>

      <!-- Register Link -->
      <div class="auth-footer">
        Don't have an account? <a href="register.php" class="auth-link">Sign Up</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/auth.js"></script>
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
