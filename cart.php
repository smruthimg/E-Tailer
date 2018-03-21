<?php
session_name("sg1626");//name of the cookie
	
session_start();
require_once("DB.class.php");
include('LoginBar.php');
include('main.html');
$db=new DB();
if(isset($_SESSION['UserID'])){
$userid=$_SESSION['UserID'];
}else{
$userid=null;
}
//is postback?
   if(isset($_POST['UserId'])&& ($_POST['EmptyCart']=='Empty Cart') ){
   	if(empty($_SESSION['loggedIn']) && $userid==null ){
		header("Location:Login.php",302);
		exit;
	}
//empty cart
 $db->deleteCart($_POST['UserId']);

 }
   


?>

<!DOCTYPE HTML>

<html>
	<head>
		<title>Shoe Town</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<link rel="stylesheet" href="assets/css/main.css" />

 
 
   
	</head>
	<body class="homepage" >

 <div id="header-wrapper">
        						<!-- Nav -->
							<nav id="nav">
								<ul>
									<li ><a href="index.php">Home</a></li>
	
									<li class="current"><a href="cart.php">Cart</a></li>
									<li ><a href="admin.php">Admin</a></li>
								</ul>
							</nav>
   
</div>


			<!-- Main -->
				<div id="main-wrapper">

					<div class="container">
						<div class="row">
							<div >

								
										<header class="major">
											<h2>Cart</h2>
										</header>
										<div>
                       
                       <div><?php echo $db->getAllCartAsTableClass($userid); ?></div>			
                       <footer>
                       <form action='cart.php' method='post'>
                       <div><h1>Total: <?php echo $db->getSumCart($userid); ?></h1></div>	
                       <input type='submit' name='EmptyCart' value='Empty Cart'>
                       <input type='hidden' name='UserId' value="<?php echo $userid ?>">
                       
                       </form >
                       
                       </footer>					
				
										</div>
									

							</div>
						</div>
						
					</div>
				</div>

	

	</body>
</html>

<?php

   include('footer.html');
?>