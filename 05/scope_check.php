<?php


$a = 5;
echo "de var \$a is nu 5<br>";
echo $a++ . " Hier wordt deze getoond als 5 en gelijktijdig verhoogd naar 6";   
echo "<br>";
echo $a. " Nu toont hij wel 6<br>";     


$naam = "Hidde";

function toonNaam() {
    echo "Deze zal de var voor \$naam niet kunnen printen.
    <br>Deze is namelijk buiten de functie aangemaakt"  . $naam;   // Geeft een Error dat variable mist
}

toonNaam();

?>