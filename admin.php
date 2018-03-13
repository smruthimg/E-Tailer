<?php

	
	require_once("DB.class.php");
include('main.html');
 $db=new DB();
 if(isset($_POST['add_item']) ){
 //validation to check if all form values are correct

   $db->addProduct($_POST['id'],$_POST['name'],$_POST['description'],$_POST['price'],$_POST['quantity'],$_POST['salesPrice'],$_POST['image']);
 }
 
 if(isset($_POST['update_prod']) ){
  if($_POST['image']==null){
 $img=$_POST['img'];
}
else{
$img=$_POST['image'];
}
  $db->adminUpdateProduct($_POST['id'],$_POST['name'],$_POST['description'],$_POST['price'],$_POST['quantity'],$_POST['salesPrice'],$img);
 }
 
 
function PopulateForm(){
 $db=new DB();
 $id=null;
 if(isset($_POST['productName']) ){
 $db=new DB();
 $id= $_POST['productName'];

  echo $db->getProductParameterized($id);


 }


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
	
									<li ><a href="cart.php">Cart</a></li>
									<li class="current"><a href="admin.php">Admin</a></li>
								</ul>
							</nav>
   
</div>
	<div id="main-wrapper">
		<div id="page-wrapper">                   		


                       
                       <?php echo $db->getAllProductsAsDropdown();		
                          
PopulateForm();

        include('ProductForm.html');             
?>
 
						
			<!-- Main -->
      		

      	</div>
       	</div>
		

	

	</body>
</html>

<?php

   include('footer.html');
?>