<?php
    
	session_start();
	if ( !isset($_SESSION['_logged_in'] ) || $_SESSION['logged_in'] !== true ) {
		// not logged in, move to login page
		header('Location: user_login.php');
		exit;
	}
	
	$usr = $_REQUEST['user_name'];
	$pswd = $_REQUEST['pass'];

	//Connect to mysql db
   	$conn = mysql_connect('localhost','gbadmin','cheeta');
	mysql_select_db('greenbagdb' , $conn);
	$sql = "SELECT * FROM user WHERE user_name='$usr' AND password='$pswd'";
	
	$result = mysql_query($sql);
	
	// if user is matched go to checkout page else redirect to user_login page
	if ( mysql_num_rows($result) >=1 ) 
	{
	    $_SESSION['logged_in'] = true;
		header("Location: checkout.php");
	}
	else
	{
	    header("Location: user_login.php");
	}	
	
?>