<?php
// ============================================
// SESSION MANAGEMENT - ExTrack
// ============================================

// Start session dengan konfigurasi aman
if (session_status() === PHP_SESSION_NONE) {
    // Set session lifetime 24 jam
    ini_set('session.gc_maxlifetime', 86400); // 24 jam dalam detik
    session_set_cookie_params(86400); // Cookie expire 24 jam
    
    session_start();
    
    // Regenerate session ID setiap 30 menit untuk keamanan
    if (!isset($_SESSION['last_regeneration'])) {
        $_SESSION['last_regeneration'] = time();
    } elseif (time() - $_SESSION['last_regeneration'] > 1800) { // 30 menit
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}

// Set user session setelah login
function set_user_session($user_data) {
    $_SESSION['user_id'] = $user_data['user_id'];
    $_SESSION['username'] = $user_data['username'];
    $_SESSION['email'] = $user_data['email'];
    $_SESSION['profile_photo'] = $user_data['profile_photo'] ?? null;
    $_SESSION['logged_in'] = true;
    $_SESSION['login_time'] = time();
}

// Cek apakah user sudah login
function is_logged_in() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

// Destroy session (logout)
function destroy_user_session() {
    // Hapus semua session variables
    $_SESSION = array();
    
    // Hapus session cookie
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    
    // Destroy session
    session_destroy();
}

// Get user data dari session
function get_user_data() {
    if (is_logged_in()) {
        return [
            'user_id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'email' => $_SESSION['email'],
            'profile_photo' => $_SESSION['profile_photo'] ?? null
        ];
    }
    return null;
}

// Update session data (misal setelah update profile)
function update_session_data($key, $value) {
    if (is_logged_in()) {
        $_SESSION[$key] = $value;
    }
}

// Remember me - Set cookie
function set_remember_me_cookie($user_id, $token) {
    // Cookie expire 30 hari
    $expire = time() + (30 * 24 * 60 * 60);
    setcookie('remember_me', $user_id . ':' . $token, $expire, '/', '', false, true);
}

// Remember me - Get cookie
function get_remember_me_cookie() {
    if (isset($_COOKIE['remember_me'])) {
        $parts = explode(':', $_COOKIE['remember_me']);
        if (count($parts) === 2) {
            return [
                'user_id' => $parts[0],
                'token' => $parts[1]
            ];
        }
    }
    return null;
}

// Remember me - Delete cookie
function delete_remember_me_cookie() {
    if (isset($_COOKIE['remember_me'])) {
        setcookie('remember_me', '', time() - 3600, '/');
    }
}
