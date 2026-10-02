<?php

require __DIR__ . '/sessionKeeper.php';
require __DIR__ . '/class_shoppingcart.php';

SessionKeeper::start();

$shoppingCart = new ShoppingCart($_SESSION['cart']);

$producten = [
    "Brood" => 2.50,
    "Broccoli" => 1.75,
    "Melk" => 1.50,
    "Appels" => 2.25,
    "Pasta" => 1.80
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $product = $_POST['product'] ?? '';
        $amount = filter_var(
            $_POST['amount'] ?? 1,
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]
        );

        if (
            is_string($product) &&
            isset($producten[$product]) &&
            $amount !== false
        ) {
            $shoppingCart->addToCart($product, $producten[$product], $amount);
        }

        $_SESSION['cart'] = $shoppingCart->getCart();
    }

    header('Location: winkelwagenOOP.php', true, 303);
}

$cartItems = $shoppingCart->getCart();

?>

<h2>Producten</h2>

<?php foreach ($producten as $product => $price): ?>

    <?php
    $toegevoegdAantal = $cartItems[$product]['amount'] ?? 0;
    ?>

    <form method="post" action="winkelwagenOOP.php">

        <?php echo htmlspecialchars($product, ENT_QUOTES, 'UTF-8'); ?>

        - €<?php echo number_format($price, 2, ',', '.'); ?>

        <input
            type="hidden"
            name="product"
            value="<?php echo htmlspecialchars($product, ENT_QUOTES, 'UTF-8'); ?>"
        >

        <input
            type="number"
            name="amount"
            value="0"
            min="0"
            step="1"
            style="width: 8ch;"
            aria-label="Aantal"
        >

        <button type="submit" name="action" value="add">
            Voeg toe
        </button>

        <?php if ($toegevoegdAantal > 0): ?>
            <span><?php echo $toegevoegdAantal; ?>x</span>
        <?php endif; ?>

    </form>

<?php endforeach; ?>

<p><a href="cartOOP.php">Bekijk winkelwagen</a></p>
