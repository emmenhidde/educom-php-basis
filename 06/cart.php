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

// Handle cart changes.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $product = $_POST['product'] ?? '';

    if (!is_string($product)) {
        $product = '';
    }

    switch ($action) {
        case 'update':
            $amount = filter_input(
                INPUT_POST,
                'amount',
                FILTER_VALIDATE_INT,
                ['options' => ['min_range' => 0]]
            );

            if (
                isset($_SESSION['cart'][$product]) &&
                $amount !== false &&
                $amount !== null
            ) {
                if ($amount === 0) {
                    unset($_SESSION['cart'][$product]);
                } else {
                    $_SESSION['cart'][$product]['amount'] = $amount;
                }
            }
            break;

        case 'remove':
            unset($_SESSION['cart'][$product]);
            break;

        case 'empty':
            $_SESSION['cart'] = [];
            break;

        case 'checkout':
            // Demo only: no order or payment is processed.
            $_SESSION['cart'] = [];

            header('Location: winkelwagen.php', true, 303);
            exit;
    }

    // Prevent repeating the action when refreshing.
    header('Location: cart.php', true, 303);
    exit;
}

$total = 0;

?>

<h2>Winkelwagen</h2>

<?php if (empty($_SESSION['cart'])): ?>

    <p>Je winkelwagen is leeg.</p>

<?php else: ?>

    <?php foreach ($_SESSION['cart'] as $product => $item): ?>

        <?php
        $subtotal = $item['amount'] * $item['price'];
        $total += $subtotal;
        ?>

        <form method="post" action="cart.php">

            <?php echo htmlspecialchars($product, ENT_QUOTES, 'UTF-8'); ?>

            - €<?php echo number_format($item['price'], 2, ',', '.'); ?>

            <input
                type="number"
                name="amount"
                value="<?php echo (int) $item['amount']; ?>"
                min="0"
                step="1"
                required
                aria-label="Aantal"
            >

            <input
                type="hidden"
                name="product"
                value="<?php echo htmlspecialchars($product, ENT_QUOTES, 'UTF-8'); ?>"
            >

            <button type="submit" name="action" value="update">
                Aanpassen
            </button>

            <button
                type="submit"
                name="action"
                value="remove"
                formnovalidate
            >
                Verwijder
            </button>

        </form>

    <?php endforeach; ?>

    <h3>
        Totaal: €<?php echo number_format($total, 2, ',', '.'); ?>
    </h3>

    <form method="post" action="cart.php">

        <button type="submit" name="action" value="empty">
            Leeg winkelwagen
        </button>

        <button type="submit" name="action" value="checkout">
            Afrekenen
        </button>

    </form>

<?php endif; ?>

<br>

<a href="winkelwagen.php">Terug naar producten</a>