<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/functions.php';

$stmt = $conn->prepare("SELECT * FROM categories WHERE user_id = ? ORDER BY category_type, category_name");
$stmt->execute([$user_id]);
$categories = $stmt->fetchAll();

$expense_cats = array_filter($categories, fn($c) => $c['category_type'] === 'expense');
$income_cats = array_filter($categories, fn($c) => $c['category_type'] === 'income');
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Statistics - ExTrack</title>
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
        <div class="main-content statistic-page">
          <div class="header">
            <button class="hamburger-btn" id="hamburgerBtn"><i class="bi bi-list"></i></button>
            <div class="menu">Statistics</div>
            <button class="add-wallet-btn" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add Category</button>
          </div>
          
          <?php include __DIR__ . '/../includes/alert.php'; ?>
          
          <div class="chart-scroll">
            <div class="section-title">Income Statistics</div>
            <div id="incomeChart" style="width:100%; height:400px; padding: 10px;"></div>
            
            <div class="section-title mt-4">Expense Statistics</div>
            <div id="expenseChart" style="width:100%; height:400px; padding: 10px;"></div>
            
            <div class="section-title mt-4">Income Categories</div>
            <?php if (empty($income_cats)): ?>
              <p class="text-muted">Belum ada kategori income</p>
            <?php else: ?>
              <?php foreach ($income_cats as $cat): ?>
                <div class="stats-item2">
                  <div class="d-flex align-items-center">
                    <span class="stats-category"><?= $cat['icon'] ?></span>
                    <span class="stats-name"><?= htmlspecialchars($cat['category_name']) ?></span>
                    <?php if ($cat['is_default']): ?>
                      <span class="badge bg-secondary ms-2">Default</span>
                    <?php endif; ?>
                  </div>
                  <div class="stats-actions">
                    <button class="btn-edit" onclick='editCategory(<?= json_encode($cat) ?>)'>Edit</button>
                    <?php if (!$cat['is_default']): ?>
                      <button class="btn-delete" onclick="confirmDeleteCategory(<?= $cat['category_id'] ?>)">Delete</button>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
            
            <div class="section-title mt-4">Expense Categories</div>
            <?php if (empty($expense_cats)): ?>
              <p class="text-muted">Belum ada kategori expense</p>
            <?php else: ?>
              <?php foreach ($expense_cats as $cat): ?>
                <div class="stats-item2">
                  <div class="d-flex align-items-center">
                    <span class="stats-category"><?= $cat['icon'] ?></span>
                    <span class="stats-name"><?= htmlspecialchars($cat['category_name']) ?></span>
                    <?php if ($cat['is_default']): ?>
                      <span class="badge bg-secondary ms-2">Default</span>
                    <?php endif; ?>
                  </div>
                  <div class="stats-actions">
                    <button class="btn-edit" onclick='editCategory(<?= json_encode($cat) ?>)'>Edit</button>
                    <?php if (!$cat['is_default']): ?>
                      <button class="btn-delete" onclick="confirmDeleteCategory(<?= $cat['category_id'] ?>)">Delete</button>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Category Modal -->
  <div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="../handlers/category_handler.php">
            <input type="hidden" name="action" value="add">
            <div class="mb-3">
              <label class="form-label">Type<span class="required">*</span></label>
              <div class="transaction-type-tabs" style="margin-bottom: 0;">
                <input type="radio" class="type-tab-radio" name="category_type" id="typeExpense" value="expense" checked>
                <label class="type-tab" for="typeExpense">Expense</label>
                <input type="radio" class="type-tab-radio" name="category_type" id="typeIncome" value="income">
                <label class="type-tab" for="typeIncome">Income</label>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Icon (Emoji)<span class="required">*</span></label>
              <input type="text" class="form-control" name="icon" placeholder="Choose an emoji" maxlength="2" required>
              <small class="text-muted">Tip: Press Windows + . untuk emoji picker</small>
            </div>
            <div class="mb-3">
              <label class="form-label">Name<span class="required">*</span></label>
              <input type="text" class="form-control" name="category_name" placeholder="e.g., Food, Transport, etc." required>
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
          <form method="POST" action="../handlers/category_handler.php">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="category_id" id="editCategoryId">
            <div class="mb-3">
              <label class="form-label">Icon (Emoji)<span class="required">*</span></label>
              <input type="text" class="form-control" name="icon" id="editCategoryIcon" maxlength="2" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Name<span class="required">*</span></label>
              <input type="text" class="form-control" name="category_name" id="editCategoryName" required>
            </div>
            <button type="submit" class="btn-save">Update</button>
          </form>
          <form method="POST" action="../handlers/category_handler.php" id="deleteCategoryForm" class="d-none">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="category_id" id="deleteCategoryId">
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <?php include __DIR__ . '/../data/chart_template.php'; ?>
  <script src="../assets/js/script.js"></script>
  <script>
    function editCategory(cat) {
      document.getElementById('editCategoryId').value = cat.category_id;
      document.getElementById('deleteCategoryId').value = cat.category_id;
      document.getElementById('editCategoryIcon').value = cat.icon;
      document.getElementById('editCategoryName').value = cat.category_name;
      new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
    }
    
    function confirmDeleteCategory(id) {
      if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
        document.getElementById('deleteCategoryId').value = id;
        document.getElementById('deleteCategoryForm').submit();
      }
    }
  </script>
</body>
</html>
