<?php

namespace App\Core;

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        $viewPath = __DIR__ . '/../Views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            http_response_code(500);
            echo 'Vista no encontrada: ' . htmlspecialchars($view, ENT_QUOTES, 'UTF-8');
            return;
        }

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layouts/main.php';
    }
}
