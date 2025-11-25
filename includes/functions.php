<?php
// ============================================
// HELPER FUNCTIONS - ExTrack
// ============================================

// Validasi email
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Sanitize input (bersihkan dari HTML/script)
function clean_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Format currency ke format Indonesia (Rp 1.000.000)
function format_currency($amount) {
    return number_format($amount, 0, ',', '.');
}

// Format date ke format Indonesia (15 Nov 2025)
function format_date_indo($date) {
    $bulan = [
        1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
        'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
    ];
    
    $timestamp = strtotime($date);
    $day = date('d', $timestamp);
    $month = $bulan[(int)date('m', $timestamp)];
    $year = date('Y', $timestamp);
    
    return "$day $month $year";
}

// Generate random token untuk verification/remember me
function generate_token($length = 32) {
    return bin2hex(random_bytes($length));
}

// Hash password
function hash_password($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

// Verify password
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

// Upload photo profile
function upload_profile_photo($file, $user_id) {
    $upload_dir = __DIR__ . '/../uploads/profiles/';
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 2 * 1024 * 1024; // 2MB
    
    // Validasi file
    if (!in_array($file['type'], $allowed_types)) {
        return ['success' => false, 'message' => 'Format file tidak valid. Gunakan JPG, PNG, atau GIF.'];
    }
    
    if ($file['size'] > $max_size) {
        return ['success' => false, 'message' => 'Ukuran file terlalu besar. Maksimal 2MB.'];
    }
    
    // Generate nama file unik
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = 'profile_' . $user_id . '_' . time() . '.' . $extension;
    $filepath = $upload_dir . $filename;
    
    // Upload file
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        // Resize image ke 300x300
        resize_image($filepath, 300, 300);
        
        return ['success' => true, 'filename' => $filename];
    }
    
    return ['success' => false, 'message' => 'Gagal upload file.'];
}

// Resize image
function resize_image($filepath, $width, $height) {
    list($orig_width, $orig_height, $type) = getimagesize($filepath);
    
    // Create image resource
    switch ($type) {
        case IMAGETYPE_JPEG:
            $source = imagecreatefromjpeg($filepath);
            break;
        case IMAGETYPE_PNG:
            $source = imagecreatefrompng($filepath);
            break;
        case IMAGETYPE_GIF:
            $source = imagecreatefromgif($filepath);
            break;
        default:
            return false;
    }
    
    // Create new image
    $thumb = imagecreatetruecolor($width, $height);
    
    // Preserve transparency for PNG and GIF
    if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);
    }
    
    // Resize
    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
    
    // Save
    switch ($type) {
        case IMAGETYPE_JPEG:
            imagejpeg($thumb, $filepath, 90);
            break;
        case IMAGETYPE_PNG:
            imagepng($thumb, $filepath, 9);
            break;
        case IMAGETYPE_GIF:
            imagegif($thumb, $filepath);
            break;
    }
    
    imagedestroy($source);
    imagedestroy($thumb);
    
    return true;
}

// Delete old profile photo
function delete_profile_photo($filename) {
    if (empty($filename)) return;
    
    $filepath = __DIR__ . '/../uploads/profiles/' . $filename;
    if (file_exists($filepath)) {
        unlink($filepath);
    }
}

// Get profile photo URL
function get_profile_photo_url($filename, $username) {
    if (!empty($filename) && file_exists(__DIR__ . '/../uploads/profiles/' . $filename)) {
        return '../uploads/profiles/' . $filename;
    }
    
    // Generate UI Avatar dari username
    $name = urlencode($username);
    return "https://ui-avatars.com/api/?name=$name&background=4e9f3d&color=fff&size=120";
}

// Set flash message (untuk alert)
function set_flash($type, $message) {
    $_SESSION['flash_type'] = $type; // success, error, warning, info
    $_SESSION['flash_message'] = $message;
}

// Get dan hapus flash message
function get_flash() {
    if (isset($_SESSION['flash_message'])) {
        $flash = [
            'type' => $_SESSION['flash_type'],
            'message' => $_SESSION['flash_message']
        ];
        unset($_SESSION['flash_type']);
        unset($_SESSION['flash_message']);
        return $flash;
    }
    return null;
}

// Redirect helper
function redirect($url) {
    header("Location: $url");
    exit();
}
