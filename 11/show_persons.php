$db_handle = DBConnect::getInstance();
$person = new Person($db_handle);
$person->showPersons();