<?php

require_once __DIR__ . '/../07/sessionKeeper.php';
require_once __DIR__ . '/DBconnect.php';
require_once __DIR__ . '/User.class.php';

SessionKeeper::start();

$user = new User(DBConnect::getInstance());
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'logout') {
        SessionKeeper::clear();
    } else {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!is_string($username) || !is_string($password)) {
            $message = 'Vul een geldige gebruikersnaam en wachtwoord in.';
        } else {
            $username = trim($username);

            if ($username === '' || $password === '') {
                $message = 'Vul een gebruikersnaam en wachtwoord in.';
            } elseif ($action === 'login') {
                if ($user->getUser($username, $password) !== null) {
                    session_regenerate_id(true);
                    $_SESSION['username'] = $username;
                } else {
                    $message = 'Onjuiste gebruikersnaam of wachtwoord.';
                }
            } elseif ($action === 'register') {
                if ($user->insert($username, $password)) {
                    session_regenerate_id(true);
                    $_SESSION['username'] = $username;
                    $message = 'Account aangemaakt en ingelogd.';
                } else {
                    $message = 'Aanmelden is niet gelukt.';
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Inloggen of aanmelden</title>
</head>
<body>
    <h1>Inloggen of aanmelden</h1>

<?php if ($message !== ''): ?>
    <?php if ($message === 'Onjuiste gebruikersnaam of wachtwoord.'
        || $message === 'Aanmelden is niet gelukt.'): ?>
        <p style="color: red;">
            <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php else: ?>
        <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>
<?php endif; ?>

    <?php if (isset($_SESSION['username'])): ?>
        <p>Welkom, <?= htmlspecialchars((string) $_SESSION['username'], ENT_QUOTES, 'UTF-8') ?>.</p>
        <form method="post">
            <button type="submit" name="action" value="logout">Uitloggen</button>
        </form>
    <?php else: ?>
        <form method="post">
            <h2>Inloggen</h2>
            <label>
                Gebruikersnaam
                <input type="text" name="username" required>
            </label>
            <label>
                Wachtwoord
                <input type="password" name="password" required>
            </label>
            <button type="submit" name="action" value="login">Inloggen</button>
        </form>

        <form method="post">
            <h2>Aanmelden</h2>
            <label>
                Gebruikersnaam
                <input type="text" name="username" required>
            </label>
            <label>
                Wachtwoord
                <input type="password" name="password" required>
            </label>
            <button type="submit" name="action" value="register">Aanmelden</button>
        </form>
    <?php endif; ?>
</body>
</html>
