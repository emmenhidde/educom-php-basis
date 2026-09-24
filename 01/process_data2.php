<?php

$naam = $_POST["naam"];
$adres = $_POST["adres"];
$telefoon = $_POST["telefoon"];
$opmerkingen = $_POST["opmerkingen"];

echo "<table>";
echo "<tr><td>Naam:</td><td>" . $naam . "</td></tr>";
echo "<tr><td>Adres:</td><td>" . $adres . "</td></tr>";
echo "<tr><td>Telefoon:</td><td>" . $telefoon . "</td></tr>";
echo "<tr><td>Opmerkingen:</td><td>" . $opmerkingen . "</td></tr>";
echo "</table>";

?>