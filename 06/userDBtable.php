<?php

session_start();
require "db.php";

$error = "";

// Inloggen
if (isset($_POST["login"])) {
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    $statement = $pdo->prepare(
        "SELECT * FROM users
         WHERE username = ? AND password = ?"
    );
    $statement->execute([$username, $password]);

    $user = $statement->fetch();

    if ($user) {
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["username"] = $user["username"];
    } else {
        $error = "Onjuiste gebruikersnaam of wachtwoord.";
    }
}

// Uitloggen
if (isset($_POST["logout"])) {
    $_SESSION = [];
    session_destroy();

    header("Location: userDBtable.php");
    exit;
}

// Items verzamelen in de winkelwagen
if (isset($_POST["add"]) && isset($_SESSION["user_id"])) {
    $itemId = (int) ($_POST["item_id"] ?? 0);

    if ($itemId > 0) {
        $statement = $pdo->prepare("SELECT item_id FROM items WHERE item_id = ?");
        $statement->execute([$itemId]);

        if ($statement->fetch()) {
            $_SESSION["cart"][$itemId] = ($_SESSION["cart"][$itemId] ?? 0) + 1;
        }
    }

    header("Location: userDBtable.php");
    exit;
}

// De winkelwagen opslaan als een volledige order
if (isset($_POST["checkout"]) && isset($_SESSION["user_id"])) {
    $cart = $_SESSION["cart"] ?? [];

    if (!empty($cart)) {
        try {
            $pdo->beginTransaction();

            $statement = $pdo->prepare("INSERT INTO orders (user_id) VALUES (?)");
            $statement->execute([$_SESSION["user_id"]]);
            $orderId = $pdo->lastInsertId();

            $statement = $pdo->prepare(
                "INSERT INTO order_items (order_id, item_id, quantity)
                 VALUES (?, ?, ?)"
            );

            foreach ($cart as $itemId => $quantity) {
                $statement->execute([$orderId, $itemId, $quantity]);
            }

            $pdo->commit();
            unset($_SESSION["cart"]);
            header("Location: userDBtable.php");
            exit;
        } catch (PDOException $exception) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $error = "Bestelling opslaan is niet gelukt.";
        }
    }
}

?>

<?php if (!isset($_SESSION["user_id"])): ?>

    <h2>Inloggen</h2>

    <?php if ($error !== ""): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Gebruikersnaam:</label>
        <input type="text" name="username" required>

        <br><br>

        <label>Wachtwoord:</label>
        <input type="password" name="password" required>

        <br><br>

        <button type="submit" name="login">Inloggen</button>
    </form>

<?php else: ?>

    <h2>
        Welkom
        <?php echo htmlspecialchars($_SESSION["username"]); ?>
    </h2>

    <?php if ($error !== ""): ?>
        <p><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="post">
        <button type="submit" name="logout">Uitloggen</button>
    </form>

    <h2>Items</h2>

    <?php
    $items = $pdo->query("SELECT * FROM items")->fetchAll();

    foreach ($items as $item):
    ?>

        <form method="post">
            <?php echo htmlspecialchars($item["name"]); ?>

            - €<?php echo number_format($item["price"], 2, ",", "."); ?>

            <input
                type="hidden"
                name="item_id"
                value="<?php echo $item["item_id"]; ?>"
            >

            <button type="submit" name="add">Voeg toe</button>
        </form>

    <?php endforeach; ?>

    <h2>Winkelwagen</h2>

    <?php $cart = $_SESSION["cart"] ?? []; ?>

    <?php if (empty($cart)): ?>
        <p>Je winkelwagen is leeg.</p>
    <?php else: ?>
        <?php foreach ($items as $item): ?>
            <?php if (isset($cart[$item["item_id"]])): ?>
                <p>
                    <?php echo htmlspecialchars($item["name"]); ?>
                    - <?php echo (int) $cart[$item["item_id"]]; ?>x
                    (€<?php echo number_format($item["price"] * $cart[$item["item_id"]], 2, ",", "."); ?>)
                </p>
            <?php endif; ?>
        <?php endforeach; ?>

        <form method="post">
            <button type="submit" name="checkout">Bestelling plaatsen</button>
        </form>
    <?php endif; ?>

    <h2>Bestellingen</h2>

    <?php
    $statement = $pdo->prepare(
        "SELECT orders.order_id, items.name, order_items.quantity
         FROM orders
         JOIN order_items ON orders.order_id = order_items.order_id
         JOIN items ON order_items.item_id = items.item_id
         WHERE orders.user_id = ?
         ORDER BY orders.order_id DESC"
    );
    $statement->execute([$_SESSION["user_id"]]);
    $orderItems = $statement->fetchAll();
    $lastOrderId = null;

    foreach ($orderItems as $orderItem):
        if ($lastOrderId !== $orderItem["order_id"]):
            if ($lastOrderId !== null) {
                echo "</ul>";
            }
            echo "<h3>Bestelling #" . (int) $orderItem["order_id"] . "</h3><ul>";
            $lastOrderId = $orderItem["order_id"];
        endif;
    ?>
        <li>
            <?php echo htmlspecialchars($orderItem["name"]); ?>
            - <?php echo (int) $orderItem["quantity"]; ?>x
        </li>

    <?php endforeach; ?>
    <?php if ($lastOrderId !== null) echo "</ul>"; ?>

<?php endif; ?>