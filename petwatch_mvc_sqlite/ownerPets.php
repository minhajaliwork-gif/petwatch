
<?php
session_start();
require_once __DIR__ . '/Models/Pet.php';
require_once __DIR__ . '/Models/User.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    header('Location: /login.php'); exit;
}
$ownerId = (int)$_SESSION['user_id'];
$pets = Pet::listForOwner($ownerId);
require __DIR__ . '/Views/ownerPets.phtml';
