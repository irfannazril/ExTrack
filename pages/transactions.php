<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/functions.php';

// Get filter
$filter = $_GET['filter'] ?? 'all';

// Query transactions dengan filter
$sql = "SELECT t.*, c.category_name, c.icon as category_icon, a.asset_name,
        fa.asset_name as from_asset_name, ta.asset_name as to_asset_name
        FROM transactions t
        LEFT JOIN categories c ON t.category_id = c.category_id
        LEFT JOIN assets a ON t.asset_id = a.asset_id
        LEFT JOIN assets fa ON t.from_asset_id = fa.asset_id
        LEFT JOIN assets ta ON t.to_asset_id = ta.asset_id
        WHERE t.user_id = ?";

if ($filter !== 'all') {
    $sql .= " AND t.transaction_type = ?";
}

$sql .= " ORDER BY t.transaction_date DESC, t.created_at DESC";

$stmt = $conn->prepare($sql);
if ($filter !== 'all') {
    $stmt->execute([$user_id, $filter]);
} else {
    $stmt->execute([$user_id]);
}
$transactions = $stmt->fetchAll();

// Group by date
$grouped = [];
foreach ($transactions as $trans) {
    $date = $trans['transaction_date'];
    if (!isset($grouped[$date])) {
        $grouped[$date] = [];
    }
    $grouped[$date][] = $trans;
}

// Get categories dan assets untuk form
$stmt = $conn->prepare("SELECT * FROM categories WHERE user_id = ? ORDER BY category_type, category_name");
$stmt->execute([$user_id]);
$categories = $stmt->fetchAll();

