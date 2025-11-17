<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

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
      <div class="col-lg-3">
        <div class="sidebar" id="sidebar">
          <div class="sidebar-top">
            <button class="close-sidebar-btn" id="closeSidebar">
              <i class="bi bi-x"></i>
            </button>

            <div class="logo">
              <span class="logo-color">Ex</span>Track
            </div>

            <a href="#" class="nav-item active">
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
            <a href="#" class="nav-item">
              <i class="bi bi-gear"></i>
              <span>Settings</span>
            </a>
          </div>

          <div class="sidebar-bottom">
            <div class="footer-links">
              <a href="#" class="footer-link">
                <img class="profile" src="../img/profile.jpg"></img>
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
            <div class="menu">Dashboard</div>
            <a href="./transaction.php?action=add" class="add-wallet-btn" style="text-decoration: none;">Add Transaction</a>
          </div>

          <!-- Total Money (Saldo)-->
          <div class="row mb-4">
            <div class="section-title">Total Money</div>
            <div class="col-lg-12">
              <div class="total-money-card">
                <div class="total-money-amount">100.000.000</div>
                <div class="total-money-currency">IDR</div>
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
                    <i class="bi bi-arrow-left-right"></i>
                  </div>
                  <div>
                    <div class="transaction-amount">100.000.000 IDR</div>
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
                    <i class="bi bi-arrow-left-right"></i>
                  </div>
                  <div>
                    <div class="transaction-amount">50.000 IDR</div>
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
                    <i class="bi bi-graph-up-arrow"></i>
                  </div>
                  <div>
                    <div class="transaction-amount income">+100.000 IDR</div>
                    <div class="transaction-type">Income</div>
                  </div>
                </div>
                <div class="transaction-menu">
                  <i class="bi bi-three-dots-vertical"></i>
                </div>
              </div>

              <div class="transaction-item">
                <div class="transaction-left">
                  <div class="transaction-icon">
                    <i class="bi bi-graph-down-arrow"></i>
                  </div>
                  <div>
                    <div class="transaction-amount expense">20.000 IDR</div>
                    <div class="transaction-type">Expense</div>
                  </div>
                </div>
                <div class="transaction-menu">
                  <i class="bi bi-three-dots-vertical"></i>
                </div>
              </div>
            </div>

            <!-- Assets -->
            <div class="col-lg-4">
              <div class="section-title">Assets</div>
              <div class="card-balance">
                <div class="card-info">
                  <div class="card-label">Cash</div>
                  <div class="card-amount">100.000.000 IDR</div>
                </div>
              </div>
              <div class="card-balance">
                <div class="card-info">
                  <div class="card-label">Bank</div>
                  <div class="card-amount">100.000.000 IDR</div>
                </div>
              </div>
            </div>

            <!-- Statistics -->
            <div class="col-lg-4">
              <div class="section-title">Top Expense</div>
              <div class="stats-item">
                <div class="d-flex align-items-center mb-3">
                  <span class="stats-category">🍕</span>
                  <span class="stats-name">Food</span>
                </div>
                <div class="progress" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar" style="width: 25%">25%</div>
                </div>
              </div>

              <div class="stats-item">
                <div class="d-flex align-items-center mb-3">
                  <span class="stats-category">🚗</span>
                  <span class="stats-name">Transport</span>
                </div>
                <div class="progress" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar" style="width: 50%">50%</div>
                </div>
              </div>

              <div class="stats-item">
                <div class="d-flex align-items-center mb-3">
                  <span class="stats-category">🎲</span>
                  <span class="stats-name">Entertainment</span>
                </div>
                <div class="progress" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar" style="width: 75%">75%</div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./js/script.js"></script>
</body>

</html>