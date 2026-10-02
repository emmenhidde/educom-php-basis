<?php

// Value: de functie verhoogt alleen haar eigen kopie van het getal.
function verhoogValue($number) {
    $number++;
    echo "Binnen verhoogValue: $number<br>";
}

// Reference: met & verwijst de parameter naar de oorspronkelijke variabele.
function verhoogReference(&$number) {
    $number++;
    echo "Binnen verhoogReference: $number<br>";
}

// Begin met een gewone variabele en toon het resultaat van beide functies.
$initialValue = 10.00;

echo "<h2>Value vs reference</h2>";
echo "Beginwaarde is nu: $initialValue<br><br>";

verhoogValue($initialValue);
echo "Beginwaarde na verhoogValue: $initialValue<br>";
echo "Value: alleen de lokale kopie verandert. Beginwaarde blijft 10.00.<br><br>";

verhoogReference($initialValue);
echo "Beginwaarde na verhoogReference: $initialValue<br>";
echo "Reference: de oorspronkelijke variabele verandert. Beginwaarde wordt 11.00.<br><br>";

class BankAccount {
    public float $balance = 1000.00;
}

function voegToe(BankAccount $account) {
    $account->balance += 10;
}

$myAccount = new BankAccount();

echo "<h2>Met object</h2>";
echo "Saldo voor functie: " . $myAccount->balance . "<br>";

voegToe($myAccount);

echo "Saldo na functie: " . $myAccount->balance . "<br>";
echo "De variabele en de parameter verwijzen naar hetzelfde object.<br>";
echo "Daarom verandert het saldo van 1000 naar 1010, ook zonder &amp;.<br>";

?>