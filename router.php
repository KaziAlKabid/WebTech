<?php
// Start session for authentication
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Load configuration and helper files
require_once 'config/constants.php';
require_once 'config/db.php';

// Autoload controllers and models
spl_autoload_register(function ($className) {
    $paths = ['controllers/', 'models/'];
    foreach ($paths as $path) {
        $file = $path . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Get requested controller and action
$controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) . 'Controller' : null;
$actionName = isset($_GET['action']) ? $_GET['action'] : null;

if ($controllerName && $actionName) {
    $controllerFile = "controllers/$controllerName.php";
    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        $controller = new $controllerName();
        if (method_exists($controller, $actionName)) {
            $controller->$actionName();
        } else {
            echo "Error 404: Action '$actionName' not found in controller '$controllerName'.";
        }
    } else {
        echo "Error 404: Controller '$controllerName' not found.";
    }
} else {
    echo "Error 404: No controller or action specified.";
}
