<?php

require __DIR__ . '/Authenticate.php';
require __DIR__ . '/db.php';

$message = '';
$passwordError = '';
$usernameError = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedUsername = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!is_string($submittedUsername) || !is_string($password)) {
        $username = '';
        $message = 'Registratie mislukt. Controleer de invoer of kies een andere gebruikersnaam.';
    } else {
        $username = trim($submittedUsername);

        if (preg_match('/\A[A-Za-z]{1,50}\z/', $username) !== 1) {
            $usernameError = 'De gebruikersnaam mag alleen letters (a-z en A-Z) bevatten.';
        } elseif (!validPassword($password)) {
            $passwordError = 'Het wachtwoord moet 6 tot 15 tekens bevatten en mag alleen letters en cijfers bevatten.';
        } elseif (registerUser($mysqli, $username, $password)) {
            $message = 'Account aangemaakt. Je kunt nu inloggen.';
        } else {
            $message = 'Registratie mislukt. Controleer de invoer of kies een andere gebruikersnaam.';
        }
    }
}
?>
<!doctype html>
<html lang="nl">
<meta charset="utf-8">
<title>Registreren</title>
<body>
<h1>Registreren</h1>
<p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
<form method="post">
    <label>Gebruikersnaam <input id="username" name="username" maxlength="50" pattern="[A-Za-z]{1,50}" value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>" required></label><br>
    <p id="username-error" style="color: red" <?= $usernameError === '' ? 'hidden' : '' ?>><?= htmlspecialchars($usernameError, ENT_QUOTES, 'UTF-8') ?></p>
    <label>Wachtwoord <input id="password" type="password" name="password" minlength="6" maxlength="15" pattern="[A-Za-z0-9]{6,15}" required></label><br>
    <p id="password-error" style="color: red" <?= $passwordError === '' ? 'hidden' : '' ?>><?= htmlspecialchars($passwordError, ENT_QUOTES, 'UTF-8') ?></p>
    <button type="submit">Registreren</button>
</form>
<p><a href="login.php">Terug naar inloggen</a></p>
<script>
const username = document.querySelector('#username');
const usernameError = document.querySelector('#username-error');
const usernameMessage = 'De gebruikersnaam mag alleen letters bevatten.';
const password = document.querySelector('#password');
const passwordError = document.querySelector('#password-error');
const passwordMessage = 'Het wachtwoord moet 6 tot 15 tekens bevatten en mag alleen letters en cijfers bevatten.';

username.addEventListener('invalid', () => {
    usernameError.textContent = usernameMessage;
    usernameError.hidden = false;
});
username.addEventListener('input', () => {
    if (username.validity.valid) {
        usernameError.hidden = true;
        usernameError.textContent = '';
    }
});
password.addEventListener('invalid', () => {
    passwordError.textContent = passwordMessage;
    passwordError.hidden = false;
});
password.addEventListener('input', () => {
    if (password.validity.valid) {
        passwordError.hidden = true;
        passwordError.textContent = '';
    }
});
</script>
</body>
</html>