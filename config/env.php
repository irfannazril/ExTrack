<?php
// ============================================
// ENV PARSER - Simple .env file loader
// ============================================

/**
 * Load .env file and parse variables
 */
function load_env($path = null) {
    if ($path === null) {
        $path = __DIR__ . '/../.env';
    }
    
    if (!file_exists($path)) {
        return false;
    }
    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        
        // Parse KEY=VALUE
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            
            // Remove quotes if present
            $value = trim($value, '"\'');
            
            // Set as environment variable
            if (!array_key_exists($key, $_ENV)) {
                $_ENV[$key] = $value;
                putenv("$key=$value");
            }
        }
    }
    
    return true;
}

/**
 * Get environment variable with default fallback
 */
function env($key, $default = null) {
    // Check $_ENV first
    if (isset($_ENV[$key])) {
        return $_ENV[$key];
    }
    
    // Check getenv()
    $value = getenv($key);
    if ($value !== false) {
        return $value;
    }
    
    // Return default
    return $default;
}

// Auto-load .env file
load_env();
