<?php
// ============================================
// GET CHART DATA - Return JSON untuk Highcharts
// ============================================

require_once __DIR__ . '/../includes/auth_check.php';

header('Content-Type: application/json');

$type = $_GET['type'] ?? 'expense'; // expense atau income

try {
    // Query data per category
    $stmt = $conn->prepare("
        SELECT c.category_name, c.icon, SUM(t.amount) as total
        FROM transactions t
        JOIN categories c ON t.category_id = c.category_id
        WHERE t.user_id = ? AND t.transaction_type = ?
        GROUP BY c.category_id
        ORDER BY total DESC
    ");
    $stmt->execute([$user_id, $type]);
    $categories = $stmt->fetchAll();
    
    // Format data untuk Highcharts
    $data = [];
    foreach ($categories as $cat) {
        $data[] = [
            'name' => $cat['icon'] . ' ' . $cat['category_name'],
            'y' => floatval($cat['total'])
        ];
    }
    
    echo json_encode([
        'success' => true,
        'data' => $data
    ]);
    
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
