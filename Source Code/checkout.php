<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>How to Contact Us </title>
<link href="images/style.css" rel="stylesheet" type="text/css" />
</head>

<body id="body">
   
   <!-- outer div is the outer most container -->
   
   <div id="outer_most_div">
<?php
	
	session_start();
	if ( !isset($_SESSION['_logged_in'] ) || $_SESSION['logged_in'] !== true ) 
	{
		// not logged in, move to login page
		header('Location: user_login.php');
		exit;
	}

	
	//Include the files
	require_once('header_nav.php');
	require_once('footer.php');
	require_once('pagination.php');
 
    // display the product list when user click on view product link
	echo "<div id='h2_div'>  	  
		     <h2> Checkout Functionality is out of the assignment requirement </h2>
	     </div>";
?>	 
   
</div>
   
</body>
</html>