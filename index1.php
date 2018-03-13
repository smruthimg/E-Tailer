<?php

	
	require_once("DB.class.php");


	$db=new DB();
 if(isset($_POST['product'])&& ($_POST['add']=='Add To Cart') ){

  addToCart($_POST['product'],($_POST['Price']));

 }
 
   function addToCart($p,$s){

	$db=new DB();
   $db->addToCart($p,$s);
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

		<div id="page-wrapper">

			<!-- Header -->
				<div id="header-wrapper">
					<div id="header">

						<!-- Logo -->
							<h1><a href="index.php"><em><strong>Shoe Town</strong></em></a></h1>

						<!-- Nav -->
							<nav id="nav">
								<ul>
									<li class="current"><a href="index.php">Home</a></li>
									<li>
										
									</li>
									<li><a href="cart.php">Cart</a></li>
									<li><a href="admin.php">Admin</a></li>
								</ul>
							</nav>

						<!-- Banner -->
							<section id="banner" style="background-image: url('sandals-blue-shoes-strap-shoe-40377.jpeg');background-size: cover;">
								<header>
									<h3 style="color: seashell;font-style: italic;font-weight: 400">"'Cause you're in shoo-shoo-shoo, shoo-shoo-shoo,shoo-shoo, shoo-shoo, shoo-shoo" </h3>
									<p><h2 style="color: seashell;font-style: italic;font-family:Parkavenue;font-weight: 700">Shoe Town</h2></p>
								</header>
							</section>


			<!-- Main -->
				<div id="main-wrapper">
					<div class="container">
						<div class="row">
							<div >

					<!-- Sale -->
								
										<header class="major">
											<h2>Sale</h2>
										</header>
										<div>
                       <div><?php echo $db->getAllSaleProductsAsTableClass(); ?></div>								
											
										
											
											
										</div>
									

							</div>
						</div>
						<div class="row">
							<div class="12u">

								<!-- Catalog -->
                                
									<section>
										<header class="major">
											<h2>Catalog</h2>
										</header>
										<div class="row">
											
						
										 <div><?php echo $db->getAllProductsAsTableClass();?>
													
											
											
										</div>
									</section>

							</div>
						</div>
					</div>
				</div>

			<!-- Footer -->
				<div id="footer-wrapper">
					
						<div class="row">
							<div class="12u">

								<!-- Copyright -->
									<div id="copyright">
										<ul class="links">
											<li>&copy; Untitled. All rights reserved.</li>
										</ul>
									</div>

							</div>
						</div>
					</section>
				</div>

		</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/skel-viewport.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>
</html>