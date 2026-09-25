<?php

$voornaamError = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['voornaam'])) {
        $voornaamError = "Vul alstublieft uw voornaam in.<br><br>";
    }
}

function format_naw($voornaam, $achternaam, $adres, $postcode, $woonplaats)
{
	return "Naam: " . "<b>" . htmlspecialchars(trim($voornaam)) . ' ' . htmlspecialchars(trim($achternaam)) . "</b>" . '<br>' .
		"Adres: " . "<b>" . htmlspecialchars(trim($adres)). "</b>" . '<br>' .
		"Postcode en woonplaats: " . "<b>" . htmlspecialchars(trim($postcode)) . ' ' . htmlspecialchars(trim($woonplaats)) . "</b>";
}
?>

<form method="post">
    <label>Voornaam:</label>
    <input type="text" name="voornaam" ><br><br>
    <span style="color:red;">
        <?php echo $voornaamError; ?>
    </span>

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

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['voornaam'])) {

    echo format_naw(
        $_POST['voornaam'] ?? '',
        $_POST['achternaam'] ?? '',
        $_POST['adres'] ?? '',
        $_POST['postcode'] ?? '',
        $_POST['woonplaats'] ?? ''
    );
}

?>