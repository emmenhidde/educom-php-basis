<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    // voeg validatie toe op voornaam met foutmelding als deze niet in is gevuld
}

function format_naw($voornaam, $achternaam, $adres, $postcode, $woonplaats)
{
	return "Naam: " . "<b>" . htmlspecialchars($voornaam . ' ' . $achternaam) . "</b>" . '<br>' .
		"Adres: " . "<b>" . htmlspecialchars($adres). "</b>" . '<br>' .
		"Postcode en woonplaats: " . "<b>" . htmlspecialchars($postcode . ' ' . $woonplaats) . "</b>";
}
?>

<form method="post">
    <label>Voornaam:</label>
    <input type="text" name="voornaam" required><br><br>

    <label>Achternaam:</label>
    <input type="text" name="achternaam"><br><br>

    <label>Adres:</label>
    <input type="text" name="adres"><br><br>

    <label>Postcode:</label>
    <input type="text" name="postcode"><br><br>

    <label>Woonplaats:</label>
    <input type="text" name="woonplaats"><br><br>

    <input type="submit" value="Verstuur">
    
</form>

<?php

echo format_naw(
    $_POST['voornaam'] ?? '',
    $_POST['achternaam'] ?? '',
    $_POST['adres'] ?? '',
    $_POST['postcode'] ?? '',
    $_POST['woonplaats'] ?? ''
);

?>