<?php
// In config.php, ensure DEBUG_MODE is defined
define('DEBUG_MODE', true);  // or false for production

// In your main script
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/config/Database.php';

use App\Core\Router;

// Configure session
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_strict_mode', 1);
session_start();

try {
    $router = Router::getInstance();
    require_once __DIR__ . '/../routes/web.php';  // Add routes configuration
    echo $router->resolve();
} catch (\Throwable $e) {
    error_log($e->getMessage());
    if (DEBUG_MODE) {
        echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
    } else {
        http_response_code(500);
        require_once __DIR__ . '/../app/Views/errors/500.php';
    }
}
