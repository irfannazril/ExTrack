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
            <a href="./assets.php" class="nav-item">
              <i class="bi bi-wallet2"></i>
              <span>Assets</span>
            </a>
            <a href="./statistics.php" class="nav-item active">
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
        <div class="main-content statistic-page">
          <div class="header">
            <button class="hamburger-btn" id="hamburgerBtn">
              <i class="bi bi-list"></i>
            </button>
            <div class="menu">Statistics</div>
            <button class="add-wallet-btn" data-bs-toggle="modal" data-bs-target="#addTransactionModal">Add Category</button>
          </div>

          <!-- Charts -->
          <div class="chart-scroll overflow-y-auto">
            <div class="section-title">Expenses Statistic</div>
            <div id="charts" class="mb-4" style="width:100%; height:400px; padding: 10px;"></div>
            <div class="section-title">Category</div>
            <div class="stats-item2">
              <div class="d-flex align-items-center">
                <span class="stats-category">🍕</span>
                <span class="stats-name">Food</span>
              </div>
              <div class="stats-actions">
                <button class="btn-edit" onclick="editCategory('Food', '🍕')">Edit</button>
                <button class="btn-delete" onclick="deleteCategory('Food')">Delete</button>
              </div>
            </div>
            <div class="stats-item2">
              <div class="d-flex align-items-center">
                <span class="stats-category">🍕</span>
                <span class="stats-name">Food</span>
              </div>
              <div class="stats-actions">
                <button class="btn-edit" onclick="editCategory('Food', '🍕')">Edit</button>
                <button class="btn-delete" onclick="deleteCategory('Food')">Delete</button>
              </div>
            </div>
            <div class="stats-item2">
              <div class="d-flex align-items-center">
                <span class="stats-category">🍕</span>
                <span class="stats-name">Food</span>
              </div>
              <div class="stats-actions">
                <button class="btn-edit" onclick="editCategory('Food', '🍕')">Edit</button>
                <button class="btn-delete" onclick="deleteCategory('Food')">Delete</button>
              </div>
            </div>
            <div class="stats-item2">
              <div class="d-flex align-items-center">
                <span class="stats-category">🍕</span>
                <span class="stats-name">Food</span>
              </div>
              <div class="stats-actions">
                <button class="btn-edit" onclick="editCategory('Food', '🍕')">Edit</button>
                <button class="btn-delete" onclick="deleteCategory('Food')">Delete</button>
              </div>
            </div>
            <div class="stats-item2">
              <div class="d-flex align-items-center">
                <span class="stats-category">🍕</span>
                <span class="stats-name">Food</span>
              </div>
              <div class="stats-actions">
                <button class="btn-edit" onclick="editCategory('Food', '🍕')">Edit</button>
                <button class="btn-delete" onclick="deleteCategory('Food')">Delete</button>
              </div>
            </div>
            <div class="stats-item2">
              <div class="d-flex align-items-center">
                <span class="stats-category">🍕</span>
                <span class="stats-name">Transport</span>
              </div>
              <div class="stats-actions">
                <button class="btn-edit" onclick="editCategory('Food', '🍕')">Edit</button>
                <button class="btn-delete" onclick="deleteCategory('Food')">Delete</button>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Add Category -->
  <div class="modal fade" id="addTransactionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <form id="transactionForm">
            <div class="mb-3">
              <label for="addCategoryIcon" class="form-label">Icon<span class="required">*</span></label>
              <input type="text" class="form-control" id="addCategoryIcon" placeholder="Choose an emoji" required>
            </div>
            <div class="mb-3">
              <label for="addCategoryName" class="form-label">Name<span class="required">*</span></label>
              <input type="text" class="form-control" id="addCategoryName" placeholder="e.g., Food, Transport, etc." required>
            </div>

            <button type="submit" class="btn-save">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Category Modal -->
  <div class="modal fade" id="editCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <form id="editCategoryForm">
            <div class="mb-3">
              <label for="editCategoryIcon" class="form-label">Icon (Emoji)<span class="required">*</span></label>
              <input type="text" class="form-control" id="editCategoryIcon" placeholder="Choose an emoji" maxlength="1" required>
            </div>
            <div class="mb-3">
              <label for="editCategoryName" class="form-label">Category Name<span class="required">*</span></label>
              <input type="text" class="form-control" id="editCategoryName" placeholder="e.g., Food, Transport, etc." required>
            </div>

            <button type="submit" class="btn-save">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <?php include '../data/chart.php'; ?>
  <script src="./js/script.js"></script>
</body>

</html>