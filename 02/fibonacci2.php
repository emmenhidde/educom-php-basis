<?php 
// Calc fibonnaci
$lastNum = 0; 
$addNum = 1;
$returningStr = "";

for ($i = 0; $i < 22; $i++)  {
	$returningStr.= $lastNum."<br>";
    $totalBoth = ($lastNum + $addNum); 
    $lastNum= $addNum;
    $addNum = $totalBoth;
}
echo $returningStr;
?>
