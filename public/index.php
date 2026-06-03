<?php

declare(strict_types=1);

use App\Controllers\StudentController;
use App\Core\Router;

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/../app/';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

$router = new Router();
$router->get('students', [StudentController::class, 'index']);
$router->get('students/create', [StudentController::class, 'create']);
$router->post('students/store', [StudentController::class, 'store']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_GET['route'] ?? 'students');
