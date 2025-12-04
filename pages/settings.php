<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/functions.php';

$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user_data = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Settings - ExTrack</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
  <div class="sidebar-overlay" id="sidebarOverlay"></div>
  <div class="dashboard-container">
    <div class="row g-0">
      <div class="col-lg-3">
        <?php include __DIR__ . '/../includes/sidebar.php'; ?>
      </div>
      <div class="col-lg-9">
        <div class="main-content">
          <div class="header">
            <button class="hamburger-btn" id="hamburgerBtn"><i class="bi bi-list"></i></button>
            <div class="header-settings">
              <div class="menu">Settings</div>
            </div>
          </div>

          <?php include __DIR__ . '/../includes/alert.php'; ?>

          <!-- Profile Section -->
          <div class="settings-section">
            <div class="section-title">Profile Settings</div>
            <div class="settings-card">
              <div class="profile-container">
                <div class="profile-photo-wrapper">
                  <div class="profile-photo" id="profilePhotoPreview">
                    <img src="<?= $profile_photo ?>" alt="Profile Photo" id="profileImage">
                  </div>
                  <label for="profilePhotoInput" class="change-photo-btn">
                    <i class="bi bi-camera"></i>
                  </label>
                </div>

                <form method="POST" action="../handlers/settings_handler.php" enctype="multipart/form-data" class="profile-form">
                  <input type="hidden" name="action" value="update_profile">
                  <input type="file" id="profilePhotoInput" name="profile_photo" accept="image/*" style="display: none;" onchange="previewPhoto(this)">

                  <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user_data['username']) ?>" required>
                  </div>

                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" value="<?= htmlspecialchars($user_data['email']) ?>" readonly disabled>
                    <small class="text-muted">Email cannot be changed</small>
                  </div>

                  <button type="submit" class="btn-save">
                    <i class="bi bi-check-circle me-2"></i>Save Changes
                  </button>
                </form>
              </div>
            </div>
          </div>

          <!-- Security Section -->
          <div class="settings-section mt-4">
            <div class="section-title">Security</div>
            <div class="settings-card">
              <button class="btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                <i class="bi bi-key me-2"></i>Change Password
              </button>
            </div>
          </div>

          <!-- Danger Zone -->
          <div class="settings-section mt-4">
            <div class="section-title text-danger">
              <i class="bi bi-exclamation-triangle me-2"></i>Danger Zone
            </div>
            <div class="settings-card danger-zone">
              <div class="danger-item">
                <div class="danger-info">
                  <h6>Delete All Transactions</h6>
                  <p>Permanently delete all your transaction records. This action cannot be undone.</p>
                </div>
                <button class="btn-danger-action" onclick="confirmDangerAction('transactions', 'Hapus semua transaksi?')">
                  <i class="bi bi-trash"></i> Delete Transactions
                </button>
              </div>

              <div class="danger-item">
                <div class="danger-info">
                  <h6>Delete All Assets</h6>
                  <p>Permanently delete all your assets/wallets. This action cannot be undone.</p>
                </div>
                <button class="btn-danger-action" onclick="confirmDangerAction('assets', 'Hapus semua asset?')">
                  <i class="bi bi-trash"></i> Delete Assets
                </button>
              </div>

              <div class="danger-item">
                <div class="danger-info">
                  <h6>Delete All Categories</h6>
                  <p>Permanently delete all your custom categories. This action cannot be undone.</p>
                </div>
                <button class="btn-danger-action" onclick="confirmDangerAction('categories', 'Hapus semua kategori custom?')">
                  <i class="bi bi-trash"></i> Delete Categories
                </button>
              </div>

              <div class="danger-item border-top pt-3 mt-3">
                <div class="danger-info">
                  <h6 class="text-danger">Delete Account</h6>
                  <p class="text-danger">Permanently delete your account and all associated data. This action cannot be undone and you will be logged out immediately.</p>
                </div>
                <button class="btn-danger-action-severe" onclick="confirmDangerAction('account', 'Hapus akun Anda? Semua data akan hilang!')">
                  <i class="bi bi-person-x"></i> Delete Account
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Change Password Modal -->
  <div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Change Password</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="../handlers/settings_handler.php">
            <input type="hidden" name="action" value="change_password">
            <div class="mb-3">
              <label for="currentPassword" class="form-label">Current Password</label>
              <input type="password" class="form-control" name="current_password" id="currentPassword" required>
            </div>
            <div class="mb-3">
              <label for="newPassword" class="form-label">New Password</label>
              <input type="password" class="form-control" name="new_password" id="newPassword" required>
            </div>
            <div class="mb-3">
              <label for="confirmPassword" class="form-label">Confirm New Password</label>
              <input type="password" class="form-control" name="confirm_password" id="confirmPassword" required>
            </div>
            <button type="submit" class="btn-save w-100">Update Password</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Danger Action Form (Hidden) -->
  <form method="POST" action="../handlers/settings_handler.php" id="dangerActionForm" class="d-none">
    <input type="hidden" name="action" id="dangerAction">
  </form>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/script.js"></script>
  <script>
    function previewPhoto(input) {
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('profileImage').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
      }
    }

    function confirmDangerAction(action, message) {
      if (confirm(message + '\n\nKetik DELETE untuk konfirmasi:')) {
        const confirmation = prompt('Ketik DELETE untuk konfirmasi:');
        if (confirmation === 'DELETE') {
          document.getElementById('dangerAction').value = 'delete_' + action;
          document.getElementById('dangerActionForm').submit();
        } else {
          alert('Konfirmasi tidak sesuai. Aksi dibatalkan.');
        }
      }
    }
  </script>
</body>

</html>