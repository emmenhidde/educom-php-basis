<?php

$total = 0;
echo "De Gauss manier om een homogene reeks op te tellen is zo opgezet:"."<br>";
echo "Eerst worden de eerste en laatste waarde bij elkaar opgeteld."."<br>";
echo "Daarna worden de tweede en de een-na-laatste waarde bij elkaar opgeteld."."<br>";
echo "Enzovoort, totdat alle waarden zijn opgeteld."."<br>";
echo "Het resultaat kan worden teruggebracht naar de formule: (n*(n+1))/2"."<br><br>";

$appliedMin = $_POST['appliedMin'] ?? '';
$appliedMax = $_POST['appliedMax'] ?? '';

?>

<form method="post">

    <label>Minimale waarde:</label>
    <input type="number" name="appliedMin" step="1">

    <br><br>

    <label>Maximale waarde:</label>
    <input type="number" name="appliedMax" step="1">

    <br><br>

    <input type="submit" value="Verstuur">

</form>

<?php

// Blocks non-integer values
if ($appliedMin !== '' && $appliedMax !== '') {

    if (
        !preg_match('/^-?\d+$/', $appliedMin) ||
        !preg_match('/^-?\d+$/', $appliedMax)
    ) {
        echo "Gebruik alleen gehele getallen.";
        return;
    }
}

echo "<strong>Gauss formule:</strong><br>";
if ($appliedMin === '' || $appliedMax === '') {
    
    echo "<em><b>n x (a + b) / 2</b></em>";

} else {

    $count = $appliedMax - $appliedMin + 1;
    $answer = $count * ($appliedMin + $appliedMax) / 2;

    echo $count . " x (" . $appliedMin . " + " . $appliedMax . ") / 2";
    if ($count % 2 != 0) {
        echo " + " . (($appliedMin + $appliedMax) / 2);
        } 
    echo " = " . "<strong>$answer</strong>";
        if ($count % 2 != 0) {
        echo "<br>Since the count is odd, we add the middle value: " . (($appliedMin + $appliedMax) / 2);
        } 
    echo "<br><br>";

    for ($i = 0; $i < floor($count / 2); $i++) {

        $left = $appliedMin + $i;
        $right = $appliedMax - $i;

        $total += $left + $right;

        echo $left . " + " . $right . " = " . $total . "<br>";
    }

    if ($count % 2 != 0) {

        $middle = ($appliedMin + $appliedMax) / 2;
        $total += $middle;

        echo $middle . " = " . $total . "<br>";
    }

}

?>




