<?php
$error = '';
$rows = [];

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=lettervolgorde;charset=utf8mb4',
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $update = $pdo->prepare('UPDATE letterVolgorde SET letter = ? WHERE id = ?');

        foreach ($_POST['letters'] ?? [] as $id => $letter) {
            if (is_string($letter)) {
                $update->execute([$letter, $id]);
            }
        }
    }

    $rows = $pdo->query('SELECT id, letter FROM letterVolgorde ORDER BY id')
        ->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $exception) {
    $error = 'Databasefout: ' . $exception->getMessage();
}
?>

<h1>Lettervolgorde</h1>
<?php if ($error !== ''): ?>
    <p><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
<form method="post">
    <?php foreach ($rows as $row): ?>
        <?= htmlspecialchars($row['id']) ?>
        <input name="letters[<?= htmlspecialchars($row['id']) ?>]"
               value="<?= htmlspecialchars($row['letter']) ?>" maxlength="1">
        <br>
    <?php endforeach; ?>
    <button>Opslaan</button>
</form>
