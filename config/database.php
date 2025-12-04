<?php
// ============================================
// DATABASE CONNECTION - ExTrack
// ============================================

// Load environment variables
require_once __DIR__ . '/env.php';

// Get database config from .env
$host = env('DB_HOST');
$dbname = env('DB_NAME');
$username = env('DB_USERNAME');
$password = env('DB_PASSWORD');

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
