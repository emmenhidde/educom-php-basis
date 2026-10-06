<?php

class DBConnect
{
    private static ?PDO $connection = null;

    private function __construct()
    {
    }

    public static function getInstance(): PDO
    {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO(
                    'mysql:host=localhost;dbname=personen;charset=utf8mb4',
                    'root',
                    '',
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $exception) {
                die('Database connectiefout: ' . $exception->getMessage());
            }
        }

        return self::$connection;
    }
}
?>