<?php 


$var1 = 5;
echo "\$var1: = 5"."<br>"; 
$var2 = "5";
echo "\$var2: = '5'"."<br>";
$var3 = 10;
echo "\$var3: = 10"."<br><br>";

echo "This shows how === works"."<br>";
echo "=== compares both the value and type of the var.<br>";
echo "var1 === var2: " . "<br>";
if ($var1 === $var2) {
    echo "var1 is equal to var2"."<br><br>";
} else {
    echo "var1 is not equal to var2"."<br><br>";
}       

echo "This shows how == works:"."<br>";
echo "== compares both the value of the var.<br>";
echo "var1 == var2: ". "<br>";
if ($var1 == $var2) {   
    echo "var1 is equal to var2"."<br><br>";
} else {
    echo "var1 is not equal to var2"."<br><br>";
} 

echo "This shows how && works:"."<br>";
echo "&& shows if both comparisons are true.<br>";
echo "var1 == var2 && var1 < var3: ". "<br>";
if ($var1 == $var2 && $var1 < $var3) {
    echo "var1 is equal to var2 and var1 is less than var3"."<br><br>";
} else {
    echo "var1 is not equal to var2 or var1 is not less than var3"."<br><br>";
}   

echo "This shows how || works:"."<br>";
echo "|| shows if at least one of the comparisons is true.<br>";
echo "var1 == var2 || var1 > var3: ". "<br>";
if ($var1 == $var2 || $var1 > $var3) {
    echo "var1 is equal to var2 or var1 is greater than var3"."<br><br>";
} else {
    echo "var1 is not equal to var2 and var1 is not greater than var3"."<br><br>";
}

?> 