$stmt = $conn->prepare("SELECT * FROM assets WHERE user_id = ? ORDER BY asset_name");
$stmt->execute([$user_id]);
$assets = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transactions - ExTrack</title>
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
        <div class="main-content transaction-page">
          <div class="header">
            <button class="hamburger-btn" id="hamburgerBtn"><i class="bi bi-list"></i></button>
            <div class="menu">Transactions</div>
            <button class="add-wallet-btn" data-bs-toggle="modal" data-bs-target="#addTransactionModal">Add Transaction</button>
          </div>
          
          <?php include __DIR__ . '/../includes/alert.php'; ?>
          
          <!-- Filter Tabs -->
          <div class="filter-tabs">
            <a href="?filter=all" class="filter-tab all <?= $filter === 'all' ? 'active' : '' ?>">All</a>
            <a href="?filter=income" class="filter-tab income <?= $filter === 'income' ? 'active' : '' ?>">Income</a>
            <a href="?filter=expense" class="filter-tab expense <?= $filter === 'expense' ? 'active' : '' ?>">Expense</a>
            <a href="?filter=transfer" class="filter-tab transfer <?= $filter === 'transfer' ? 'active' : '' ?>">Transfer</a>
          </div>

          <div class="section-title">Transactions List</div>
          <div class="transaction-scroll">
            <?php if (empty($grouped)): ?>
              <p class="text-muted">Belum ada transaksi</p>
            <?php else: ?>
              <?php foreach ($grouped as $date => $trans_list): ?>
                <div class="transaction-date"><?= format_date_indo($date) ?></div>
                <?php foreach ($trans_list as $trans): ?>
                  <div class="transaction-item">
                    <div class="transaction-left">
                      <div class="transaction-icon">
                        <?php if ($trans['transaction_type'] === 'transfer'): ?>
                          <i class="bi bi-arrow-left-right"></i>
                        <?php elseif ($trans['transaction_type'] === 'income'): ?>
                          <i class="bi bi-graph-up-arrow"></i>
                        <?php else: ?>
                          <?= $trans['category_icon'] ?? '📦' ?>
                        <?php endif; ?>
                      </div>
                      <div class="transaction-details">
                        <div class="transaction-amount <?= $trans['transaction_type'] ?>">
                          <?php if ($trans['transaction_type'] === 'income'): ?>
                            +<?= format_currency($trans['amount']) ?> IDR
                          <?php elseif ($trans['transaction_type'] === 'expense'): ?>
                            -<?= format_currency($trans['amount']) ?> IDR
                          <?php else: ?>
                            <?= format_currency($trans['amount']) ?> IDR
                          <?php endif; ?>
                        </div>
                        <div class="transaction-description"><?= htmlspecialchars($trans['description'] ?: '-') ?></div>
                        <div class="transaction-category">
                          <?php if ($trans['transaction_type'] === 'transfer'): ?>
                            <?= htmlspecialchars($trans['from_asset_name']) ?> → <?= htmlspecialchars($trans['to_asset_name']) ?>
                          <?php else: ?>
                            <?= htmlspecialchars($trans['category_name'] ?? 'Uncategorized') ?>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                    <div class="transaction-menu">
                      <button class="menu-button" onclick='editTransaction(<?= json_encode($trans) ?>)'><i class="bi bi-three-dots-vertical"></i></button>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Transaction Modal -->
  <div class="modal fade" id="addTransactionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Transaction</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="../handlers/transaction_handler.php" id="addTransactionForm">
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="type" id="addType" value="expense">
            
            <div class="transaction-type-tabs mb-3">
              <input type="radio" class="type-tab-radio" name="type_tab" id="addExpense" value="expense" checked onchange="switchType('add', 'expense')">
              <label class="type-tab" for="addExpense">Expense</label>
              <input type="radio" class="type-tab-radio" name="type_tab" id="addIncome" value="income" onchange="switchType('add', 'income')">
              <label class="type-tab" for="addIncome">Income</label>
              <input type="radio" class="type-tab-radio" name="type_tab" id="addTransfer" value="transfer" onchange="switchType('add', 'transfer')">
              <label class="type-tab" for="addTransfer">Transfer</label>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Amount<span class="required">*</span></label>
                <input type="number" class="form-control" name="amount" min="1" step="0.01" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Description</label>
                <input type="text" class="form-control" name="description">
              </div>
              
              <div class="col-12 mb-3" id="addCategoryField">
                <label class="form-label">Category<span class="required">*</span></label>
                <select class="form-select" name="category_id" id="addCategorySelect">
                  <option value="">Select category</option>
                  <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['category_id'] ?>" data-type="<?= $cat['category_type'] ?>">
                      <?= $cat['icon'] ?> <?= htmlspecialchars($cat['category_name']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              
              <div class="col-12 mb-3" id="addAssetField">
                <label class="form-label">Asset<span class="required">*</span></label>
                <select class="form-select" name="asset_id">
                  <option value="">Select asset</option>
                  <?php foreach ($assets as $asset): ?>
                    <option value="<?= $asset['asset_id'] ?>"><?= htmlspecialchars($asset['asset_name']) ?> (<?= format_currency($asset['balance']) ?>)</option>
                  <?php endforeach; ?>
                </select>
              </div>
              
              <div class="col-md-6 mb-3 d-none" id="addFromAssetField">
                <label class="form-label">From Asset<span class="required">*</span></label>
                <select class="form-select" name="from_asset_id">
                  <option value="">Select asset</option>
                  <?php foreach ($assets as $asset): ?>
                    <option value="<?= $asset['asset_id'] ?>"><?= htmlspecialchars($asset['asset_name']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              
              <div class="col-md-6 mb-3 d-none" id="addToAssetField">
                <label class="form-label">To Asset<span class="required">*</span></label>
                <select class="form-select" name="to_asset_id">
                  <option value="">Select asset</option>
                  <?php foreach ($assets as $asset): ?>
                    <option value="<?= $asset['asset_id'] ?>"><?= htmlspecialchars($asset['asset_name']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              
              <div class="col-12 mb-3">
                <label class="form-label">Transaction Date</label>
                <input type="date" class="form-control" name="transaction_date" value="<?= date('Y-m-d') ?>">
              </div>
            </div>
            
            <button type="submit" class="btn-save">
              <span class="btn-text">Save</span>
              <span class="btn-loading d-none"><span class="spinner-border spinner-border-sm me-2"></span>Saving...</span>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit/Delete Modal -->
  <div class="modal fade" id="editTransactionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Transaction</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="../handlers/transaction_handler.php" id="editTransactionForm">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="transaction_id" id="editTransactionId">
            <input type="hidden" name="type" id="editType">
            
            <div class="transaction-type-tabs mb-3">
              <input type="radio" class="type-tab-radio" name="type_tab_edit" id="editExpense" value="expense" onchange="switchType('edit', 'expense')">
              <label class="type-tab" for="editExpense">Expense</label>
              <input type="radio" class="type-tab-radio" name="type_tab_edit" id="editIncome" value="income" onchange="switchType('edit', 'income')">
              <label class="type-tab" for="editIncome">Income</label>
              <input type="radio" class="type-tab-radio" name="type_tab_edit" id="editTransfer" value="transfer" onchange="switchType('edit', 'transfer')">
              <label class="type-tab" for="editTransfer">Transfer</label>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Amount<span class="required">*</span></label>
                <input type="number" class="form-control" name="amount" id="editAmount" min="1" step="0.01" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Description</label>
                <input type="text" class="form-control" name="description" id="editDescription">
              </div>
              
              <div class="col-12 mb-3" id="editCategoryField">
                <label class="form-label">Category<span class="required">*</span></label>
                <select class="form-select" name="category_id" id="editCategorySelect">
                  <option value="">Select category</option>
                  <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['category_id'] ?>" data-type="<?= $cat['category_type'] ?>">
                      <?= $cat['icon'] ?> <?= htmlspecialchars($cat['category_name']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              
              <div class="col-12 mb-3" id="editAssetField">
                <label class="form-label">Asset<span class="required">*</span></label>
                <select class="form-select" name="asset_id" id="editAssetSelect">
                  <option value="">Select asset</option>
                  <?php foreach ($assets as $asset): ?>
                    <option value="<?= $asset['asset_id'] ?>"><?= htmlspecialchars($asset['asset_name']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              
              <div class="col-md-6 mb-3 d-none" id="editFromAssetField">
                <label class="form-label">From Asset<span class="required">*</span></label>
                <select class="form-select" name="from_asset_id" id="editFromAssetSelect">
                  <option value="">Select asset</option>
                  <?php foreach ($assets as $asset): ?>
                    <option value="<?= $asset['asset_id'] ?>"><?= htmlspecialchars($asset['asset_name']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              
              <div class="col-md-6 mb-3 d-none" id="editToAssetField">
                <label class="form-label">To Asset<span class="required">*</span></label>
                <select class="form-select" name="to_asset_id" id="editToAssetSelect">
                  <option value="">Select asset</option>
                  <?php foreach ($assets as $asset): ?>
                    <option value="<?= $asset['asset_id'] ?>"><?= htmlspecialchars($asset['asset_name']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              
              <div class="col-12 mb-3">
                <label class="form-label">Transaction Date</label>
                <input type="date" class="form-control" name="transaction_date" id="editDate">
              </div>
            </div>
            
            <button type="submit" class="btn-save">Update Transaction</button>
            <button type="button" class="btn-delete2" onclick="confirmDelete()">Delete Transaction</button>
          </form>
          
          <form method="POST" action="../handlers/transaction_handler.php" id="deleteTransactionForm" class="d-none">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="transaction_id" id="deleteTransactionId">
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/script.js"></script>
  <script>
    function switchType(mode, type) {
      document.getElementById(mode + 'Type').value = type;
      
      const categoryField = document.getElementById(mode + 'CategoryField');
      const assetField = document.getElementById(mode + 'AssetField');
      const fromAssetField = document.getElementById(mode + 'FromAssetField');
      const toAssetField = document.getElementById(mode + 'ToAssetField');
      
      if (type === 'transfer') {
        categoryField.classList.add('d-none');
        assetField.classList.add('d-none');
        fromAssetField.classList.remove('d-none');
        toAssetField.classList.remove('d-none');
      } else {
        categoryField.classList.remove('d-none');
        assetField.classList.remove('d-none');
        fromAssetField.classList.add('d-none');
        toAssetField.classList.add('d-none');
        
        // Filter categories by type
        const select = document.getElementById(mode + 'CategorySelect');
        Array.from(select.options).forEach(opt => {
          if (opt.value && opt.dataset.type !== type) {
            opt.style.display = 'none';
          } else {
            opt.style.display = '';
          }
        });
      }
    }
    
    function editTransaction(trans) {
      document.getElementById('editTransactionId').value = trans.transaction_id;
      document.getElementById('deleteTransactionId').value = trans.transaction_id;
      document.getElementById('editAmount').value = trans.amount;
      document.getElementById('editDescription').value = trans.description || '';
      document.getElementById('editDate').value = trans.transaction_date;
      
      document.getElementById('edit' + trans.transaction_type.charAt(0).toUpperCase() + trans.transaction_type.slice(1)).checked = true;
      switchType('edit', trans.transaction_type);
      
      if (trans.transaction_type !== 'transfer') {
        document.getElementById('editCategorySelect').value = trans.category_id || '';
        document.getElementById('editAssetSelect').value = trans.asset_id || '';
      } else {
        document.getElementById('editFromAssetSelect').value = trans.from_asset_id || '';
        document.getElementById('editToAssetSelect').value = trans.to_asset_id || '';
      }
      
      new bootstrap.Modal(document.getElementById('editTransactionModal')).show();
    }
    
    function confirmDelete() {
      if (confirm('Apakah Anda yakin ingin menghapus transaksi ini?')) {
        document.getElementById('deleteTransactionForm').submit();
      }
    }
    
    // Loading state
    document.querySelectorAll('form').forEach(form => {
      form.addEventListener('submit', function() {
        const btn = this.querySelector('.btn-save');
        if (btn) {
          btn.querySelector('.btn-text').classList.add('d-none');
          btn.querySelector('.btn-loading').classList.remove('d-none');
          btn.disabled = true;
        }
      });
    });
  </script>
</body>
</html>
