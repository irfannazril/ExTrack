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
            <a href="./transaction.php" class="nav-item active">
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
        <div class="main-content transaction-page">
          <div class="header">
            <button class="hamburger-btn" id="hamburgerBtn">
              <i class="bi bi-list"></i>
            </button>
            <div class="menu">Transactions</div>
            <button class="add-wallet-btn" data-bs-toggle="modal" data-bs-target="#addTransactionModal">Add Transaction</button>
          </div>

          <!-- Transaction List -->
          <div class="section-title">Transactions List</div>
          <div class="transaction-scroll">
            <div class="transaction-date">15 Nov 2025</div>
            <div class="transaction-item ">
              <div class="transaction-left">
                <div class="transaction-icon">
                  <span class="">🚗</span>
                </div>
                <div class="transaction-details">
                  <div class="transaction-amount" id="expense">-150,000 IDR</div>
                  <div class="transaction-description">Holiday</div>
                  <div class="transaction-category">Transport</div>
                </div>
              </div>
              <div class="transaction-menu">
                <button class="menu-button" data-bs-toggle="modal" data-bs-target="#editTransactionModal"><i class="bi bi-three-dots-vertical"></i></button>
              </div>
            </div>
            <div class="transaction-item ">
              <div class="transaction-left">
                <div class="transaction-icon">
                  <i class="bi bi-cash"></i>
                </div>
                <div class="transaction-details">
                  <div class="transaction-amount" id="income">+350,000 IDR</div>
                  <div class="transaction-description">Salary</div>
                  <div class="transaction-category">Earning</div>
                </div>
              </div>
              <div class="transaction-menu">
                <button class="menu-button" data-bs-toggle="modal" data-bs-target="#editTransactionModal"><i class="bi bi-three-dots-vertical"></i></button>
              </div>
            </div>
            <div class="transaction-item ">
              <div class="transaction-left">
                <div class="transaction-icon">
                  <span class="">🍕</span>
                </div>
                <div class="transaction-details">
                  <div class="transaction-amount" id="expense">-350,000 IDR</div>
                  <div class="transaction-description">Pizza</div>
                  <div class="transaction-category">Food</div>
                </div>
              </div>
              <div class="transaction-menu">
                <button class="menu-button" data-bs-toggle="modal" data-bs-target="#editTransactionModal"><i class="bi bi-three-dots-vertical"></i></button>
              </div>
            </div>

            <div class="transaction-date">14 Nov 2025</div>
            <div class="transaction-item ">
              <div class="transaction-left">
                <div class="transaction-icon">
                  <span class="">🚗</span>
                </div>
                <div class="transaction-details">
                  <div class="transaction-amount" id="expense">-150,000 IDR</div>
                  <div class="transaction-description">Holiday</div>
                  <div class="transaction-category">Transport</div>
                </div>
              </div>
              <div class="transaction-menu">
                <button class="menu-button" data-bs-toggle="modal" data-bs-target="#editTransactionModal"><i class="bi bi-three-dots-vertical"></i></button>
              </div>
            </div>
            <div class="transaction-item ">
              <div class="transaction-left">
                <div class="transaction-icon">
                  <i class="bi bi-cash"></i>
                </div>
                <div class="transaction-details">
                  <div class="transaction-amount" id="income">+350,000 IDR</div>
                  <div class="transaction-description">Salary</div>
                  <div class="transaction-category">Earning</div>
                </div>
              </div>
              <div class="transaction-menu">
                <button class="menu-button" data-bs-toggle="modal" data-bs-target="#editTransactionModal"><i class="bi bi-three-dots-vertical"></i></button>
              </div>
            </div>


          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Add Transaction -->
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
              <input type="radio" class="type-tab-radio" data-type="expense" name="transaction-type" id="Expense" checked></input>
              <label class="type-tab active" for="Expense">Expense</label>
              <input type="radio" class="type-tab-radio" data-type="income" name="transaction-type" id="Income"></input>
              <label class="type-tab" for="Income">Income</label>
              <input type="radio" class="type-tab-radio" data-type="transfer" name="transaction-type" id="Transfer"></input>
              <label class="type-tab" for="Transfer">Transfer</label>
            </div>

            <div class="row">
              <!-- Amount -->
              <div class="col-md-6 mb-3">
                <label for="amount" class="form-label">Amount<span class="required">*</span></label>
                <div class="input-group">
                  <input type="number" class="form-control" placeholder="0 IDR" min="1" id="amount" required>
                </div>
              </div>

              <!-- Description -->
              <div class="col-md-6 mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" placeholder="Bought some snacks" id="description">
              </div>

              <!-- Category (for Expense & Income) -->
              <div class="col-12 mb-3" id="categoryField">
                <label for="category" class="form-label">Category<span class="required">*</span></label>
                <select class="form-select" id="category" required>
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
                <label for="from-account-transfer" class="form-label">From Account<span class="required">*</span></label>
                <select class="form-select" id="from-account-transfer">
                  <option value="" selected>Select account</option>
                  <option value="cash">💵 Cash</option>
                  <option value="bank">🏦 Bank</option>
                  <option value="ewallet">📱 E-Wallet</option>
                </select>
              </div>

              <!-- To Account (for Transfer) -->
              <div class="col-md-6 mb-3 d-none" id="toAccountField">
                <label for="to-account-transfer" class="form-label">To Account<span class="required">*</span></label>
                <select class="form-select" id="to-account-transfer">
                  <option value="" selected>Select account</option>
                  <option value="cash">💵 Cash</option>
                  <option value="bank">🏦 Bank</option>
                  <option value="ewallet">📱 E-Wallet</option>
                </select>
              </div>

              <!-- Event Date -->
              <div class="col-12 mb-3">
                <label for="eventDate" class="form-label">Event date</label>
                <input type="date" class="form-control" id="eventDate">
              </div>
            </div>

            <button type="submit" class="btn-save">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Transaction -->
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
              <input type="radio" class="type-tab-radio" data-type="expense" name="transaction-type" id="Expense" checked></input>
              <label class="type-tab active" for="Expense">Expense</label>
              <input type="radio" class="type-tab-radio" data-type="income" name="transaction-type" id="Income"></input>
              <label class="type-tab" for="Income">Income</label>
              <input type="radio" class="type-tab-radio" data-type="transfer" name="transaction-type" id="Transfer"></input>
              <label class="type-tab" for="Transfer">Transfer</label>
            </div>

            <div class="row">
              <!-- Amount -->
              <div class="col-md-6 mb-3">
                <label for="amount" class="form-label">Amount<span class="required">*</span></label>
                <div class="input-group">
                  <input type="number" class="form-control" placeholder="0 IDR" min="1" id="amount" required>
                </div>
              </div>

              <!-- Description -->
              <div class="col-md-6 mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" placeholder="Bought some snacks" id="description">
              </div>

              <!-- Category (for Expense & Income) -->
              <div class="col-12 mb-3" id="categoryField">
                <label for="category" class="form-label">Category<span class="required">*</span></label>
                <select class="form-select" id="category" required>
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
                <label for="from-account-transfer" class="form-label">From Account<span class="required">*</span></label>
                <select class="form-select" id="from-account-transfer">
                  <option value="" selected>Select account</option>
                  <option value="cash">💵 Cash</option>
                  <option value="bank">🏦 Bank</option>
                  <option value="ewallet">📱 E-Wallet</option>
                </select>
              </div>

              <!-- To Account (for Transfer) -->
              <div class="col-md-6 mb-3 d-none" id="toAccountField">
                <label for="to-account-transfer" class="form-label">To Account<span class="required">*</span></label>
                <select class="form-select" id="to-account-transfer">
                  <option value="" selected>Select account</option>
                  <option value="cash">💵 Cash</option>
                  <option value="bank">🏦 Bank</option>
                  <option value="ewallet">📱 E-Wallet</option>
                </select>
              </div>

              <!-- Event Date -->
              <div class="col-12 mb-3">
                <label for="eventDate" class="form-label">Event date</label>
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