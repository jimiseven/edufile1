<?php

namespace App\Core;

use mysqli;
use RuntimeException;

class Database
{
    private static ?mysqli $connection = null;

    public static function connection(): mysqli
    {
        if (self::$connection instanceof mysqli) {
            return self::$connection;
        }

        $config = require __DIR__ . '/../../config/database.php';

        self::$connection = new mysqli(
            $config['host'],
            $config['user'],
            $config['password'],
            $config['database']
        );

        if (self::$connection->connect_error) {
            throw new RuntimeException('Error de conexion: ' . self::$connection->connect_error);
        }

        self::$connection->set_charset($config['charset']);

        return self::$connection;
    }
}
