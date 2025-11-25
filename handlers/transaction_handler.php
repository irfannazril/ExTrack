<?php
// ============================================
// TRANSACTION HANDLER - Add, Edit, Delete
// ============================================

require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../pages/transactions.php');
}

$action = $_POST['action'] ?? '';

try {
    switch ($action) {
        case 'add':
            handle_add_transaction();
            break;
        case 'edit':
            handle_edit_transaction();
            break;
        case 'delete':
            handle_delete_transaction();
            break;
        default:
            set_flash('error', 'Aksi tidak valid!');
            redirect('../pages/transactions.php');
    }
} catch (Exception $e) {
    set_flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
    redirect('../pages/transactions.php');
}

// ============================================
// ADD TRANSACTION
// ============================================
function handle_add_transaction() {
    global $conn, $user_id;
    
    $type = $_POST['type'] ?? '';
    $amount = floatval($_POST['amount'] ?? 0);
    $description = clean_input($_POST['description'] ?? '');
    $category_id = !empty($_POST['category_id']) ? intval($_POST['category_id']) : null;
    $asset_id = !empty($_POST['asset_id']) ? intval($_POST['asset_id']) : null;
    $transaction_date = $_POST['transaction_date'] ?? date('Y-m-d');
    $from_asset_id = !empty($_POST['from_asset_id']) ? intval($_POST['from_asset_id']) : null;
    $to_asset_id = !empty($_POST['to_asset_id']) ? intval($_POST['to_asset_id']) : null;
    
    // Validasi
    if (!in_array($type, ['income', 'expense', 'transfer'])) {
        set_flash('error', 'Tipe transaksi tidak valid!');
        redirect('../pages/transactions.php');
    }
    
    if ($amount <= 0) {
        set_flash('error', 'Jumlah harus lebih dari 0!');
        redirect('../pages/transactions.php');
    }
    
    // Validasi berdasarkan tipe
    if ($type === 'transfer') {
        if (!$from_asset_id || !$to_asset_id) {
            set_flash('error', 'Asset asal dan tujuan wajib dipilih untuk transfer!');
            redirect('../pages/transactions.php');
        }
        
        if ($from_asset_id === $to_asset_id) {
            set_flash('error', 'Asset asal dan tujuan tidak boleh sama!');
            redirect('../pages/transactions.php');
        }
        
        // Cek balance from_asset cukup
        $stmt = $conn->prepare("SELECT balance FROM assets WHERE asset_id = ? AND user_id = ?");
        $stmt->execute([$from_asset_id, $user_id]);
        $from_asset = $stmt->fetch();
        
        if (!$from_asset || $from_asset['balance'] < $amount) {
            set_flash('error', 'Saldo asset asal tidak mencukupi!');
            redirect('../pages/transactions.php');
        }
        
        $asset_id = $from_asset_id; // Untuk record
    } else {
        if (!$asset_id) {
            set_flash('error', 'Asset wajib dipilih!');
            redirect('../pages/transactions.php');
        }
        
        if ($type === 'expense') {
            // Cek balance cukup untuk expense
            $stmt = $conn->prepare("SELECT balance FROM assets WHERE asset_id = ? AND user_id = ?");
            $stmt->execute([$asset_id, $user_id]);
            $asset = $stmt->fetch();
            
            if (!$asset || $asset['balance'] < $amount) {
                set_flash('error', 'Saldo asset tidak mencukupi!');
                redirect('../pages/transactions.php');
            }
        }
    }
    
    // Begin transaction
    $conn->beginTransaction();
    
    // Insert transaction
    $stmt = $conn->prepare("
        INSERT INTO transactions (user_id, transaction_type, amount, description, category_id, asset_id, transaction_date, from_asset_id, to_asset_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$user_id, $type, $amount, $description, $category_id, $asset_id, $transaction_date, $from_asset_id, $to_asset_id]);
    
    // Update asset balance
    if ($type === 'income') {
        $stmt = $conn->prepare("UPDATE assets SET balance = balance + ? WHERE asset_id = ? AND user_id = ?");
        $stmt->execute([$amount, $asset_id, $user_id]);
    } elseif ($type === 'expense') {
        $stmt = $conn->prepare("UPDATE assets SET balance = balance - ? WHERE asset_id = ? AND user_id = ?");
        $stmt->execute([$amount, $asset_id, $user_id]);
    } elseif ($type === 'transfer') {
        // Kurangi from_asset
        $stmt = $conn->prepare("UPDATE assets SET balance = balance - ? WHERE asset_id = ? AND user_id = ?");
        $stmt->execute([$amount, $from_asset_id, $user_id]);
        
        // Tambah to_asset
        $stmt = $conn->prepare("UPDATE assets SET balance = balance + ? WHERE asset_id = ? AND user_id = ?");
        $stmt->execute([$amount, $to_asset_id, $user_id]);
    }
    
    $conn->commit();
    
    set_flash('success', 'Transaksi berhasil ditambahkan!');
    redirect('../pages/transactions.php');
}

