<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Welcome User Login Page </title>
<link href="images/style.css" rel="stylesheet" type="text/css" />
</head>

<body id="body">
   
   <!-- outer div is the outer most container -->
   
   <div id="outer_most_div">
<?php
	//Include the files
	require_once('header_nav.php');
	require_once('footer.php');
?>
	<div id='h2_div'> <h2> Login/Register </h2> </div>
	<div id='product_list_div'>
	       
		           <table>
				   <form id='list_prod_form' method='post' action='check_user.php'>
				       <tr>
					       <td> <label> User Name: </label> </td>
						   <td> <input type='text' name='user_name' value='' />  </td>				
				       </tr>
					   <tr>
					       <td> <label> Password: </label> </td>
						   <td> <input type='password' name='pass' value='' /> </td>				
				       </tr>
					   <tr>
					       <td>  <input type='submit' name='loginBtn' value='Login Now' > </input> </td>	
						   <td>  <a href="#" name='rgBtn' > Not Registered? </a> </td>			
				       </tr>				
					</form>
				   </table>
         </div>
</div>
   
</body>
</html>