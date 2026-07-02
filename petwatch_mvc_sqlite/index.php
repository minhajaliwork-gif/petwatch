
<?php
session_start();
$loggedIn = isset($_SESSION['user_id']);
$role = $_SESSION['role'] ?? null;
?>
<?php require __DIR__ . '/Views/template/header.phtml'; ?>

<h1 class="mt">Welcome to petWatch</h1>
<p>This is the Trimester 1 build (PHP + SQLite + MVC).</p>
<ul>
  <li><a href="/pets.php">Browse Pets</a></li>
  <?php if (!$loggedIn): ?>
    <li><a href="/login.php">Login</a></li>
  <?php else: ?>
    <?php if ($role === 'owner'): ?>
      <li><a href="/ownerPets.php">My Pets (Owner)</a></li>
    <?php endif; ?>
    <li><a href="/logout.php">Logout</a></li>
  <?php endif; ?>
</ul>

<?php require __DIR__ . '/Views/template/footer.phtml'; ?>
