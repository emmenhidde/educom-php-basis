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


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST['action'] ?? '';


    // Aantal aanpassen
    if ($action == "update") {

        $product = $_POST['product'];
        $amount = (int) $_POST['amount'];

        if ($amount > 0) {
            $_SESSION['cart'][$product]['amount'] = $amount;
        } else {
            unset($_SESSION['cart'][$product]);
        }
    }


    // Product verwijderen
    if ($action == "remove") {

        $product = $_POST['product'];

        unset($_SESSION['cart'][$product]);
    }


    // Winkelwagen legen
    if ($action == "empty") {

        $_SESSION = [];
        session_destroy();

        header("Location: winkelwagen.php");
        exit;
    }


    // Afrekenen
    if ($action == "checkout") {

        $_SESSION = [];
        session_destroy();

        header("Location: winkelwagen.php");
        exit;
    }
}

?>


<h2>Winkelwagen</h2>


<?php

$total = 0;

foreach ($_SESSION['cart'] as $product => $item):

    $subtotal = $item['amount'] * $item['price'];

    $total += $subtotal;

?>

    <form method="post">

        <?php echo $product; ?>

        €<?php echo number_format($item['price'], 2, ',', '.'); ?>

        <input
            type="number"
            name="amount"
            value="<?php echo $item['amount']; ?>"
            min="0"
        >

        <input
            type="hidden"
            name="product"
            value="<?php echo $product; ?>"
        >

        <button
            type="submit"
            name="action"
            value="update">
            Aanpassen
        </button>

        <button
            type="submit"
            name="action"
            value="remove">
            Verwijder
        </button>

    </form>

<?php endforeach; ?>


<h3>
    Totaal:
    €<?php echo number_format($total, 2, ',', '.'); ?>
</h3>


<form method="post">

    <button
        type="submit"
        name="action"
        value="empty">
        Leeg winkelwagen
    </button>

    <button
        type="submit"
        name="action"
        value="checkout">
        Afrekenen
    </button>

</form>


<br>

<a href="winkelwagen.php">Terug naar producten</a>