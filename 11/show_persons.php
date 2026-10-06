<?php
require_once __DIR__ . '/DBconnect.php';
require_once __DIR__ . '/Person.php';

require __DIR__ . '/User.class.php';

$connectedDB = DBConnect::getInstance();

$person = new Person($connectedDB);
$user = new User($connectedDB);

echo '<strong>Person<br></strong>';
$person->showPerson();
echo '<br><br>';
echo '<strong>User<br></strong>';
$user->showUser();
?>