// ============================================
// EDIT TRANSACTION
// ============================================
function handle_edit_transaction() {
    global $conn, $user_id;
    
    $transaction_id = intval($_POST['transaction_id'] ?? 0);
    $type = $_POST['type'] ?? '';
    $amount = floatval($_POST['amount'] ?? 0);
    $description = clean_input($_POST['description'] ?? '');
    $category_id = !empty($_POST['category_id']) ? intval($_POST['category_id']) : null;
    $asset_id = !empty($_POST['asset_id']) ? intval($_POST['asset_id']) : null;
    $transaction_date = $_POST['transaction_date'] ?? date('Y-m-d');
    $from_asset_id = !empty($_POST['from_asset_id']) ? intval($_POST['from_asset_id']) : null;
    $to_asset_id = !empty($_POST['to_asset_id']) ? intval($_POST['to_asset_id']) : null;
    
    // Get old transaction data
    $stmt = $conn->prepare("SELECT * FROM transactions WHERE transaction_id = ? AND user_id = ?");
    $stmt->execute([$transaction_id, $user_id]);
    $old_trans = $stmt->fetch();
    
    if (!$old_trans) {
        set_flash('error', 'Transaksi tidak ditemukan!');
        redirect('../pages/transactions.php');
    }
    
    // Validasi sama seperti add
    if (!in_array($type, ['income', 'expense', 'transfer'])) {
        set_flash('error', 'Tipe transaksi tidak valid!');
        redirect('../pages/transactions.php');
    }
    
    if ($amount <= 0) {
        set_flash('error', 'Jumlah harus lebih dari 0!');
        redirect('../pages/transactions.php');
    }
    
    // Begin transaction
    $conn->beginTransaction();
    
    // Revert old transaction effect on balance
    if ($old_trans['transaction_type'] === 'income') {
        $stmt = $conn->prepare("UPDATE assets SET balance = balance - ? WHERE asset_id = ?");
        $stmt->execute([$old_trans['amount'], $old_trans['asset_id']]);
    } elseif ($old_trans['transaction_type'] === 'expense') {
        $stmt = $conn->prepare("UPDATE assets SET balance = balance + ? WHERE asset_id = ?");
        $stmt->execute([$old_trans['amount'], $old_trans['asset_id']]);
    } elseif ($old_trans['transaction_type'] === 'transfer') {
        $stmt = $conn->prepare("UPDATE assets SET balance = balance + ? WHERE asset_id = ?");
        $stmt->execute([$old_trans['amount'], $old_trans['from_asset_id']]);
        $stmt = $conn->prepare("UPDATE assets SET balance = balance - ? WHERE asset_id = ?");
        $stmt->execute([$old_trans['amount'], $old_trans['to_asset_id']]);
    }
    
    // Update transaction
    $stmt = $conn->prepare("
        UPDATE transactions 
        SET transaction_type = ?, amount = ?, description = ?, category_id = ?, asset_id = ?, transaction_date = ?, from_asset_id = ?, to_asset_id = ?
        WHERE transaction_id = ? AND user_id = ?
    ");
    $stmt->execute([$type, $amount, $description, $category_id, $asset_id, $transaction_date, $from_asset_id, $to_asset_id, $transaction_id, $user_id]);
    
    // Apply new transaction effect on balance
    if ($type === 'income') {
        $stmt = $conn->prepare("UPDATE assets SET balance = balance + ? WHERE asset_id = ? AND user_id = ?");
        $stmt->execute([$amount, $asset_id, $user_id]);
    } elseif ($type === 'expense') {
        // Cek balance cukup
        $stmt = $conn->prepare("SELECT balance FROM assets WHERE asset_id = ? AND user_id = ?");
        $stmt->execute([$asset_id, $user_id]);
        $asset = $stmt->fetch();
        
        if (!$asset || $asset['balance'] < $amount) {
            $conn->rollBack();
            set_flash('error', 'Saldo asset tidak mencukupi!');
            redirect('../pages/transactions.php');
        }
        
        $stmt = $conn->prepare("UPDATE assets SET balance = balance - ? WHERE asset_id = ? AND user_id = ?");
        $stmt->execute([$amount, $asset_id, $user_id]);
    } elseif ($type === 'transfer') {
        // Cek balance from_asset cukup
        $stmt = $conn->prepare("SELECT balance FROM assets WHERE asset_id = ? AND user_id = ?");
        $stmt->execute([$from_asset_id, $user_id]);
        $from_asset = $stmt->fetch();
        
        if (!$from_asset || $from_asset['balance'] < $amount) {
            $conn->rollBack();
            set_flash('error', 'Saldo asset asal tidak mencukupi!');
            redirect('../pages/transactions.php');
        }
        
        $stmt = $conn->prepare("UPDATE assets SET balance = balance - ? WHERE asset_id = ? AND user_id = ?");
        $stmt->execute([$amount, $from_asset_id, $user_id]);
        $stmt = $conn->prepare("UPDATE assets SET balance = balance + ? WHERE asset_id = ? AND user_id = ?");
        $stmt->execute([$amount, $to_asset_id, $user_id]);
    }
    
    $conn->commit();
    
    set_flash('success', 'Transaksi berhasil diupdate!');
    redirect('../pages/transactions.php');
}

// ============================================
// DELETE TRANSACTION
// ============================================
function handle_delete_transaction() {
    global $conn, $user_id;
    
    $transaction_id = intval($_POST['transaction_id'] ?? 0);
    
    // Get transaction data
    $stmt = $conn->prepare("SELECT * FROM transactions WHERE transaction_id = ? AND user_id = ?");
    $stmt->execute([$transaction_id, $user_id]);
    $trans = $stmt->fetch();
    
    if (!$trans) {
        set_flash('error', 'Transaksi tidak ditemukan!');
        redirect('../pages/transactions.php');
    }
    
    // Begin transaction
    $conn->beginTransaction();
    
    // Revert transaction effect on balance
    if ($trans['transaction_type'] === 'income') {
        $stmt = $conn->prepare("UPDATE assets SET balance = balance - ? WHERE asset_id = ?");
        $stmt->execute([$trans['amount'], $trans['asset_id']]);
    } elseif ($trans['transaction_type'] === 'expense') {
        $stmt = $conn->prepare("UPDATE assets SET balance = balance + ? WHERE asset_id = ?");
        $stmt->execute([$trans['amount'], $trans['asset_id']]);
    } elseif ($trans['transaction_type'] === 'transfer') {
        $stmt = $conn->prepare("UPDATE assets SET balance = balance + ? WHERE asset_id = ?");
        $stmt->execute([$trans['amount'], $trans['from_asset_id']]);
        $stmt = $conn->prepare("UPDATE assets SET balance = balance - ? WHERE asset_id = ?");
        $stmt->execute([$trans['amount'], $trans['to_asset_id']]);
    }
    
    // Delete transaction
    $stmt = $conn->prepare("DELETE FROM transactions WHERE transaction_id = ? AND user_id = ?");
    $stmt->execute([$transaction_id, $user_id]);
    
    $conn->commit();
    
    set_flash('success', 'Transaksi berhasil dihapus!');
    redirect('../pages/transactions.php');
}
