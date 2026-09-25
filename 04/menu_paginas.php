<?php
$pagina = $_POST['page'] ?? 'starters';

$menu = [
    'starters' => [
        'titel' => 'Starters',
        'gerechten' => [
            ['naam' => 'Arancini Spinaci e Ricotta', 'prijs' => '€ 4,-'],
            ['naam' => 'Bruschetta', 'prijs' => '€ 3,-'],
            ['naam' => 'Prosciutto e Melone', 'prijs' => '€ 5,-'],
        ],
    ],
    'pastas' => [
        'titel' => 'Pastas',
        'gerechten' => [
            ['naam' => 'Tagliatelle al Ragù', 'prijs' => '€ 14,50'],
            ['naam' => 'Spaghettoni Cacio e Pepe', 'prijs' => '€ 12,-'],
            ['naam' => 'Spaghetti Carbonara', 'prijs' => '€ 15,50'],
        ],
    ],
    'pizzas' => [
        'titel' => 'Pizzas',
        'gerechten' => [
            ['naam' => 'Margherita', 'prijs' => '€ 5,-'],
            ['naam' => 'Salami', 'prijs' => '€ 6,-'],
            ['naam' => 'Margherita Sbagliata', 'prijs' => '€ 9,-'],
        ],
    ],
    'desserts' => [
        'titel' => 'Desserts',
        'gerechten' => [
            ['naam' => 'Tiramisu', 'prijs' => '€ 7,-'],
            ['naam' => 'Cannoli', 'prijs' => '€ 4,-'],
            ['naam' => 'Sgroppino', 'prijs' => '€ 8,-'],
        ],
    ],
];

if (!isset($menu[$pagina])) {
    $pagina = 'starters';
}

$huidigePagina = $menu[$pagina];
?>
<html>

<head>
    <title>Menu</title>
</head>

<body>

<h1>Menu</h1>

<?php foreach ($menu as $key => $categorie): ?>

    <form method="post" style="display:inline;">
        <button type="submit" name="page" value="<?= $key ?>">
            <?= $categorie['titel'] ?>
        </button>
    </form>

<?php endforeach; ?>

<h2><?= $huidigePagina['titel'] ?></h2>

<?php foreach ($huidigePagina['gerechten'] as $gerecht): ?>

    <p>
        <?= $gerecht['naam'] ?>
        -
        <?= $gerecht['prijs'] ?>
    </p>

<?php endforeach; ?>

</body>
</html>