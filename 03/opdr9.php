<?php 
// loop 0-10
echo "Count 0-10"."<br>";
for ($i = 0; $i <= 10; $i++) {
    if ($i != 10) {
        echo $i. ", ";
    } else {
        echo $i;
    }
}

// Split first 10 values of pi
echo "<br><br>"."First 10 decimals of Pi"."<br>";
$strPi = strval(M_PI);
for ($val = 2; $val < 12; $val++) {
    if ($val != 11) {
        echo $strPi[$val]. ", ";
    } else {
        echo $strPi[$val];
    }    
}

?>