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
  <!-- Sidebar Overlay -->
  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <div class="dashboard-container">
    <div class="row g-0">
      <!-- Sidebar -->
      <div class="col-lg-3">
        <div class="sidebar" id="sidebar">
          <div class="sidebar-top">
            <button class="close-sidebar-btn" id="closeSidebar">
              <i class="bi bi-x"></i>
            </button>

            <div class="logo">
              <span class="logo-color">Ex</span>Track
            </div>

            <a href="./index.php" class="nav-item">
              <i class="bi bi-grid"></i>
              <span>Dashboard</span>
            </a>
            <a href="./transaction.php" class="nav-item">
              <i class="bi bi-cash-stack"></i>
              <span>Transactions</span>
            </a>
            <a href="./assets.php" class="nav-item">
              <i class="bi bi-wallet2"></i>
              <span>Assets</span>
            </a>
            <a href="./statistics.php" class="nav-item">
              <i class="bi bi-bar-chart-line-fill"></i>
              <span>Statistics</span>
            </a>
            <a href="./settings.php" class="nav-item active">
              <i class="bi bi-gear"></i>
              <span>Settings</span>
            </a>
          </div>

          <div class="sidebar-bottom">
            <div class="footer-links">
              <a href="#" class="footer-link">
                <img class="profile" src="../assets/img/profile.jpg"></img>
                Profile
              </a>
              <a href="#" class="footer-link">
                <i class="bi bi-box-arrow-in-left"></i>
                Logout
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="col-lg-9">
        <div class="main-content">
          <div class="header">
            <button class="hamburger-btn" id="hamburgerBtn">
              <i class="bi bi-list"></i>
            </button>
            <div class="menu">Settings</div>
          </div>

          <!-- Profile Section -->
          <div class="settings-section">
            <div class="section-title">Profile Settings</div>
            <div class="settings-card">
              <div class="profile-container">
                <div class="profile-photo-wrapper">
                  <div class="profile-photo" id="profilePhotoPreview">
                    <img src="https://ui-avatars.com/api/?name=John+Doe&background=4F46E5&color=fff&size=120" alt="Profile Photo" id="profileImage">
                  </div>
                  <label for="profilePhotoInput" class="change-photo-btn">
                    <i class="bi bi-camera"></i>
                  </label>
                  <input type="file" id="profilePhotoInput" accept="image/*" style="display: none;">
                </div>

                <form id="profileForm" class="profile-form">
                  <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" value="JohnDoe" required>
                  </div>

                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" value="john.doe@example.com" readonly disabled>
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
                <button class="btn-danger-action" onclick="confirmDelete('transactions')">
                  <i class="bi bi-trash"></i> Delete Transactions
                </button>
              </div>

              <div class="danger-item">
                <div class="danger-info">
                  <h6>Delete All Assets</h6>
                  <p>Permanently delete all your assets/wallets. This action cannot be undone.</p>
                </div>
                <button class="btn-danger-action" onclick="confirmDelete('assets')">
                  <i class="bi bi-trash"></i> Delete Assets
                </button>
              </div>

              <div class="danger-item">
                <div class="danger-info">
                  <h6>Delete All Categories</h6>
                  <p>Permanently delete all your custom categories. This action cannot be undone.</p>
                </div>
                <button class="btn-danger-action" onclick="confirmDelete('categories')">
                  <i class="bi bi-trash"></i> Delete Categories
                </button>
              </div>

              <div class="danger-item border-top pt-3 mt-3">
                <div class="danger-info">
                  <h6 class="text-danger">Delete Account</h6>
                  <p class="text-danger">Permanently delete your account and all associated data. This action cannot be undone and you will be logged out immediately.</p>
                </div>
                <button class="btn-danger-action-severe" onclick="confirmDeleteAccount()">
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
          <form id="changePasswordForm">
            <div class="mb-3">
              <label for="currentPassword" class="form-label">Current Password</label>
              <input type="password" class="form-control" id="currentPassword" required>
            </div>
            <div class="mb-3">
              <label for="newPassword" class="form-label">New Password</label>
              <input type="password" class="form-control" id="newPassword" required>
            </div>
            <div class="mb-3">
              <label for="confirmPassword" class="form-label">Confirm New Password</label>
              <input type="password" class="form-control" id="confirmPassword" required>
            </div>
            <button type="submit" class="btn-save w-100">Update Password</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Confirmation Modal -->
  <div class="modal fade" id="confirmationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-danger">Confirm Action</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p id="confirmationMessage"></p>
          <p class="text-warning"><i class="bi bi-exclamation-triangle me-2"></i>This action cannot be undone!</p>
          <div class="mb-3">
            <label for="confirmationInput" class="form-label">Type <strong>DELETE</strong> to confirm:</label>
            <input type="text" class="form-control" id="confirmationInput" placeholder="DELETE">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" id="confirmDeleteBtn" disabled>Delete</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/script.js"></script>
  <script src="../assets/js/settings.js"></script>
</body>

</html>