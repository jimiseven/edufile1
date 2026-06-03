<?php

namespace App\Models;

use App\Core\Database;

class Level
{
    public function all(): array
    {
        $result = Database::connection()->query('SELECT id, name FROM levels ORDER BY id ASC');

        if (!$result) {
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
