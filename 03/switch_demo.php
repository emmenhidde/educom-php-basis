<?php
$postValue = $_POST["postValue"]??'';
?>

<form method="post">
    <label>Give a number:</label>
    <input type="text" name="postValue">
</form>

<?php

// This switch statement:
if ($postValue !=="") {
    switch (true) {
        case !is_numeric($postValue):
            echo "The given input \"$postValue\" is not a number, try again\n";
            break;
        case $postValue < 0:
            echo "The given value \"$postValue\" is a negative number\n";
            break;
        case $postValue > 0 && $postValue < 100:
            echo "The given value \"$postValue\" is a small number\n";
            break;
        case $postValue >= 100 :
            echo "The given value \"$postValue\" is a large number\n";
            break;
        default:
            echo "The given input \"$postValue\" is undefined\n";
            break;
    }
}
?>