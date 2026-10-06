<?php
$error = '';
$personen = [];
$editId = filter_input(INPUT_GET, 'edit', FILTER_VALIDATE_INT);
$naamInput = '';
$adresInput = '';
$newNaam = '';
$newAdres = '';
$sortingVariable = $_GET['sort'] ?? '';
$sortingOrder = ($_GET['order'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';
$sortColumn = in_array($sortingVariable, ['naam', 'adres'], true) ? $sortingVariable : '';

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=personenSorteerTabel;charset=utf8mb4',
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);

        if ($action === 'delete') {
            if (!$id) {
                $error = 'Selecteer een geldige persoon om te verwijderen.';
            } else {
                $pdo->prepare('DELETE FROM personen WHERE id = ?')->execute([$id]);
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }
        } elseif ($action === 'insert' || $action === 'update') {
            $naam = $_POST['naam'] ?? '';
            $adres = $_POST['adres'] ?? '';

            if (!is_string($naam) || !is_string($adres)) {
                $naam = '';
                $adres = '';
            }

            $naam = trim($naam);
            $adres = trim($adres);

            if ($naam === '' || $adres === '') {
                $error = 'Vul een geldige naam en adres in.';
            } elseif ($action === 'update' && !$id) {
                $error = 'Selecteer een geldige persoon om aan te passen.';
            } else {
                if ($action === 'insert') {
                    $query = 'INSERT INTO personen (naam, adres) VALUES (?, ?)';
                    $values = [$naam, $adres];
                } else {
                    $query = 'UPDATE personen SET naam = ?, adres = ? WHERE id = ?';
                    $values = [$naam, $adres, $id];
                }

                $pdo->prepare($query)->execute($values);
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }

            if ($action === 'insert') {
                $newNaam = $naam;
                $newAdres = $adres;
            } else {
                $editId = $id;
                $naamInput = $naam;
                $adresInput = $adres;
            }
        } else {
            $error = 'Ongeldige formulieractie.';
        }
    }

    $sql = 'SELECT id, naam, adres FROM personen';
    if ($sortColumn !== '') {
        $sql .= " ORDER BY $sortColumn $sortingOrder";
    }
    $personen = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $exception) {
    $error = 'Databasefout: ' . $exception->getMessage();
}

$naamOrder = $sortingVariable === 'naam' && $sortingOrder === 'ASC' ? 'desc' : 'asc';
$adresOrder = $sortingVariable === 'adres' && $sortingOrder === 'ASC' ? 'desc' : 'asc';
$naamHeader = 'Naam' . ($sortingVariable === 'naam' ? ($sortingOrder === 'ASC' ? ' ↓' : ' ↑') : '');
$adresHeader = 'Adres' . ($sortingVariable === 'adres' ? ($sortingOrder === 'ASC' ? ' ↓' : ' ↑') : '');

$selectedPerson = null;
foreach ($personen as $persoon) {
    if ((string) $persoon['id'] === (string) $editId) {
        $selectedPerson = $persoon;
        break;
    }
}

if ($selectedPerson !== null && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $naamInput = $selectedPerson['naam'];
    $adresInput = $selectedPerson['adres'];
}

function escape($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>

<?php if ($error !== ''): ?>
    <p><?= escape($error) ?></p>
<?php endif; ?>

<form method="post">
    <input type="hidden" name="action" value="insert">
    <input name="naam" placeholder="Naam" value="<?= escape($newNaam) ?>" required>
    <input name="adres" placeholder="Adres" value="<?= escape($newAdres) ?>" required>
    <button>Toevoegen</button>
</form>

<form method="get">
    <select name="edit" onchange="this.form.submit()">
        <option value="">Selecteer een persoon</option>
        <?php foreach ($personen as $persoon): ?>
            <option value="<?= escape($persoon['id']) ?>" <?= (string) $persoon['id'] === (string) $editId ? 'selected' : '' ?>>
                <?= escape($persoon['naam']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<?php if ($selectedPerson !== null || ($error !== '' && $editId)): ?>
    <form method="post">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?= escape($editId) ?>">
        <input name="naam" placeholder="Naam" value="<?= escape($naamInput) ?>" required>
        <input name="adres" placeholder="Adres" value="<?= escape($adresInput) ?>" required>
        <button>Opslaan</button>
    </form>
<?php endif; ?>

<p><a href="?sort=naam&amp;order=<?= escape($naamOrder) ?>">Sorteer op naam</a> |
<a href="?sort=adres&amp;order=<?= escape($adresOrder) ?>">Sorteer op adres</a></p>

<table>
    <tr><th><?= escape($naamHeader) ?></th><th><?= escape($adresHeader) ?></th><th></th></tr>
    <?php foreach ($personen as $persoon): ?>
        <tr><td><?= escape($persoon['naam']) ?></td><td><?= escape($persoon['adres']) ?></td>
            <td><form method="post"><input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= escape($persoon['id']) ?>">
                <button>Verwijderen</button></form></td></tr>
    <?php endforeach; ?>
</table>
