<?php

require __DIR__ . '/Authenticate.php';
require __DIR__ . '/db.php';

session_start();
$message = '';

// Logout
if (isset($_POST['logout'])) {
    $_SESSION = [];
    session_destroy();
    header('Location: login.php');
    exit;
}

// Login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!is_string($username) || !is_string($password)) {
        $message = 'Gebruiker nog niet bekend, registratie is hieronder mogelijk.';
    } else {
        $user = findUser($mysqli, trim($username));

        if (!$user) {
            $message = 'Gebruiker nog niet bekend, registratie is hieronder mogelijk.';
        } elseif (!password_verify($password, $user['password_hash'])) {
            $message = 'Wachtwoord onjuist.';
        } else {
            session_regenerate_id(true);
            $_SESSION['username'] = $user['username'];
        }
    }
}
?>

<!-- Weergave -->
<!doctype html>
<html lang="nl">
<meta charset="utf-8">
<title>Inlogpagina</title>
<body>
<h1>Inlogpagina</h1>
<?php if (isset($_SESSION['username'])): ?>
    <p>Welkom, <?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?>.</p>
    <form method="post">
        <button name="logout">Uitloggen</button>
    </form>
<?php else: ?>
    <?php if ($message !== ''): ?>
        <p style="color: red"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
    <form method="post">
        <label>Gebruikersnaam <input name="username" required></label><br>
        <label>Wachtwoord <input type="password" name="password" required></label><br>
        <button>Inloggen</button>
    </form>
    <p><a href="Register.php">Registreren</a></p>
<?php endif; ?>
</body>
</html>
