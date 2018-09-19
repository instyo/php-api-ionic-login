<?php

//call connection
require_once "conn.php";

//retrieve data from ionic input form
$_POST = json_decode(file_get_contents('php://input'), true);

// create variables to save username & password that have been sent before
$username = escape($_POST['username']);
$password = escape(md5($_POST['password']));

// create query to check if username and password are match from database
$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($link, $query);
// create variable to store users data from database
$userdata = array();
// storing users data into $userdata variable
while($row=mysqli_fetch_assoc($result)){
	$userdata[] = $row;
}

$message = array();
if($result){
	if(mysqli_num_rows($result) !=0){
		$message = array('status' => 'true', 'message' => 'Successfully login!', 'userdata' => $userdata );
	} else {
		$message = array('status' => 'false', 'message' => 'Username or password not match!');
	}
	echo json_encode($message);
}