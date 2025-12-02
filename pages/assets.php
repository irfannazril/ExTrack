<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/functions.php';

$stmt = $conn->prepare("SELECT * FROM assets WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$assets = $stmt->fetchAll();

$stmt = $conn->prepare("SELECT COALESCE(SUM(balance), 0) as total FROM assets WHERE user_id = ?");
$stmt->execute([$user_id]);
$total_balance = $stmt->fetch()['total'];

$stmt = $conn->prepare("
    SELECT c.category_name, c.icon, SUM(t.amount) as total
    FROM transactions t
    JOIN categories c ON t.category_id = c.category_id
    WHERE t.user_id = ? AND t.transaction_type = 'expense'
    GROUP BY c.category_id
    ORDER BY total DESC
    LIMIT 5
");
$stmt->execute([$user_id]);
$top_expenses = $stmt->fetchAll();
$total_expense = array_sum(array_column($top_expenses, 'total'));
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Assets - ExTrack</title>
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
      <div class="col-lg-6">
        <div class="main-content">
          <div class="header">
            <button class="hamburger-btn" id="hamburgerBtn"><i class="bi bi-list"></i></button>
            <div class="menu">Assets</div>
            <button class="add-wallet-btn" data-bs-toggle="modal" data-bs-target="#addAssetModal">Add Asset</button>
          </div>
          
          <?php include __DIR__ . '/../includes/alert.php'; ?>
          
          <div class="section-title">Total Balance: <?= format_currency($total_balance) ?> IDR</div>
          <div class="asset-scroll">
            <?php if (empty($assets)): ?>
              <p class="text-muted">Belum ada asset</p>
            <?php else: ?>
              <?php foreach ($assets as $asset): ?>
                <div class="card-balance">
                  <div class="card-info">
                    <div class="card-label"><?= htmlspecialchars($asset['asset_name']) ?></div>
                    <div class="card-amount"><?= format_currency($asset['balance']) ?> IDR</div>
                  </div>
                  <div class="card-menu">
                    <button class="transaction-menu" onclick='editAsset(<?= json_encode($asset) ?>)'>
                      <i class="bi bi-three-dots-vertical"></i>
                    </button>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="side-content">
          <div class="side-content-title">Top Expenses</div>
          <?php foreach ($top_expenses as $expense): ?>
            <?php $percentage = $total_expense > 0 ? ($expense['total'] / $total_expense) * 100 : 0; ?>
            <div class="stats-item">
              <div class="d-flex align-items-center mb-3">
                <span class="stats-category"><?= $expense['icon'] ?></span>
                <span class="stats-name"><?= htmlspecialchars($expense['category_name']) ?></span>
              </div>
              <div class="progress">
                <div class="progress-bar" style="width: <?= $percentage ?>%"><?= number_format($percentage, 0) ?>%</div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Asset Modal -->
  <div class="modal fade" id="addAssetModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Asset</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="../handlers/asset_handler.php">
            <input type="hidden" name="action" value="add">
            <div class="mb-3">
              <label class="form-label">Name<span class="required">*</span></label>
              <input type="text" class="form-control" name="asset_name" placeholder="e.g., Cash, Bank, etc." required>
            </div>
            <div class="mb-3">
              <label class="form-label">Initial Balance</label>
              <input type="number" class="form-control" name="balance" value="0" min="0" step="0.01">
            </div>
            <button type="submit" class="btn-save">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Asset Modal -->
  <div class="modal fade" id="editAssetModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Asset</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="../handlers/asset_handler.php">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="asset_id" id="editAssetId">
            <div class="mb-3">
              <label class="form-label">Name<span class="required">*</span></label>
              <input type="text" class="form-control" name="asset_name" id="editAssetName" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Balance</label>
              <input type="number" class="form-control" name="balance" id="editAssetBalance" min="0" step="0.01">
              <small class="text-warning">⚠️ Mengubah balance manual akan mengubah saldo tanpa record transaksi</small>
            </div>
            <button type="submit" class="btn-save">Update Asset</button>
            <button type="button" class="btn-delete2" onclick="confirmDeleteAsset()">Delete Asset</button>
          </form>
          <form method="POST" action="../handlers/asset_handler.php" id="deleteAssetForm" class="d-none">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="asset_id" id="deleteAssetId">
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/script.js"></script>
  <script>
    function editAsset(asset) {
      document.getElementById('editAssetId').value = asset.asset_id;
      document.getElementById('deleteAssetId').value = asset.asset_id;
      document.getElementById('editAssetName').value = asset.asset_name;
      document.getElementById('editAssetBalance').value = asset.balance;
      new bootstrap.Modal(document.getElementById('editAssetModal')).show();
    }
    
    function confirmDeleteAsset() {
      if (confirm('Apakah Anda yakin ingin menghapus asset ini?')) {
        document.getElementById('deleteAssetForm').submit();
      }
    }
  </script>
</body>
</html>
