<?php

$item_array = array(array("item1","1.25",                "https://www.kidsmathgamesonline.com/images/pictures/numbers600/number1.jpg"),
                    array("item2","16.95","https://www.kidsmathgamesonline.com/images/pictures/numbers600/number2.jpg"),
					array("item3","100.85","https://www.kidsmathgamesonline.com/images/pictures/numbers600/number3.jpg"));
echo "<pre>";				
var_dump($item_array);
echo "</pre>";

for ($i=0; $i < sizeof($item_array); $i++) {
	echo "name = ".$item_array[$i][0];
	echo "<br>";
	echo "<img src=".$item_array[$i][2]." width='100'>";
	echo "<br>";
	echo "price = &euro; ".$item_array[$i][1];
	echo "<hr>";
}

?>
					
    