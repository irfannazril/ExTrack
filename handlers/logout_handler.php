<?php
// ============================================
// LOGOUT HANDLER
// ============================================

require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/database.php';

// Hapus remember me token dari database
if (is_logged_in()) {
    $user_id = $_SESSION['user_id'];
    
    try {
        $stmt = $conn->prepare("UPDATE users SET remember_token = NULL, token_expires_at = NULL WHERE user_id = ?");
        $stmt->execute([$user_id]);
    } catch (PDOException $e) {
        // Ignore error
    }
}

// Hapus remember me cookie
delete_remember_me_cookie();

// Destroy session
destroy_user_session();

// Redirect ke landing page
redirect('../index.php');
