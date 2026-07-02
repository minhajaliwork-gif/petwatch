
<?php
session_start();
require_once __DIR__ . '/Models/Pet.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    header('Location: /login.php'); exit;
}
$id = (int)($_POST['id'] ?? 0);
$pet = Pet::get($id);
if (!$pet || $pet['owner_id'] != $_SESSION['user_id']) {
    http_response_code(403);
    echo 'Not allowed'; exit;
}
$ok = Pet::delete($id);
header('Location: /ownerPets.php');
exit;
