// Toggle Password Visibility untuk Login
const togglePassword = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');
const eyeIcon = document.getElementById('eyeIcon');

if (togglePassword) {
  togglePassword.addEventListener('click', function () {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);

    // Toggle eye icon
    eyeIcon.classList.toggle('bi-eye');
    eyeIcon.classList.toggle('bi-eye-slash');
  });
}

// Toggle Confirm Password Visibility untuk Register
const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
const confirmPasswordInput = document.getElementById('confirmPassword');
const eyeIconConfirm = document.getElementById('eyeIconConfirm');

if (toggleConfirmPassword) {
  toggleConfirmPassword.addEventListener('click', function () {
    const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    confirmPasswordInput.setAttribute('type', type);

    // Toggle eye icon
    eyeIconConfirm.classList.toggle('bi-eye');
    eyeIconConfirm.classList.toggle('bi-eye-slash');
  });
}

// Remove error/success messages when user starts typing
const formInputs = document.querySelectorAll('.form-control');
formInputs.forEach((input) => {
  input.addEventListener('input', function () {
    const errorMsg = document.querySelector('.error-message');
    const successMsg = document.querySelector('.success-message');
    if (errorMsg) errorMsg.remove();
    if (successMsg) successMsg.remove();
  });
});

// Login Form Submit
const loginForm = document.getElementById('loginForm');
if (loginForm) {
  loginForm.addEventListener('submit', async function (e) {
    e.preventDefault();

    // Remove previous messages
    const existingError = document.querySelector('.error-message');
    const existingSuccess = document.querySelector('.success-message');
    if (existingError) existingError.remove();
    if (existingSuccess) existingSuccess.remove();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const rememberMe = document.getElementById('rememberMe')?.checked;

    // Show loading state
    const submitBtn = e.target.querySelector('.btn-save');
    submitBtn.classList.add('loading');
    submitBtn.disabled = true;

    try {
      // TODO: Replace with actual API call
      // Simulate API call
      await new Promise((resolve) => setTimeout(resolve, 1500));

      // Mock validation
      if (email === 'demo@extrack.com' && password === 'password') {
        // Show success message
        const successDiv = document.createElement('div');
        successDiv.className = 'success-message';
        successDiv.innerHTML = `
          <i class="bi bi-check-circle"></i>
          <span>Login successful! Redirecting...</span>
        `;
        loginForm.insertBefore(successDiv, loginForm.firstChild);

        // Redirect after short delay
        setTimeout(() => {
          window.location.href = './index.php';
        }, 1000);
      } else {
        throw new Error('Invalid email or password');
      }
    } catch (error) {
      // Show error message
      const errorDiv = document.createElement('div');
      errorDiv.className = 'error-message';
      errorDiv.innerHTML = `
        <i class="bi bi-exclamation-circle"></i>
        <span>${error.message}</span>
      `;
      loginForm.insertBefore(errorDiv, loginForm.firstChild);

      // Remove loading state
      submitBtn.classList.remove('loading');
      submitBtn.disabled = false;
    }
  });
}

// Register Form Submit
const registerForm = document.getElementById('registerForm');
if (registerForm) {
  registerForm.addEventListener('submit', async function (e) {
    e.preventDefault();

    // Remove previous messages
    const existingError = document.querySelector('.error-message');
    const existingSuccess = document.querySelector('.success-message');
    if (existingError) existingError.remove();
    if (existingSuccess) existingSuccess.remove();

    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    // Validate passwords match
    if (password !== confirmPassword) {
      const errorDiv = document.createElement('div');
      errorDiv.className = 'error-message';
      errorDiv.innerHTML = `
        <i class="bi bi-exclamation-circle"></i>
        <span>Passwords do not match!</span>
      `;
      registerForm.insertBefore(errorDiv, registerForm.firstChild);
      return;
    }

    // Validate password length
    if (password.length < 6) {
      const errorDiv = document.createElement('div');
      errorDiv.className = 'error-message';
      errorDiv.innerHTML = `
        <i class="bi bi-exclamation-circle"></i>
        <span>Password must be at least 6 characters long!</span>
      `;
      registerForm.insertBefore(errorDiv, registerForm.firstChild);
      return;
    }

    // Show loading state
    const submitBtn = e.target.querySelector('.btn-save');
    submitBtn.classList.add('loading');
    submitBtn.disabled = true;

    try {
      // TODO: Replace with actual API call
      await new Promise((resolve) => setTimeout(resolve, 1500));

      // Show success message
      const successDiv = document.createElement('div');
      successDiv.className = 'success-message';
      successDiv.innerHTML = `
        <i class="bi bi-check-circle"></i>
        <span>Account created successfully! Redirecting to login...</span>
      `;
      registerForm.insertBefore(successDiv, registerForm.firstChild);

      // Redirect after short delay
      setTimeout(() => {
        window.location.href = './login.php';
      }, 1500);
    } catch (error) {
      // Show error message
      const errorDiv = document.createElement('div');
      errorDiv.className = 'error-message';
      errorDiv.innerHTML = `
        <i class="bi bi-exclamation-circle"></i>
        <span>${error.message || 'Registration failed. Please try again.'}</span>
      `;
      registerForm.insertBefore(errorDiv, registerForm.firstChild);

      // Remove loading state
      submitBtn.classList.remove('loading');
      submitBtn.disabled = false;
    }
  });
}

// Auto-focus first input
document.addEventListener('DOMContentLoaded', function () {
  const firstInput = document.querySelector('.form-control');
  if (firstInput) {
    firstInput.focus();
  }
});
