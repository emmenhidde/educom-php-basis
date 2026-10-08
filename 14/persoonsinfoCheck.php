<?php
$invulVelden = [
	'voornaam' => trim(ucfirst(str_replace('  ', ' ', $_POST['voornaam'] ?? ''))),
	'achternaam' => trim(ucfirst(str_replace('  ', ' ', $_POST['achternaam'] ?? ''))),
    'adres' => trim(str_replace('  ', ' ', $_POST['adres'] ?? '')),
    'postcode' => trim(str_replace('  ', ' ', $_POST['postcode'] ?? '')),
    'telefoon' => trim(str_replace('  ', ' ', $_POST['telefoon'] ?? '')),
	'email' => trim(strtolower(str_replace(' ',  '', $_POST['email'] ?? ''))),
];

$validiteit = [
	'voornaam' => $invulVelden['voornaam'] !== '',
	'achternaam' => $invulVelden['achternaam'] !== '',
	'adres' => $invulVelden['adres'] !== '',
	'postcode' => preg_match('/^[1-9][0-9]{3}\s?[A-Z]{2}$/i', $invulVelden['postcode']) === 1,
    'telefoon' => preg_match('/^(?:\+31|0031|0)?([1-9][0-9]{8})$/', $invulVelden['telefoon']) === 1,
    'email' => preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $invulVelden['email']) === 1,
];

$labels = [
	'voornaam' => 'Voornaam',
	'achternaam' => 'Achternaam',
    'adres' => 'Adres',
    'postcode' => 'Postcode',
	'telefoon' => 'Telefoonnummer',
    'email' => 'E-mailadres',
];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($labels as $naam => $label) {
        echo '<p>' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . ': ';
        echo $invulVelden[$naam] !== '' ?  htmlspecialchars($invulVelden[$naam], ENT_QUOTES, 'UTF-8') : '';
        echo $validiteit[$naam] ? ' ✅' : ' ❌';
        echo '</p>';
    }
}
?>