
<?php
// Run this ONCE from CLI to create DB, tables, and seed users & sample pets.
// Windows lab spec example: C:\xampp\php\php.exe seed.php
require_once __DIR__ . '/Models/DB.php';

try {
    $db = DB::conn();
    $schema = file_get_contents(__DIR__ . '/database/schema.sql');
    $db->exec($schema);

    // Add users (ignore if already there)
    $stmt = $db->prepare("INSERT OR IGNORE INTO users (username, password_hash, role) VALUES (?, ?, ?)");
    $stmt->execute(['Lee', password_hash('Strong!Passw0rd??', PASSWORD_DEFAULT), 'owner']);
    $stmt->execute(['Zara', password_hash('Strong!Passw0rd??', PASSWORD_DEFAULT), 'user']);

    // Fetch Lee id
    $leeId = (int)$db->query("SELECT id FROM users WHERE username='Lee'")->fetchColumn();
    $zaraId = (int)$db->query("SELECT id FROM users WHERE username='Zara'")->fetchColumn();

    // Seed some pets
    $stmtP = $db->prepare("INSERT OR IGNORE INTO pets (id, owner_id, name, type, description, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmtP->execute([1, $leeId, 'Buddy', 'Dog', 'Brown labrador, blue collar', 'Missing']);
    $stmtP->execute([2, $leeId, 'Mittens', 'Cat', 'Grey tabby with white patch', 'Found']);
    $stmtP->execute([3, $zaraId, 'Rex', 'Dog', 'German shepherd, large', 'Missing']);

    echo "Seed complete.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
