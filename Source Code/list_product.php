<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Welcome to our product listing </title>
<link href="images/style.css" rel="stylesheet" type="text/css" />
</head>

<body id="body">
   
   <!-- outer div is the outer most container -->
   
   <div id="outer_most_div">
   
<?php
	
	session_start();      // Initialize session data     
    $sid =session_id();   //Get the current session id

	//Include the files
	require_once('header_nav.php');
	require_once('footer.php');
	require_once('pagination.php');
	
	//Connect to mysql db
	$conn = mysql_connect('localhost','gbadmin','cheeta');
	mysql_select_db('greenbagdb' , $conn);
	$sql = 'SELECT * FROM product ORDER BY product_name ASC';
	
	//Create a Pagination object
	$pager = new Pagination( $conn, $sql, 10, 10 );
	
	//The paginate() function returns a mysql result set 
	$rs = $pager->paginate();
?>
	<div id='product_list_div'>
	<table border='1'>
	<tr> <th> Product Name </th> <th> Product Colour </th> <th> Product Size </th> <th> Unit Price </th> <th> Add to Cart</th></tr> 
<?php
	while( $row = mysql_fetch_assoc($rs) ) 
	{   // loop start
?>
	    <tr>
	          <td> <?php echo $row['product_name'] ?> </td> 
	          <td bgcolor="<?php echo $row['product_colour'] ?>"> </td> 
		      <td> <?php echo $row['product_size'] ?> </td>
			  <td> <?php echo $row['product_price'] ?> </td>
		      <td> 
			     <form action='mycart.php' method='get' name='myform'>
				     <input type="hidden" name="prod_id" value="<?php echo $row['product_id']?>" />
					 <input type="hidden" name="quantity" value="1" />
					 <input type="hidden" name="action" value="add" />
					 <input type="submit" name="add" value="Add Item" />
				 </form>
			  </td> 
	    </tr>
        
  <?php } // loop end ?> 
   
   </table>
   
   <p> </p>

   <?php echo $pager->renderFullNav(); ?>
  
  </div>

</div>
   
</body>
</html>