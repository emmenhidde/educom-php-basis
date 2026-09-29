<?php

$oneWeek = 60 * 60 * 24 * 7;

ini_set('session.gc_maxlifetime', $oneWeek);

session_set_cookie_params([
    'lifetime' => $oneWeek,
    'path' => '/',
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start();

if (
    isset($_SESSION['last_activity']) &&
    time() - $_SESSION['last_activity'] > $oneWeek
) {
    $_SESSION = [];
}

$_SESSION['last_activity'] = time();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$producten = [
    "Brood" => 2.50,
    "Broccoli" => 1.75,
    "Melk" => 1.50,
    "Appels" => 2.25,
    "Pasta" => 1.80
];

// Product toevoegen
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    ($_POST['action'] ?? '') === 'add'
) {
    $product = $_POST['product'] ?? '';

    if (is_string($product) && isset($producten[$product])) {
        $toegevoegdAantal = $_SESSION['cart'][$product]['amount'] ?? 0;
        $toegevoegdAantal++;

        $_SESSION['cart'][$product] = [
            'amount' => $toegevoegdAantal,
            'price' => $producten[$product]
        ];
    }

    header('Location: winkelwagen.php', true, 303);
    exit;
}

?>

<h2>Producten</h2>

<?php foreach ($producten as $product => $price): ?>

    <?php
    $toegevoegdAantal = $_SESSION['cart'][$product]['amount'] ?? 0;
    ?>

    <form method="post" action="winkelwagen.php">

        <?php echo htmlspecialchars($product, ENT_QUOTES, 'UTF-8'); ?>

        - €<?php echo number_format($price, 2, ',', '.'); ?>

        <input
            type="hidden"
            name="product"
            value="<?php echo htmlspecialchars($product, ENT_QUOTES, 'UTF-8'); ?>"
        >

        <button type="submit" name="action" value="add">
            Voeg toe
        </button>

        <?php if ($toegevoegdAantal > 0): ?>
            <span><?php echo $toegevoegdAantal; ?>x</span>
        <?php endif; ?>

    </form>

<?php endforeach; ?>

<br><a href="cart.php">Bekijk winkelwagen</a>