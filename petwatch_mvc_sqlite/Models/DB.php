
<?php
class DB {
    public static function conn(): PDO {
        static $pdo = null;
        if ($pdo === null) {
            $dbPath = __DIR__ . '/../database/petwatch.db';
            $dsn = 'sqlite:' . $dbPath;
            $pdo = new PDO($dsn);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec('PRAGMA foreign_keys = ON;');
        }
        return $pdo;
    }
}
