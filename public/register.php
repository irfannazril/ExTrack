<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - ExTrack</title>
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
        <h2>Create Account</h2>
        <p>Sign up to get started</p>
      </div>

      <!-- Register Form -->
      <form id="registerForm" class="auth-form">
        <div class="mb-3">
          <label for="username" class="form-label">
            <i class="bi bi-person-fill"></i> Username
          </label>
          <input
            type="text"
            class="form-control"
            id="username"
            placeholder="Enter your username"
            required
            autocomplete="username">
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">
            <i class="bi bi-envelope-fill"></i> Email
          </label>
          <input
            type="email"
            class="form-control"
            id="email"
            placeholder="Enter your email"
            required
            autocomplete="email">
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4m0 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3" />
            </svg> Password
          </label>
          <div class="password-input-wrapper">
            <input
              type="password"
              class="form-control"
              id="password"
              placeholder="Enter your password"
              required
              autocomplete="new-password">
            <button type="button" class="toggle-password" id="togglePassword">
              <i class="bi bi-eye" id="eyeIcon"></i>
            </button>
          </div>
        </div>

        <div class="mb-3">
          <label for="confirmPassword" class="form-label">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4m0 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3" />
            </svg> Confirm Password
          </label>
          <div class="password-input-wrapper">
            <input
              type="password"
              class="form-control"
              id="confirmPassword"
              placeholder="Confirm your password"
              required
              autocomplete="new-password">
            <button type="button" class="toggle-password" id="toggleConfirmPassword">
              <i class="bi bi-eye" id="eyeIconConfirm"></i>
            </button>
          </div>
        </div>

        <button type="submit" class="btn-save">
          <span class="btn-text">Create Account</span>
          <span class="btn-loading">
            <span class="spinner-border spinner-border-sm me-2"></span>
            Creating account...
          </span>
        </button>
      </form>

      <!-- Login Link -->
      <div class="auth-footer">
        Already have an account? <a href="./login.php" class="auth-link">Login</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/auth.js"></script>
</body>

</html>