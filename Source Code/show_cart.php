<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Following items have been added to your cart </title>
<link href="images/style.css" rel="stylesheet" type="text/css" />
</head>

<body id="body">
   
   <!-- outer div is the outer most container -->
   
   <div id="outer_most_div">
<?php
	
	session_start();
    session_id();
    $sid = session_id();
	
	//Include these files
	require_once('header_nav.php');
	require_once('footer.php');
	require_once('pagination.php');
	require_once('mycart.php');
	
	//Connect to mysql db and perform select query
	$conn = mysql_connect('localhost','gbadmin','cheeta');
	mysql_select_db('greenbagdb' , $conn);
	$sql = 'SELECT * FROM cart c, product p WHERE c.product_id_fk=p.product_id';
	
	//Create a Pagination object
	$pager = new Pagination( $conn, $sql, 10, 10 );
	
	//The paginate() function returns a mysql result set 
	$rs = $pager->paginate();
?>
	
	<div id='product_list_div'>
	<table border='1'>
	<tr> <th> Product Name </th> <th> Unit Price </th> <th> Quantity</th> <th> Delete</th> <th> Update Quantity</th></tr> 
<?php
	while( $row = mysql_fetch_assoc($rs) ) 
	{   // loop start
?>
	    <tr>
	          <td> <?php echo $row['product_name'] ?> </td> 
	          <td> <?php echo $row['product_price'] ?> </td> 
			  <form action="mycart.php" name="myform" method="post" >
			  <td> 
					<input type='text' name='qty' value='<?php echo $row['quantity']?>' />
					<input type='hidden' name='prod_id' value='<?php echo $row['product_id']?>' /> 
			  </td>
			  <td>					
			  		<input type="submit" name="action" value="Delete" />
			  </td>
			  <td>					
			  		<input type="submit" name="action" value="Update" />
			  </td>
			  </form>
	    </tr>
        
  <?php } // loop end ?> 
   
   <tr>
			<td> <h4> Total: &pound; 
		    <?php 
				$sql = 'SELECT SUM(product_price*quantity) FROM cart, product WHERE product_id_fk=product_id';
				$result = mysql_query($sql);
				$amount;
				while ($row = mysql_fetch_array($result))
				{
					$amount = $row[0];
				}
				echo number_format($amount, 2, '.', '');
		   ?>
		   </h4>
		   </td>
		   <td> </td>
		   <td> </td>
		   <td> </td>
		   <td> </td>
	</tr>
		
   </table>
   
   <p> </p>
   <a href='list_product.php'> Continue Shopping </a> >>
   <a href='checkout.php'> Checkout </a>
   <p> </p>

   <?php echo $pager->renderFullNav(); ?>
  
  </div>

</div>
   
</body>
</html>