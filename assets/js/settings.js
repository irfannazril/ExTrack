// Profile Photo Preview
document.getElementById('profilePhotoInput').addEventListener('change', function(e) {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('profileImage').src = e.target.result;
    };
    reader.readAsDataURL(file);
  }
});

// Profile Form Submit
document.getElementById('profileForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const username = document.getElementById('username').value;
  
  // TODO: Send to backend
  alert(`Profile updated!\nUsername: ${username}`);
});

// Change Password Form
document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const currentPassword = document.getElementById('currentPassword').value;
  const newPassword = document.getElementById('newPassword').value;
  const confirmPassword = document.getElementById('confirmPassword').value;

  if (newPassword !== confirmPassword) {
    alert('New passwords do not match!');
    return;
  }

  // TODO: Send to backend
  alert('Password changed successfully!');
  
  // Close modal and reset form
  const modal = bootstrap.Modal.getInstance(document.getElementById('changePasswordModal'));
  modal.hide();
  e.target.reset();
});

// Confirmation Modal Logic
let currentDeleteAction = null;

function confirmDelete(type) {
  currentDeleteAction = type;
  
  const messages = {
    'transactions': 'Are you sure you want to delete ALL transactions?',
    'assets': 'Are you sure you want to delete ALL assets/wallets?',
    'categories': 'Are you sure you want to delete ALL categories?'
  };

  document.getElementById('confirmationMessage').textContent = messages[type];
  document.getElementById('confirmationInput').value = '';
  document.getElementById('confirmDeleteBtn').disabled = true;

  const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
  modal.show();
}

function confirmDeleteAccount() {
  currentDeleteAction = 'account';
  
  document.getElementById('confirmationMessage').textContent = 
    'Are you sure you want to DELETE YOUR ACCOUNT? All your data will be permanently removed and you will be logged out.';
  document.getElementById('confirmationInput').value = '';
  document.getElementById('confirmDeleteBtn').disabled = true;

  const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
  modal.show();
}

// Enable delete button when user types DELETE
document.getElementById('confirmationInput').addEventListener('input', function(e) {
  const btn = document.getElementById('confirmDeleteBtn');
  btn.disabled = e.target.value !== 'DELETE';
});

// Execute delete action
document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
  if (!currentDeleteAction) return;

  // TODO: Send delete request to backend
  switch(currentDeleteAction) {
    case 'transactions':
      alert('All transactions have been deleted!');
      break;
    case 'assets':
      alert('All assets have been deleted!');
      break;
    case 'categories':
      alert('All categories have been deleted!');
      break;
    case 'account':
      alert('Your account has been deleted. Logging out...');
      // Redirect to login or homepage
      // window.location.href = './login.php';
      break;
  }

  // Close modal
  const modal = bootstrap.Modal.getInstance(document.getElementById('confirmationModal'));
  modal.hide();
  currentDeleteAction = null;
});