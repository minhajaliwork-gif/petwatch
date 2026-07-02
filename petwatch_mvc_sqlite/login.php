
<?php
session_start();
require_once __DIR__ . '/Models/User.php';

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['username'] ?? '');
    $p = $_POST['password'] ?? '';
    $user = User::findByUsername($u);
    if ($user && password_verify($p, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header('Location: /index.php'); exit;
    } else {
        $err = 'Invalid username or password';
    }
}
$view_err = $err;
require __DIR__ . '/Views/login.phtml';
