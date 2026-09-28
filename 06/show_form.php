<?php 

$item_array = array("item1"=>"1.25", "item2"=>"5.00", "item3"=>"10.00");
//var_dump($item_array);
//FIXME: dit moet anders
foreach ($item_array as $key => $value) {
	//echo $key." = ".$value."<br>";
	$html_string  = "<p><form action='shopping_cart.php' method='POST'>";
	$html_string .= $key."&nbsp;<input type='hidden' name='item' value='".$key."'>";
	$html_string .= "<input type='submit' value='add to shopping cart'></form></p>";
	echo $html_string;
}

?> 

