<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ExTrack</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="./css/style.css">

</head>

<body>
  <!-- Sidebar Overlay -->
  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <div class="dashboard-container">
    <div class="row g-0">
      <!-- Sidebar -->
      <div class="col-lg-2 col-md-3">
        <div class="sidebar" id="sidebar">
          <button class="close-sidebar-btn" id="closeSidebar">
            <i class="bi bi-x"></i>
          </button>

          <div class="logo">ExTrack</div>

          <div class="nav-item active">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
          </div>
          <div class="nav-item">
            <i class="bi bi-wallet2"></i>
            <span>Wallets</span>
          </div>
          <div class="nav-item">
            <i class="bi bi-tag"></i>
            <span>Categories</span>
          </div>
          <div class="nav-item">
            <i class="bi bi-gear"></i>
            <span>Settings</span>
          </div>

          <div class="footer-links">
            <a href="#" class="footer-link">
              <i class="bi bi-chat-dots"></i>
              Give feedback
            </a>
            <a href="#" class="footer-link">
              <i class="bi bi-flag"></i>
              Report issue
            </a>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="col-lg-10 col-md-9">
        <div class="main-content">
          <div class="header">
            <button class="hamburger-btn" id="hamburgerBtn">
              <i class="bi bi-list"></i>
            </button>
            <button class="add-wallet-btn">Add Wallet</button>
          </div>

          <!-- Total Money (Saldo)-->
          <div class="row mb-4">
            <div class="section-title">Total Money</div>
            <div class="col-md-6">
              <div class="total-money-card">
                <div class="total-money-amount">100.000.000</div>
                <div class="total-money-currency">IDR</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="total-money-card">
                <div class="total-money-amount">897.01</div>
                <div class="total-money-currency">EUR</div>
              </div>
            </div>
          </div>

          <!-- Last Transactions -->
          <div class="row">
            <div class="col-lg-4">
              <div class="section-title">Last Transactions</div>

              <div class="transaction-item">
                <div class="transaction-left">
                  <div class="transaction-icon">
                    <i class="bi bi-arrow-down-left"></i>
                  </div>
                  <div>
                    <div class="transaction-amount">+38 EUR</div>
                    <div class="transaction-type">Transfer</div>
                  </div>
                </div>
                <div class="transaction-menu">
                  <i class="bi bi-three-dots-vertical"></i>
                </div>
              </div>

              <div class="transaction-item">
                <div class="transaction-left">
                  <div class="transaction-icon">
                    <i class="bi bi-arrow-down-left"></i>
                  </div>
                  <div>
                    <div class="transaction-amount">40 USD</div>
                    <div class="transaction-type">Transfer</div>
                  </div>
                </div>
                <div class="transaction-menu">
                  <i class="bi bi-three-dots-vertical"></i>
                </div>
              </div>

              <div class="transaction-item">
                <div class="transaction-left">
                  <div class="transaction-icon">
                    <i class="bi bi-arrow-down-left"></i>
                  </div>
                  <div>
                    <div class="transaction-amount">+640 USD</div>
                    <div class="transaction-type">Freelance</div>
                  </div>
                </div>
                <div class="transaction-menu">
                  <i class="bi bi-three-dots-vertical"></i>
                </div>
              </div>

              <div class="transaction-item">
                <div class="transaction-left">
                  <div class="transaction-icon">
                    <i class="bi bi-arrow-down-left"></i>
                  </div>
                  <div>
                    <div class="transaction-amount">15 EUR</div>
                    <div class="transaction-type">Disney Plus</div>
                  </div>
                </div>
                <div class="transaction-menu">
                  <i class="bi bi-three-dots-vertical"></i>
                </div>
              </div>
            </div>

            <!-- Asset -->
            <div class="col-lg-4">
              <div class="section-title">Asset</div>
              <div class="card-balance">
                <div class="card-label">Cash</div>
                <div class="card-amount">675 USD</div>
              </div>
              <div class="card-balance">
                <div class="card-label">Revolut</div>
                <div class="card-amount">897.01 EUR</div>
              </div>
              <div class="card-balance">
                <div class="card-label">Bank of America</div>
                <div class="card-amount">4588.11 USD</div>
              </div>


            </div>

            <!-- All Subscriptions -->
            <div class="col-lg-4">
              <div class="section-title">All Subscriptions</div>

              <div class="subscription-item">
                <div class="d-flex align-items-center">
                  <i class="bi bi-chevron-down dropdown-icon"></i>
                  <span class="subscription-name">Bank Account Fee</span>
                </div>
                <div class="subscription-amount">16.55 USD</div>
              </div>

              <div class="subscription-item">
                <div class="d-flex align-items-center">
                  <i class="bi bi-check-circle-fill check-icon"></i>
                  <span class="subscription-name">Disney Plus</span>
                </div>
                <div class="subscription-amount">16 EUR</div>
              </div>

              <div class="subscription-item">
                <div class="d-flex align-items-center">
                  <i class="bi bi-check-circle-fill check-icon"></i>
                  <span class="subscription-name">Netflix</span>
                </div>
                <div class="subscription-amount">9.99 USD</div>
              </div>

              <div class="subscription-item">
                <div class="d-flex align-items-center">
                  <i class="bi bi-check-circle-fill check-icon"></i>
                  <span class="subscription-name">Spotify</span>
                </div>
                <div class="subscription-amount">9.99 EUR</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const closeSidebar = document.getElementById('closeSidebar');

    hamburgerBtn.addEventListener('click', () => {
      sidebar.classList.add('active');
      sidebarOverlay.classList.add('active');
      document.body.style.overflow = 'hidden';
    });

    closeSidebar.addEventListener('click', () => {
      sidebar.classList.remove('active');
      sidebarOverlay.classList.remove('active');
      document.body.style.overflow = '';
    });

    sidebarOverlay.addEventListener('click', () => {
      sidebar.classList.remove('active');
      sidebarOverlay.classList.remove('active');
      document.body.style.overflow = '';
    });

    // Close sidebar when clicking nav items on mobile
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => {
      item.addEventListener('click', () => {
        if (window.innerWidth <= 991) {
          sidebar.classList.remove('active');
          sidebarOverlay.classList.remove('active');
          document.body.style.overflow = '';
        }
      });
    });
  </script>
</body>

</html>