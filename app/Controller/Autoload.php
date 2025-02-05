<?php  
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/' . $class . '.php';

    if (file_exists($file)) {
        require_once $file;
    } else {
        throw new Exception("Class file for '$class' not found.");
    }
});
?>
