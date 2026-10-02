<?php

require __DIR__ . '/InterfaceIdentifier.php';

// Maakt een voorbeeldgebruiker met een pasfoto.
$user = new User('00012345', 'pasfoto_.png');
$passport = new User($user->getId(), 'paspoort_stock.jpg');
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identiteitsbewijs</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; }
        .passport-photo { width: 10cm; max-width: 100%; height: auto; }
        .status { font-weight: bold; }
        .valid { color: green; }
        .invalid { color: firebrick; }
    </style>
</head>
<body>
    <h1>Pasfoto</h1>
    <?php $user->showImage(); ?>
    <?php $passport->showPassport(); ?>
</body>
</html>