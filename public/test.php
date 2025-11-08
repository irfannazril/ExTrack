<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MONOUT Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <style>
    body {
      background: linear-gradient(135deg, #a8b5c7 0%, #d4b5a8 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
      padding: 20px;
    }

    .dashboard-container {
      background: #000;
      border-radius: 20px;
      max-width: 1100px;
      width: 100%;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      position: relative;
    }

    .sidebar {
      background: #000;
      padding: 30px 20px;
      height: 100%;
      min-height: 500px;
      transition: transform 0.3s ease;
    }

    .hamburger-btn {
      display: none;
      background: #1a1a1a;
      border: none;
      color: #fff;
      font-size: 24px;
      padding: 10px 15px;
      border-radius: 8px;
      cursor: pointer;
      margin-right: 15px;
    }

    .hamburger-btn:hover {
      background: #2a2a2a;
    }

    .sidebar-overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 998;
    }

    @media (max-width: 991px) {
      body {
        padding: 10px;
        align-items: flex-start;
      }

      .dashboard-container {
        border-radius: 15px;
      }

      .hamburger-btn {
        display: block;
      }

      .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        width: 280px;
        height: 100vh;
        z-index: 999;
        transform: translateX(-100%);
        border-radius: 0;
        padding-bottom: 100px;
        overflow-y: auto;
      }

      .sidebar.active {
        transform: translateX(0);
      }

      .sidebar-overlay.active {
        display: block;
      }

      .main-content {
        padding: 20px;
      }

      .header {
        flex-wrap: wrap;
      }
    }

    .logo {
      color: #fff;
      font-weight: 700;
      font-size: 18px;
      margin-bottom: 40px;
      letter-spacing: 2px;
    }

    .nav-item {
      padding: 12px 20px;
      margin-bottom: 8px;
      border-radius: 8px;
      color: #888;
      cursor: pointer;
      transition: all 0.3s;
      display: flex;
      align-items: center;
    }

    .nav-item:hover {
      background: #1a1a1a;
      color: #fff;
    }

    .nav-item.active {
      background: #1a1a1a;
      color: #fff;
    }

    .nav-item i {
      margin-right: 12px;
      font-size: 16px;
    }

    .main-content {
      background: #0a0a0a;
      padding: 30px 40px;
      min-height: 500px;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .add-wallet-btn {
      background: #fff;
      color: #000;
      border: none;
      padding: 10px 24px;
      border-radius: 20px;
      font-weight: 600;
      font-size: 14px;
      cursor: pointer;
      transition: all 0.3s;
    }

    .add-wallet-btn:hover {
      background: #f0f0f0;
    }

    .card-balance {
      background: #1a1a1a;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 20px;
    }

    .card-label {
      color: #666;
      font-size: 12px;
      margin-bottom: 8px;
    }

    .card-amount {
      color: #fff;
      font-size: 24px;
      font-weight: 700;
    }

    .section-title {
      color: #666;
      font-size: 13px;
      margin-bottom: 15px;
      font-weight: 500;
    }

    .transaction-item {
      background: #1a1a1a;
      border-radius: 12px;
      padding: 16px 20px;
      margin-bottom: 12px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .transaction-left {
      display: flex;
      align-items: center;
    }

    .transaction-icon {
      width: 40px;
      height: 40px;
      background: #2a2a2a;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
      color: #888;
    }

    .transaction-amount {
      color: #fff;
      font-size: 16px;
      font-weight: 600;
    }

    .transaction-type {
      color: #666;
      font-size: 13px;
      margin-top: 2px;
    }

    .transaction-menu {
      color: #666;
      cursor: pointer;
      padding: 5px;
    }

    .total-money-card {
      background: #1a1a1a;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 20px;
    }

    .total-money-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
    }

    .total-money-amount {
      color: #fff;
      font-size: 28px;
      font-weight: 700;
    }

    .total-money-currency {
      color: #fff;
      font-size: 16px;
    }

    .subscription-item {
      background: #1a1a1a;
      border-radius: 12px;
      padding: 16px 20px;
      margin-bottom: 12px;
    }

    .subscription-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 10px;
    }

    .subscription-left {
      display: flex;
      align-items: center;
      flex: 1;
    }

    .subscription-icon {
      width: 45px;
      height: 45px;
      background: #2a2a2a;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
      font-size: 24px;
    }

    .subscription-name {
      color: #fff;
      font-size: 16px;
      font-weight: 500;
    }

    .subscription-amount {
      color: #fff;
      font-size: 15px;
      font-weight: 600;
      white-space: nowrap;
    }

    .subscription-left-text {
      color: #888;
      font-size: 13px;
    }

    .progress-bar-container {
      width: 100%;
      height: 6px;
      background: #2a2a2a;
      border-radius: 10px;
      overflow: hidden;
    }

    .progress-bar-fill {
      height: 100%;
      border-radius: 10px;
      transition: width 0.3s ease;
    }

    .progress-bar-fill.green {
      background: #4ade80;
    }

    .progress-bar-fill.yellow {
      background: #fbbf24;
    }

    .progress-bar-fill.red {
      background: #ef4444;
    }

    .footer-links {
      position: absolute;
      bottom: 30px;
      left: 20px;
    }

    .footer-link {
      color: #666;
      font-size: 13px;
      display: flex;
      align-items: center;
      margin-bottom: 10px;
      cursor: pointer;
      text-decoration: none;
    }

    .footer-link:hover {
      color: #888;
    }

    .footer-link i {
      margin-right: 10px;
    }

    .close-sidebar-btn {
      display: none;
      position: absolute;
      top: 20px;
      right: 20px;
      background: #1a1a1a;
      border: none;
      color: #fff;
      font-size: 24px;
      width: 40px;
      height: 40px;
      border-radius: 8px;
      cursor: pointer;
      align-items: center;
      justify-content: center;
    }

    @media (max-width: 991px) {
      .close-sidebar-btn {
        display: flex;
      }
    }
  </style>
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

          <div class="logo">MONOUT</div>

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

          <!-- Balance Cards -->
          <div class="row mb-4">
            <div class="col-md-4">
              <div class="card-balance">
                <div class="card-label">Dash</div>
                <div class="card-amount">675 USD</div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card-balance">
                <div class="card-label">Revolut</div>
                <div class="card-amount">897.01 EUR</div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card-balance">
                <div class="card-label">Bank of America</div>
                <div class="card-amount">4588.11 USD</div>
              </div>
            </div>
          </div>

          <div class="row">
            <!-- Last Transactions -->
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

            <!-- Total Money -->
            <div class="col-lg-4">
              <div class="section-title">Total Money</div>

              <div class="total-money-card">
                <div class="total-money-row">
                  <div class="total-money-amount">5263.11</div>
                  <div class="total-money-currency">USD</div>
                </div>
                <div class="total-money-row">
                  <div class="total-money-amount">897.01</div>
                  <div class="total-money-currency">EUR</div>
                </div>
              </div>
            </div>

            <!-- All Subscriptions -->
            <div class="col-lg-4">
              <div class="section-title">Limits by Category</div>

              <div class="subscription-item">
                <div class="subscription-header">
                  <div class="subscription-left">
                    <div class="subscription-icon">🍕</div>
                    <div class="subscription-name">Food</div>
                  </div>
                  <div class="text-end">
                    <div class="subscription-amount">863.10 USD <span class="subscription-left-text">left</span></div>
                  </div>
                </div>
                <div class="progress-bar-container">
                  <div class="progress-bar-fill green" style="width: 92%;"></div>
                </div>
              </div>

              <div class="subscription-item">
                <div class="subscription-header">
                  <div class="subscription-left">
                    <div class="subscription-icon">🚌</div>
                    <div class="subscription-name">Travel</div>
                  </div>
                  <div class="text-end">
                    <div class="subscription-amount">156 USD <span class="subscription-left-text">left</span></div>
                  </div>
                </div>
                <div class="progress-bar-container">
                  <div class="progress-bar-fill yellow" style="width: 35%;"></div>
                </div>
              </div>

              <div class="subscription-item">
                <div class="subscription-header">
                  <div class="subscription-left">
                    <div class="subscription-icon">👕</div>
                    <div class="subscription-name">Clothes</div>
                  </div>
                  <div class="text-end">
                    <div class="subscription-amount">5 USD <span class="subscription-left-text">over</span></div>
                  </div>
                </div>
                <div class="progress-bar-container">
                  <div class="progress-bar-fill red" style="width: 100%;"></div>
                </div>
              </div>

              <div class="subscription-item">
                <div class="subscription-header">
                  <div class="subscription-left">
                    <div class="subscription-icon">🎮</div>
                    <div class="subscription-name">Entertainment</div>
                  </div>
                  <div class="text-end">
                    <div class="subscription-amount">320 USD <span class="subscription-left-text">left</span></div>
                  </div>
                </div>
                <div class="progress-bar-container">
                  <div class="progress-bar-fill green" style="width: 68%;"></div>
                </div>
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