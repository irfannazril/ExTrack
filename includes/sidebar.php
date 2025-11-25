<?php
// Component sidebar - dipakai di semua halaman dashboard
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<div class="sidebar" id="sidebar">
  <div class="sidebar-top">
    <button class="close-sidebar-btn" id="closeSidebar">
      <i class="bi bi-x"></i>
    </button>

    <div class="logo">
      <span class="logo-color">Ex</span>Track
    </div>

    <a href="dashboard.php" class="nav-item <?= $current_page === 'dashboard' ? 'active' : '' ?>">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
    <a href="transactions.php" class="nav-item <?= $current_page === 'transactions' ? 'active' : '' ?>">
      <i class="bi bi-cash-stack"></i>
      <span>Transactions</span>
    </a>
    <a href="assets.php" class="nav-item <?= $current_page === 'assets' ? 'active' : '' ?>">
      <i class="bi bi-wallet2"></i>
      <span>Assets</span>
    </a>
    <a href="statistics.php" class="nav-item <?= $current_page === 'statistics' ? 'active' : '' ?>">
      <i class="bi bi-bar-chart-line-fill"></i>
      <span>Statistics</span>
    </a>
    <a href="settings.php" class="nav-item <?= $current_page === 'settings' ? 'active' : '' ?>">
      <i class="bi bi-gear"></i>
      <span>Settings</span>
    </a>
  </div>

  <div class="sidebar-bottom">
    <div class="footer-links">
      <a href="settings.php" class="footer-link">
        <img class="profile" src="<?= $profile_photo ?>" alt="Profile">
        <?= htmlspecialchars($username) ?>
      </a>
      <a href="#" class="footer-link" onclick="confirmLogout(event)">
        <i class="bi bi-box-arrow-in-left"></i>
        Logout
      </a>
    </div>
  </div>
</div>

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Logout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Apakah Anda yakin ingin keluar?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <a href="../handlers/logout_handler.php" class="btn btn-danger">Ya, Logout</a>
      </div>
    </div>
  </div>
</div>

<script>
function confirmLogout(e) {
  e.preventDefault();
  const modal = new bootstrap.Modal(document.getElementById('logoutModal'));
  modal.show();
}
</script>
