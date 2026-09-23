<?php 
// Calc fibonnaci
$lastNum = 0; 
$addNum = 1;

echo $lastNum, ", ", $addNum;
for ($i = 0; $i < 20; $i++)  {
	echo ", ", ($lastNum + $addNum);
    $totalBoth = ($lastNum + $addNum); 
    $lastNum= $addNum;
    $addNum = $totalBoth;
}