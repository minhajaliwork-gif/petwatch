
<?php
require_once __DIR__ . '/DB.php';

class Pet {
    public static function search(string $q='', string $type='', string $status='', int $limit=10, int $offset=0): array {
        $w = []; $a = [];
        if ($q !== '')     { $w[]="(p.name LIKE ? OR p.description LIKE ?)"; $a[]="%$q%"; $a[]="%$q%"; }
        if ($type !== '')  { $w[]="p.type = ?"; $a[]=$type; }
        if ($status !== ''){ $w[]="p.status = ?"; $a[]=$status; }
        $where = $w ? ('WHERE ' . implode(' AND ', $w)) : '';
        $db = DB::conn();

        $count = $db->prepare("SELECT COUNT(*) FROM pets p $where");
        $count->execute($a);
        $total = (int)$count->fetchColumn();

        $sql = "SELECT p.*, u.username AS owner_name
                FROM pets p JOIN users u ON u.id=p.owner_id
                $where ORDER BY p.created_at DESC LIMIT ? OFFSET ?";
        $stmt = $db->prepare($sql);
        $args = array_merge($a, [$limit, $offset]);
        $stmt->execute($args);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return [$rows, $total];
    }

    public static function listForOwner(int $ownerId): array {
        $stmt = DB::conn()->prepare("SELECT * FROM pets WHERE owner_id=? ORDER BY created_at DESC");
        $stmt->execute([$ownerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function get(int $id): ?array {
        $stmt = DB::conn()->prepare("SELECT * FROM pets WHERE id=?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function create(int $ownerId, string $name, string $type, string $status, string $desc=''): bool {
        $stmt = DB::conn()->prepare("INSERT INTO pets (owner_id,name,type,status,description) VALUES (?,?,?,?,?)");
        return $stmt->execute([$ownerId,$name,$type,$status,$desc]);
    }

    public static function update(int $id, string $name, string $type, string $status, string $desc=''): bool {
        $stmt = DB::conn()->prepare("UPDATE pets SET name=?, type=?, status=?, description=? WHERE id=?");
        return $stmt->execute([$name,$type,$status,$desc,$id]);
    }

    public static function delete(int $id): bool {
        $stmt = DB::conn()->prepare("DELETE FROM pets WHERE id=?");
        return $stmt->execute([$id]);
    }
}
