
<?php
session_start();
require_once __DIR__ . '/Models/Pet.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    header('Location: /login.php'); exit;
}
$id = (int)($_GET['id'] ?? 0);
$pet = Pet::get($id);
if (!$pet || $pet['owner_id'] != $_SESSION['user_id']) {
    http_response_code(403);
    echo 'Not allowed'; exit;
}

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $status = $_POST['status'] ?? 'Missing';
    $desc = trim($_POST['description'] ?? '');
    if ($name === '' || $type === '') {
        $err = 'Name and type are required.';
    } else {
        $ok = Pet::update($id, $name, $type, $status, $desc);
        if ($ok) { header('Location: /ownerPets.php'); exit; }
        else { $err = 'Failed to update pet.'; }
    }
}
require __DIR__ . '/Views/editPet.phtml';
