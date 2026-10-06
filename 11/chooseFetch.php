<?php
require_once __DIR__ . '/DBconnect.php';

$fetchTypes = [
    'FETCH_ASSOC' => [
        'mode' => PDO::FETCH_ASSOC,
        'description' => 'FETCH_ASSOC geeft elke rij terug als een array met kolomnamen als sleutels.',
    ],
    'FETCH_BOTH' => [
        'mode' => PDO::FETCH_BOTH,
        'description' => 'FETCH_BOTH geeft elke rij terug als een array met zowel kolomnamen als numerieke sleutels.',
    ],
    'FETCH_LAZY' => [
        'mode' => PDO::FETCH_LAZY,
        'description' => 'FETCH_LAZY geeft elke rij terug als een PDOrow-object dat de kolommen pas uitleest wanneer ze nodig zijn.',
    ],
    'FETCH_OBJ' => [
        'mode' => PDO::FETCH_OBJ,
        'description' => 'FETCH_OBJ geeft elke rij terug als een object waarvan de kolommen eigenschappen zijn.',
    ],
];

$requestedFetchType = $_GET['fetch'] ?? '';
$selectedFetchType = is_string($requestedFetchType) && isset($fetchTypes[$requestedFetchType])
    ? $requestedFetchType
    : null;
$rows = [];
$error = '';

if ($selectedFetchType !== null) {
    try {
        if ($selectedFetchType !== 'FETCH_LAZY') {
            $statement = DBConnect::getInstance()->query('SELECT * FROM userTable11');
            $rows = $statement->fetchAll($fetchTypes[$selectedFetchType]['mode']);
        }   else {
            $statement = DBConnect::getInstance()->query('SELECT * FROM userTable11');
            $rows = [];
            $columnNames = [];
            for ($i = 0; $i < $statement->columnCount(); $i++) {
                $columnNames[] = $statement->getColumnMeta($i)['name'];
            }

            while ($row = $statement->fetch($fetchTypes[$selectedFetchType]['mode'])) {
                $values = [];
                foreach ($columnNames as $columnName) {
                    $values[$columnName] = $row->$columnName;
                }
                $rows[] = $values;
            }
        }
    } catch (PDOException $exception) {
        $error = 'Databasefout: ' . $exception->getMessage();
    }
}

$pageTitle = $selectedFetchType ?? 'Kies een fetch-type';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
</head>
<body>
    <?php if ($selectedFetchType === null): ?>
        <h1>Kies een fetch-type</h1>
    <?php else: ?>
        <h1><?= htmlspecialchars($selectedFetchType, ENT_QUOTES, 'UTF-8') ?></h1>
        <p><?= htmlspecialchars($fetchTypes[$selectedFetchType]['description'], ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <?php foreach ($fetchTypes as $fetchType => $details): ?>
        <form method="get" style="display: inline;">
            <button type="submit" name="fetch" value="<?= htmlspecialchars($fetchType, ENT_QUOTES, 'UTF-8') ?>">
                <?= htmlspecialchars($fetchType, ENT_QUOTES, 'UTF-8') ?>
            </button>
        </form>
    <?php endforeach; ?>

    <?php if ($selectedFetchType !== null): ?>
        <?php if ($error !== ''): ?>
            <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php else: ?>
            <pre><?= htmlspecialchars(print_r($rows, true), ENT_QUOTES, 'UTF-8') ?></pre>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>