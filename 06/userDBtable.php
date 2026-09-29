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

// Item toevoegen
if (isset($_POST["add"]) && isset($_SESSION["user_id"])) {
    $itemId = (int) ($_POST["item_id"] ?? 0);

    if ($itemId > 0) {
        $statement = $pdo->prepare(
            "INSERT INTO orders (user_id, item_id)
             VALUES (?, ?)"
        );
        $statement->execute([$_SESSION["user_id"], $itemId]);
    }

    header("Location: userDBtable.php");
    exit;
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

    <form method="post">
        <button type="submit" name="logout">Uitloggen</button>
    </form>

    <h2>Items</h2>

    <?php
    $items = $pdo->query("SELECT * FROM items");

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

    <h2>Toegevoegde items</h2>

    <?php
    $statement = $pdo->prepare(
        "SELECT items.name, items.price
         FROM orders
         JOIN items ON orders.item_id = items.item_id
         WHERE orders.user_id = ?"
    );

    $statement->execute([$_SESSION["user_id"]]);
    $orders = $statement->fetchAll();

    foreach ($orders as $order):
    ?>

        <p>
            <?php echo htmlspecialchars($order["name"]); ?>

            - €<?php echo number_format($order["price"], 2, ",", "."); ?>
        </p>

    <?php endforeach; ?>

<?php endif; ?>