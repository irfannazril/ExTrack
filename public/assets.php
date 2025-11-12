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
            <a href="./assets.php" class="nav-item active">
              <i class="bi bi-wallet2"></i>
              <span>Assets</span>
            </a>
            <a href="#" class="nav-item">
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
          <div class="row mb-4">
            <div class="section-title">Assets List</div>

            <div class="asset-scroll overflow-y-auto">
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

            </div>
          </div>
        </div>
      </div>

      <!-- Stats Display -->
      <div class="col-lg-3">
      </div>

    </div>
  </div>

  <div class="modal fade" id="addTransactionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Transaction</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">

          <form id="transactionForm">
            <!-- Transaction Type Tabs -->
            <div class="transaction-type-tabs">
              <input type="radio" class="type-tab-radio" data-type="expense" name="transaction-type" id="Expense"></input>
              <label class="type-tab active" for="Expense">Expense</label>
              <input type="radio" class="type-tab-radio" data-type="income" name="transaction-type" id="Income"></input>
              <label class="type-tab" for="Income">Income</label>
              <input type="radio" class="type-tab-radio" data-type="transfer" name="transaction-type" id="Transfer"></input>
              <label class="type-tab" for="Transfer">Transfer</label>
            </div>

            <div class="row">
              <!-- Amount -->
              <div class="col-md-6 mb-3">
                <label class="form-label">Amount<span class="required">*</span></label>
                <div class="input-group">
                  <input type="number" class="form-control" placeholder="0 IDR" min="1" required>
                </div>
              </div>

              <!-- Description -->
              <div class="col-md-6 mb-3">
                <label class="form-label">Description</label>
                <input type="text" class="form-control" placeholder="Bought some snacks">
              </div>

              <!-- Category (for Expense & Income) -->
              <div class="col-12 mb-3" id="categoryField">
                <label class="form-label">Category<span class="required">*</span></label>
                <select class="form-select" required>
                  <option value="" selected>Select category</option>
                  <option value="food">🍔 Food</option>
                  <option value="transport">🚗 Transport</option>
                  <option value="entertainment">🎮 Entertainment</option>
                  <option value="shopping">🛍️ Shopping</option>
                  <option value="bills">📄 Bills</option>
                  <option value="health">💊 Health</option>
                  <option value="education">📚 Education</option>
                  <option value="other">📦 Other</option>
                </select>
                <a href="#" class="add-category-link"> Add category
                </a>
              </div>

              <!-- From Account (for Transfer) -->
              <div class="col-md-6 mb-3 d-none" id="fromAccountField">
                <label class="form-label">From Account<span class="required">*</span></label>
                <select class="form-select">
                  <option value="" selected>Select account</option>
                  <option value="cash">💵 Cash</option>
                  <option value="bank">🏦 Bank</option>
                  <option value="ewallet">📱 E-Wallet</option>
                </select>
              </div>

              <!-- To Account (for Transfer) -->
              <div class="col-md-6 mb-3 d-none" id="toAccountField">
                <label class="form-label">To Account<span class="required">*</span></label>
                <select class="form-select">
                  <option value="" selected>Select account</option>
                  <option value="cash">💵 Cash</option>
                  <option value="bank">🏦 Bank</option>
                  <option value="ewallet">📱 E-Wallet</option>
                </select>
              </div>

              <!-- Event Date -->
              <div class="col-12 mb-3">
                <label class="form-label">Event date</label>
                <input type="date" class="form-control" id="eventDate">
              </div>
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