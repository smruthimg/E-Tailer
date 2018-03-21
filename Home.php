<?php

	require_once("DB.class.php");
if(isset($_SESSION['UserID'])){
$userid=$_SESSION['UserID'];
}else{
$userid=null;
}
	$db=new DB();
 if(isset($_POST['product'])&& ($_POST['add']=='Add To Cart') ){
 	if(empty($_SESSION['loggedIn'])){
		header("Location:Login.php",302);
		exit;
	}

  addToCart($_POST['product'],$_POST['Price'],$userid);

 }
 //add to cart
   function addToCart($p,$s,$userid){

	$db=new DB();
   $db->addToCart($p,$s,$userid);
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

    <body class="homepage">
        <div id="header-wrapper">
            <!-- Nav -->
            <nav id="nav">
                <ul>
                    <li class="current"><a href="index.php">Home</a></li>

                    <li><a href="cart.php">Cart</a></li>
                    <li><a href="admin.php">Admin</a></li>
                </ul>
            </nav>

        </div>

        <div id="page-wrapper">

            <!-- Main -->
            <div id="main-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="12u">

                            <!-- Sale -->
                            <section>
                                <header class="major">
                                    <h2>Sale</h2>
                                </header>
                                <div class="row">
                                    <div>
                                        <?php echo $db->getAllSaleProductsAsTableClass(); ?>
                                    </div>

                                </div>
                            </section>

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

                                    <div>
                                        <?php echo $db->getAllProductsAsTableClass();?>

                                    </div>
                                </div>
                            </section>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </body>

    </html>