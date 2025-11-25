<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/functions.php';

// Query total balance dari semua assets
$stmt = $conn->prepare("SELECT COALESCE(SUM(balance), 0) as total_balance FROM assets WHERE user_id = ?");
$stmt->execute([$user_id]);
$total_balance = $stmt->fetch()['total_balance'];

// Query 5 transaksi terakhir
$stmt = $conn->prepare("
    SELECT t.*, c.category_name, c.icon as category_icon, a.asset_name
    FROM transactions t
    LEFT JOIN categories c ON t.category_id = c.category_id
    LEFT JOIN assets a ON t.asset_id = a.asset_id
    WHERE t.user_id = ?
    ORDER BY t.transaction_date DESC, t.created_at DESC
    LIMIT 5
");
$stmt->execute([$user_id]);
$last_transactions = $stmt->fetchAll();

// Query assets
$stmt = $conn->prepare("SELECT * FROM assets WHERE user_id = ? ORDER BY created_at DESC LIMIT 3");
$stmt->execute([$user_id]);
$assets = $stmt->fetchAll();

// Query top 3 expense categories
$stmt = $conn->prepare("
    SELECT c.category_name, c.icon, SUM(t.amount) as total
    FROM transactions t
    JOIN categories c ON t.category_id = c.category_id
    WHERE t.user_id = ? AND t.transaction_type = 'expense'
    GROUP BY c.category_id
    ORDER BY total DESC
    LIMIT 3
");
$stmt->execute([$user_id]);
$top_expenses = $stmt->fetchAll();

// Hitung total expense untuk persentase
$total_expense = array_sum(array_column($top_expenses, 'total'));
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - ExTrack</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
  <!-- Sidebar Overlay -->
  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <div class="dashboard-container">
    <div class="row g-0">
      <!-- Sidebar -->
      <div class="col-lg-3">
        <?php include __DIR__ . '/../includes/sidebar.php'; ?>
      </div>

      <!-- Main Content -->
      <div class="col-lg-9">
        <div class="main-content">
          <div class="header">
            <button class="hamburger-btn" id="hamburgerBtn">
              <i class="bi bi-list"></i>
            </button>
            <div class="menu">Dashboard</div>
            <a href="transactions.php" class="add-wallet-btn" style="text-decoration: none;">Add Transaction</a>
          </div>

          <!-- Alert -->
          <?php include __DIR__ . '/../includes/alert.php'; ?>

          <!-- Total Money (Saldo)-->
          <div class="row mb-4">
            <div class="section-title">Total Money</div>
            <div class="col-lg-12">
              <div class="total-money-card">
                <div class="total-money-amount"><?= format_currency($total_balance) ?></div>
                <div class="total-money-currency">IDR</div>
              </div>
            </div>
          </div>

          <!-- Last Transactions -->
          <div class="row">
            <div class="col-lg-4">
              <div class="section-title">Last Transactions</div>

              <?php if (empty($last_transactions)): ?>
                <p class="text-muted">Belum ada transaksi</p>
              <?php else: ?>
                <?php foreach ($last_transactions as $trans): ?>
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
                      <div>
                        <div class="transaction-amount <?= $trans['transaction_type'] ?>">
                          <?php if ($trans['transaction_type'] === 'income'): ?>
                            +<?= format_currency($trans['amount']) ?> IDR
                          <?php elseif ($trans['transaction_type'] === 'expense'): ?>
                            -<?= format_currency($trans['amount']) ?> IDR
                          <?php else: ?>
                            <?= format_currency($trans['amount']) ?> IDR
                          <?php endif; ?>
                        </div>
                        <div class="transaction-type"><?= ucfirst($trans['transaction_type']) ?></div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>

            <!-- Assets -->
            <div class="col-lg-4">
              <div class="section-title">Assets</div>
              <?php if (empty($assets)): ?>
                <p class="text-muted">Belum ada asset</p>
              <?php else: ?>
                <?php foreach ($assets as $asset): ?>
                  <div class="card-balance">
                    <div class="card-info">
                      <div class="card-label"><?= htmlspecialchars($asset['asset_name']) ?></div>
                      <div class="card-amount"><?= format_currency($asset['balance']) ?> IDR</div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>

            <!-- Statistics -->
            <div class="col-lg-4">
              <div class="section-title">Top Expense</div>
              <?php if (empty($top_expenses)): ?>
                <p class="text-muted">Belum ada data expense</p>
              <?php else: ?>
                <?php foreach ($top_expenses as $expense): ?>
                  <?php $percentage = $total_expense > 0 ? ($expense['total'] / $total_expense) * 100 : 0; ?>
                  <div class="stats-item">
                    <div class="d-flex align-items-center mb-3">
                      <span class="stats-category"><?= $expense['icon'] ?></span>
                      <span class="stats-name"><?= htmlspecialchars($expense['category_name']) ?></span>
                    </div>
                    <div class="progress" role="progressbar">
                      <div class="progress-bar" style="width: <?= $percentage ?>%"><?= number_format($percentage, 0) ?>%</div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/script.js"></script>
</body>

</html>