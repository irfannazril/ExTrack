<?php
// ============================================
// AUTH CHECK - Proteksi halaman yang butuh login
// ============================================

require_once __DIR__ . '/session.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/../config/database.php';

// Cek remember me cookie jika belum login
if (!is_logged_in()) {
    $remember = get_remember_me_cookie();
    
    if ($remember) {
        // Validasi remember me token
        $stmt = $conn->prepare("SELECT user_id, username, email, profile_photo FROM users WHERE user_id = ? AND remember_token = ? AND token_expires_at > NOW()");
        $stmt->execute([$remember['user_id'], $remember['token']]);
        $user = $stmt->fetch();
        
        if ($user) {
            // Auto login
            set_user_session($user);
        } else {
            // Token invalid, hapus cookie
            delete_remember_me_cookie();
        }
    }
}

// Jika masih belum login, redirect ke login page
if (!is_logged_in()) {
    redirect('../auth/login.php');
}

// Ambil data user untuk dipakai di halaman
$user = get_user_data();
$user_id = $user['user_id'];
$username = $user['username'];
$email = $user['email'];
$profile_photo = get_profile_photo_url($user['profile_photo'], $username);
