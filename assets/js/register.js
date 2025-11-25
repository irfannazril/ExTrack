// Toggle Password Visibility
const togglePassword = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');
const eyeIcon = document.getElementById('eyeIcon');

if (togglePassword) {
  togglePassword.addEventListener('click', function () {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    eyeIcon.classList.toggle('bi-eye');
    eyeIcon.classList.toggle('bi-eye-slash');
  });
}

// Toggle Confirm Password Visibility
const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
const confirmPasswordInput = document.getElementById('confirmPassword');
const eyeIconConfirm = document.getElementById('eyeIconConfirm');

if (toggleConfirmPassword) {
  toggleConfirmPassword.addEventListener('click', function () {
    const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    confirmPasswordInput.setAttribute('type', type);
    eyeIconConfirm.classList.toggle('bi-eye');
    eyeIconConfirm.classList.toggle('bi-eye-slash');
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

    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    // Client-side validation
    if (password !== confirmPassword) {
      showError('Password tidak cocok!');
      return;
    }

    if (password.length < 6) {
      showError('Password minimal 6 karakter!');
      return;
    }

    // Show loading state
    const submitBtn = this.querySelector('.btn-save');
    submitBtn.classList.add('loading');
    submitBtn.disabled = true;

    try {
      const response = await fetch('../controller/reg-auth.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          action: 'register',
          username: username,
          email: email,
          password: password,
          confirm_password: confirmPassword,
        }),
      });

      const result = await response.json();

      if (result.success) {
        showSuccess(result.message);

        // Redirect to login after 3 seconds
        setTimeout(() => {
          window.location.href = './login.php';
        }, 3000);
      } else {
        showError(result.message);
        submitBtn.classList.remove('loading');
        submitBtn.disabled = false;
      }
    } catch (error) {
      showError('Terjadi kesalahan. Silakan coba lagi.');
      submitBtn.classList.remove('loading');
      submitBtn.disabled = false;
    }
  });
}

// Show error message
function showError(message) {
  const errorDiv = document.createElement('div');
  errorDiv.className = 'error-message';
  errorDiv.innerHTML = `
    <i class="bi bi-exclamation-circle"></i>
    <span>${message}</span>
  `;
  registerForm.insertBefore(errorDiv, registerForm.firstChild);

  // Auto remove after 5 seconds
  setTimeout(() => errorDiv.remove(), 5000);
}

// Show success message
function showSuccess(message) {
  const successDiv = document.createElement('div');
  successDiv.className = 'success-message';
  successDiv.innerHTML = `
    <i class="bi bi-check-circle"></i>
    <span>${message}</span>
  `;
  registerForm.insertBefore(successDiv, registerForm.firstChild);
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

// Auto-focus first input
document.addEventListener('DOMContentLoaded', function () {
  const firstInput = document.querySelector('.form-control');
  if (firstInput) {
    firstInput.focus();
  }
});
