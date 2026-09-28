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

// Sessie sluiten na 1 week inactiviteit
if (
    isset($_SESSION['last_activity']) &&
    time() - $_SESSION['last_activity'] > $oneWeek
) {
    $_SESSION = [];
}

$_SESSION['last_activity'] = time();

$producten = [
    "Brood" => 2.50,
    "Broccoli" => 1.75,
    "Melk" => 1.50,
    "Appels" => 2.25,
    "Pasta" => 1.80
];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Product toevoegen
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $product = $_POST['product'] ?? '';

    if (isset($producten[$product])) {

        if (isset($_SESSION['cart'][$product])) {

            $_SESSION['cart'][$product]['amount']++;

        } else {

            $_SESSION['cart'][$product] = [
                'amount' => 1,
                'price' => $producten[$product]
            ];
        }
    }
}

?>

<h2>Producten</h2>

<?php foreach ($producten as $product => $price): ?>

    <form method="post">

        <?php echo $product; ?>

        -
        €<?php echo number_format($price, 2, ',', '.'); ?>

        <button
            type="submit"
            name="product"
            value="<?php echo $product; ?>">
            Voeg toe
        </button>

    </form>

<?php endforeach; ?>

<h2>Winkelwagen</h2>

<?php foreach ($_SESSION['cart'] as $product => $item): ?>

    <?php echo $product . ": " . $item['amount']; ?>

    <br>

<?php endforeach; ?>

<br>

<a href="cart.php">Bekijk winkelwagen</a>