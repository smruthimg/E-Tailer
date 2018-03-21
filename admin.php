<?php

session_name("sg1626");//name of the cookie
session_start();
require_once("DB.class.php");
require_once("LIB_project1.php");
include('LoginBar.php');
include('main.html');


//varibale to store error message
$Message = '';
//varibale to store warnings
$warnings = '';
$successMesg='';
//new DB instance
$db = new DB();

if (isset($_SESSION['UserID'])) {
    $userid = $_SESSION['UserID'];
} else {
    $userid = null;
}

//IS postback?
if (isset($_POST['add_item'])) {
    //if(ini_get('file_uploads')){
    // echo 'file_uploads is set to "1". File uploads are allowed.';
    //} else{
    //    echo 'Warning! file_uploads is set to "0". File uploads are NOT allowed.';
    //}
    //validation to check if all form values are correct
    //  echo "POSTED";
    $data = validateProdField();

    $Message = showError($_SESSION['error']);
    $warnings = showWarnings();
    if ((ValidateUser($userid, $data['Password']))) {
  
        if (empty($Message)) {
            $result = $db->addProduct($data['ProductName'], $data['Desc'], $data['Price'], $data['SalePrice'], $data['QTY'], $data['Image']);
            if (isset($_FILES)) {
                moveFile();
            }
            if($result>=1){
            $successMesg='Product Added Successfully';
            }
        }
    } else {
        $Message.= 'Not a valid password';
    }
}
//IS postback?
if (isset($_POST['update_prod'])) {
    $data = validateProdField();
    if (isset($_SESSION['error'])) {
        $Message = showError($_SESSION['error']);
        $warnings = showWarnings();
    }
    if (empty($_POST['image'])) {
        $img = $_POST['img'];
    } else {
        $img = $_POST['image'];
    }
    if (getTotalSaleItems() >= 5 && $_POST['salesPrice'] > 0) {
        $Message = '<p>Sale items count has reached limit. Cannot add more items to sale</p>';
    } else if (getTotalSaleItems() <= 3 && $_POST['salesPrice'] == 0) {
        $Message = '<p>There should be a minimum of 3 items on sale</p>';
    } else {
        //echo $Message[0];
        if ((ValidateUser($userid, $data['Password']))) {
            if (empty($Message)) {
                echo $Message['warning'];
                $result=$db->adminUpdateProduct($data['id'], $data['ProductName'], $data['Desc'], $data['Price'], $data['SalePrice'], $data['QTY'], $img);
                // moveFile();
                if (isset($_FILES)) {
                    moveFile();
                }
                if($result>=1){
            $successMesg='Product Updated Successfully';
            }
            }
        } 
    }
}

//Function to populate the edit product form
function PopulateForm() {
    $db = new DB();
    $id = null;
    if (isset($_POST['productName'])) {
        $db = new DB();
        $id = $_POST['productName'];
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

                       
                       <?php if ($Message != '') {    
                       echo "<div class='container' style='color:red'><em>Errors:</em><p>" . $Message . "</p></div>";}
if ($warnings != '') {
    echo "<div class='container' style='color:orange'><em>Warning:</em>" . $warnings . "</div>";
}
if ($successMesg != '') {
    echo "<div class='container' style='color:green'><em>Success:</em>" . $successMesg  . "</div>";
}
if ($userid == 'admin') {
    echo $db->getAllProductsAsDropdown();
    PopulateForm();
    include ('ProductForm.php');
    
} else {
    echo "<h4>Need to be an Admin to access this page</h4>";
}
?>
 

      		

      	</div>
       	</div>
		

	

	</body>
</html>

<?php
include ('footer.html');
?>