<?php

	error_reporting(0);
	$db = mysql_connect("localhost", "gbadmin", "cheeta");
	mysql_select_db("greenbagdb",$db);
		  
	session_start();
	session_id();
	$sess =session_id();   // declare a global scope variable
    
	/************************Add New Item to Cart ************************************/
	function addToCart($prod_id)
	{
		global $sess;      // access global variable
		
		// check if same product already exist in cart, if so increase its quantity
		$sql = "SELECT * FROM cart WHERE product_id_fk='$prod_id' AND session_id='$sess'";
		$result = mysql_query($sql);
		
		if ( mysql_num_rows($result) == 0 ) 
		{
			$query = "INSERT INTO cart (session_id, quantity, product_id_fk) VALUES ('$sess', '1', '$prod_id')";
			$result = mysql_query($query);
		}
		else
		{
			$query = "UPDATE cart SET quantity=quantity+1 WHERE product_id_fk='$prod_id' AND session_id='$sess'";
			$result = mysql_query($query);
		}

    }
   
   /************************ Delete the requested item from the cart *************************************/
	function deleteCartItem($prod_id)
	{
		global $sess;      
		$sql = "DELETE FROM cart WHERE product_id_fk=$prod_id AND session_id='$sess'";
		$result = mysql_query($sql);
		
    }
	
	/************************ Make the cart empty *************************************/
	function emptyCart()
	{
		global $sess;      
		$sql = "DELETE FROM cart WHERE session_id='$sess'";
		$result = mysql_query($sql);
    }
	
	/************************** Update the quantity of an item in cart ************************************/
	function updateCartItem($prod_id, $qty)
	{
		global $sess;      
		$sql = "UPDATE cart SET quantity=$qty WHERE product_id_fk=$prod_id AND session_id='$sess'";
		$result = mysql_query($sql);
	}
	
	/***************************** get the total amount for items in the cart *********************************/
	function totalAmount()
	{
		global $sess;      // access global variable
		$sql = 'SELECT SUM(product_price*quantity) FROM cart, product WHERE product_id_fk=product_id';
		$result = mysql_query($sql);
		return $result;
	}
	
/************************ Program Body Start Here: 
Perform the relevant action according to request *********************
**********************************************************************/
    $action = $_REQUEST['action'];   // add, Delete, Update
	
	switch ($action)
	{
		case "add":
		$prod_id = $_REQUEST['prod_id'];
		addToCart( $prod_id);
		header("Location: show_cart.php");   // redirect to show_cart.php
		break;
		
		case "Delete":
		$prod_id = $_REQUEST['prod_id'];
		deleteCartItem($prod_id);
		header("Location: show_cart.php");
		break;
		
		case "Update":
		$prod_id = $_REQUEST['prod_id'];
		$qty = $_REQUEST['qty'];
		updateCartItem($prod_id, $qty);
		header("Location: show_cart.php");
		break;
	}
?>