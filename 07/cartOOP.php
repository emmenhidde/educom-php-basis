<?php

require_once __DIR__ . '/class_shoppingcart.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (($_POST['action'] ?? '') === 'empty') {
        $_SESSION = [];
        session_destroy();
    }

    header('Location: cartOOP.php', true, 303);
}

$shoppingCart = new ShoppingCart($_SESSION['cart'] ?? []);
$cartItems = $shoppingCart->getCart();
$totaal = 0;

?>

<h2>Winkelwagen</h2>

<?php if (empty($cartItems)): ?>
    <p>Je winkelwagen is leeg.</p>
<?php else: ?>
    <?php foreach ($cartItems as $product => $item): ?>
        <?php $subtotaal = $item['amount'] * $item['price']; ?>
        <?php $totaal += $subtotaal; ?>

        <p>
            <?php echo htmlspecialchars($product, ENT_QUOTES, 'UTF-8'); ?>:
            <?php echo (int) $item['amount']; ?> x
            €<?php echo number_format($item['price'], 2, ',', '.'); ?>
            = €<?php echo number_format($subtotaal, 2, ',', '.'); ?>
        </p>
    <?php endforeach; ?>

    <p>Totaal: €<?php echo number_format($totaal, 2, ',', '.'); ?></p>

    <form method="post" action="cartOOP.php">
        <button type="submit" name="action" value="empty">
            Leeg winkelwagen
        </button>
    </form>
<?php endif; ?>

<p><a href="winkelwagenOOP.php">Terug naar producten</a></p>
