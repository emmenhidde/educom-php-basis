<?php

session_start();

// Cookie accepteren
if (isset($_POST['acceptCookies'])) {
    setcookie("cookieConsent", "yes", time() + (86400 * 30));
    $_COOKIE['cookieConsent'] = "yes";
}

// Inloggen
if (isset($_POST['login'])) {

    $name = trim($_POST['name']);

    if ($name != "") {

        $_SESSION['name'] = $name;

        // Naam onthouden
        setcookie("name", $name, time() + (86400 * 30));
        $_COOKIE['name'] = $name;
    }
}

// Naam uit cookie terughalen
if (!isset($_SESSION['name']) && isset($_COOKIE['name'])) {
    $_SESSION['name'] = $_COOKIE['name'];
}

// Uitloggen
if (isset($_POST['logout'])) {

    session_unset();
    session_destroy();

    setcookie("name", "", time() - 3600);

    header("Location: login_cookie.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>

<?php if (!isset($_COOKIE['cookieConsent'])): ?>

    <div>
        <p>
            Deze website gebruikt cookies om je naam te onthouden.
        </p>

        <form method="post">
            <button type="submit" name="acceptCookies">
                Cookies accepteren
            </button>
        </form>
    </div>

<?php elseif (!isset($_SESSION['name'])): ?>

    <h2>Inloggen</h2>

    <form method="post">

        <label>Naam:</label>

        <input type="text" name="name">

        <button type="submit" name="login">
            Inloggen
        </button>

    </form>

<?php else: ?>
    <h2>
        Welkom <?php echo htmlspecialchars($_SESSION['name']); ?>
    </h2>

    <p>Je bent ingelogd.</p>

    <form method="post">

        <button type="submit" name="logout">
            Uitloggen
        </button>

    </form>

<?php endif; ?>

</body>
</html>