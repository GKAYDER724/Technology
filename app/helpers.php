<?php

// Autoloader for App namespace
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// Global Blade engine instance
function bladeEngine(): \App\BladeEngine
{
    static $engine = null;
    if ($engine === null) {
        $viewsPath = dirname(__DIR__) . '/resources/views';
        $cachePath = dirname(__DIR__) . '/storage/cache';
        $engine = new \App\BladeEngine($viewsPath, $cachePath);
    }
    return $engine;
}

// Laravel view() helper
function view(string $view, array $data = []): string
{
    return bladeEngine()->render($view, $data);
}

// Laravel asset() helper
function asset(string $path): string
{
    return '/' . ltrim($path, '/');
}

// Format VND currency helper
function format_price(int|float $amount): string
{
    return number_format($amount, 0, ',', '.') . '₫';
}
