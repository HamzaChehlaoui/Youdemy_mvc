<?php
namespace App\Core;

class View {
    private static $viewPath = __DIR__ . '/../Views/';
    private static $cache = [];

    public static function renderWithLayout($view, $data = [], $layout = 'main') {
        $content = self::capture($view, $data);
        $data['content'] = $content;
        return self::render("layouts/{$layout}", $data);
    }

    public static function render($view, $data = []) {
        $viewFile = self::resolvePath($view);
        if (!file_exists($viewFile)) {
            throw new \Exception("View {$view} not found");
        }

        extract($data);
        ob_start();
        include $viewFile;
        return ob_get_clean();
    }

    private static function resolvePath($view) {
        $view = str_replace('.', '/', $view);
        return self::$viewPath . $view . '.php';
    }

    private static function capture($view, $data = []) {
        ob_start();
        self::render($view, $data);
        return ob_get_clean();
    }
}
