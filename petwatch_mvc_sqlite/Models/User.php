
<?php
require_once __DIR__ . '/DB.php';

class User {
    public static function findByUsername(string $u): ?array {
        $stmt = DB::conn()->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$u]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
    public static function findById(int $id): ?array {
        $stmt = DB::conn()->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
}
