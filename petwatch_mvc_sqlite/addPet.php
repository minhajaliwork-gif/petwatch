
<?php
session_start();
require_once __DIR__ . '/Models/Pet.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    header('Location: /login.php'); exit;
}

$err = ''; $msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $status = $_POST['status'] ?? 'Missing';
    $desc = trim($_POST['description'] ?? '');
    if ($name === '' || $type === '') {
        $err = 'Name and type are required.';
    } else {
        $ok = Pet::create((int)$_SESSION['user_id'], $name, $type, $status, $desc);
        if ($ok) { header('Location: /ownerPets.php'); exit; }
        else { $err = 'Failed to add pet.'; }
    }
}
require __DIR__ . '/Views/addPet.phtml';
