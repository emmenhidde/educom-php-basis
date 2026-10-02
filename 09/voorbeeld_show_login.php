<?php 

session_start();
session_destroy();

function show_form() {
	$form_data  = "<html><body>Please login:<form action='show_login.php' method='POST'>";
	$form_data .= "Username:<input type='text' name='user'><br>";
	$form_data .= "Password:<input type='password' name='password'>";
	$form_data .= "<input type='submit' value='login'>";
	$form_data .= "</form></body></html>";
	echo $form_data;
}

function check_login($username, $password) {
	$mysqli = new mysqli("localhost", "root", "", "user_db"); 
	/* check connection */ 
	if (mysqli_connect_errno()) { 
	    printf("Connect failed: %s<br>", mysqli_connect_error()); 
		exit(); 
	} 
	$query = "SELECT * FROM users WHERE username = '".$username."' AND password = '".md5($password)."'"; 
	if ($result = $mysqli->query($query)) { 
		$row_cnt = $result->num_rows;
		if ($row_cnt == 1) {
			return true;
		} else {
			return false;
		}
		/* free result set */ 
		$result->close(); 
	} 
	/* close connection */ 
	$mysqli->close();

	
	return false;
}

if (isset($_POST['user']) && isset($_POST['password'])) {
    $user = $_POST['user'];
	$password = $_POST['password'];
	//if ($user == "admin" && $password == "admin") {
	//	$_SESSION['user'] = $_POST['user'];
	//}
	if (check_login($user, $password)) {
		$_SESSION['user'] = $_POST['user'];
	}
}

if (isset($_SESSION['user'])) {
	echo "Welcome ".$_SESSION['user'].", you are logged in!";
} else {
	show_form();
}
?> 



