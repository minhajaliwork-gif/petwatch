
<?php
session_start();
require_once __DIR__ . '/Models/Pet.php';

$q = trim($_GET['q'] ?? '');
$type = $_GET['type'] ?? '';
$status = $_GET['status'] ?? '';
$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 8;
$offset = ($page - 1) * $limit;

list($pets, $total) = Pet::search($q, $type, $status, $limit, $offset);
$pages = max(1, (int)ceil($total / $limit));

require __DIR__ . '/Views/pets.phtml';
