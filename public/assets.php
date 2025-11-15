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

            <a href="./index.php" class="nav-item">
              <i class="bi bi-grid"></i>
              <span>Dashboard</span>
            </a>
            <a href="./transaction.php" class="nav-item">
              <i class="bi bi-cash-stack"></i>
              <span>Transactions</span>
            </a>
            <a href="./assets.php" class="nav-item active">
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
      <div class="col-lg-6">
        <div class="main-content">
          <div class="header">
            <button class="hamburger-btn" id="hamburgerBtn">
              <i class="bi bi-list"></i>
            </button>
            <div class="menu">Assets</div>
            <button class="add-wallet-btn" data-bs-toggle="modal" data-bs-target="#addTransactionModal">Add Asset</button>
          </div>

          <!-- Asset List -->
          <div class="section-title">Assets List</div>

          <div class="asset-scroll overflow-y-scroll">
            <div class="card-balance">
              <div class="card-info">
                <div class="card-label">Cash</div>
                <div class="card-amount">100.000.000 IDR</div>
              </div>
              <div class="card-menu">
                <div class="transaction-menu">
                  <i class="bi bi-three-dots-vertical"></i>
                </div>
              </div>
            </div>
            <div class="card-balance">
              <div class="card-info">
                <div class="card-label">bank</div>
                <div class="card-amount">300.000.000 IDR</div>
              </div>
              <div class="card-menu">
                <div class="transaction-menu">
                  <i class="bi bi-three-dots-vertical"></i>
                </div>
              </div>
            </div>
            <div class="card-balance">
              <div class="card-info">
                <div class="card-label">E-Money</div>
                <div class="card-amount">500.000.000 IDR</div>
              </div>
              <div class="card-menu">
                <div class="transaction-menu">
                  <i class="bi bi-three-dots-vertical"></i>
                </div>
              </div>
            </div>
            <div class="card-balance">
              <div class="card-info">
                <div class="card-label">E-Money</div>
                <div class="card-amount">500.000.000 IDR</div>
              </div>
              <div class="card-menu">
                <div class="transaction-menu">
                  <i class="bi bi-three-dots-vertical"></i>
                </div>
              </div>
            </div>
            <div class="card-balance">
              <div class="card-info">
                <div class="card-label">E-Money</div>
                <div class="card-amount">500.000.000 IDR</div>
              </div>
              <div class="card-menu">
                <div class="transaction-menu">
                  <i class="bi bi-three-dots-vertical"></i>
                </div>
              </div>
            </div>
            <div class="card-balance">
              <div class="card-info">
                <div class="card-label">E-Money</div>
                <div class="card-amount">500.000.000 IDR</div>
              </div>
              <div class="card-menu">
                <div class="transaction-menu">
                  <i class="bi bi-three-dots-vertical"></i>
                </div>
              </div>
            </div>
            <div class="card-balance">
              <div class="card-info">
                <div class="card-label">E-Money</div>
                <div class="card-amount">500.000.000 IDR</div>
              </div>
              <div class="card-menu">
                <div class="transaction-menu">
                  <i class="bi bi-three-dots-vertical"></i>
                </div>
              </div>
            </div>
            <div class="card-balance">
              <div class="card-info">
                <div class="card-label">E-Money</div>
                <div class="card-amount">500.000.000 IDR</div>
              </div>
              <div class="card-menu">
                <div class="transaction-menu">
                  <i class="bi bi-three-dots-vertical"></i>
                </div>
              </div>
            </div>
            <div class="card-balance">
              <div class="card-info">
                <div class="card-label">E-Money</div>
                <div class="card-amount">1.000.000 IDR</div>
              </div>
              <div class="card-menu">
                <div class="transaction-menu">
                  <i class="bi bi-three-dots-vertical"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Stats Display -->
      <div class="col-lg-3">
        <div class="side-content">
          <div class="side-content-title">Top Expenses</div>

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
              <span class="stats-category">🍕</span>
              <span class="stats-name">Transport</span>
            </div>
            <div class="progress" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
              <div class="progress-bar" style="width: 75%">75%</div>
            </div>
          </div>
          <div class="stats-item">
            <div class="d-flex align-items-center mb-3">
              <span class="stats-category">🍕</span>
              <span class="stats-name">Entertainment</span>
            </div>
            <div class="progress" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
              <div class="progress-bar" style="width: 50%">50%</div>
            </div>
          </div>
          <div class="stats-item">
            <div class="d-flex align-items-center mb-3">
              <span class="stats-category">🍕</span>
              <span class="stats-name">Food</span>
            </div>
            <div class="progress" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
              <div class="progress-bar" style="width: 80%">80%</div>
            </div>
          </div>
          <div class="stats-item">
            <div class="d-flex align-items-center mb-3">
              <span class="stats-category">🍕</span>
              <span class="stats-name">Food</span>
            </div>
            <div class="progress" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
              <div class="progress-bar" style="width: 60%">60%</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="addTransactionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Asset</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <form id="transactionForm">
            <div class="mb-3">
              <label for="assetName" class="form-label">Name<span class="required">*</span></label>
              <input type="text" class="form-control" id="assetName" placeholder="e.g., Cash, Bank, etc." required>
            </div>
            <div class="mb-3">
              <label for="assetAmount" class="form-label">Amount<span class="required">*</span></label>
              <input type="text" class="form-control" id="assetAmount" placeholder="0 IDR" required>
            </div>

            <button type="submit" class="btn-save">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./js/script.js"></script>
</body>

</html>