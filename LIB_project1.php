<?php

	require_once("DB.class.php");
 //Desc:Function to get all the items on sale
 //input:None
 //output:None
 function getTotalSaleItems(){
 
  $db=new DB();
  $data=$db->getAllSaleProducts();
  return count($data);
  
  }
  
  //Desc:Function to validate userid and password
 //input:user id and password
 //output:boolean
  function ValidateUser($userId,$password){
   $db=new DB();
 
   $data=$db->checkValidUser($userId,$password);

  if( $data==0){
 return false;
  
die();
  }
  return true;
  }
  
  //Desc:Function to sanitize values from form
 //input:array of form values
 //output:sanitized array
function test_input($data) {

  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//Desc:Function to get values to validate Registration form values
 //input:None
 //output:None
function validateRegField(){
$UserID = $FirstName= $LasttName = $Password =  "";
$errlog=array();
$data=array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $data['UserID'] = test_input($_POST["UserID"]);
 // echo $fname;
  $data['FirstName'] = test_input($_POST["FirstName"]);
 // echo $lname;
  $data['LasttName'] = test_input($_POST["LastName"]);
 // echo $date;
    $data['Password']= test_input($_POST["Password"]);

  
}

  $err=getRegErrors($data['UserID'], $data['FirstName'] , $data['LasttName'] ,$data['Password']  ,$errlog );
  $_SESSION['error']=$err;
  return $data;
}

//Desc:Function to validate registration form
 //input:Form values from POST
 //output:array of error messages
function getRegErrors($UserID , $FirstName, $LasttName , $Password ,$errlog ){
//echo $UserID , $FirstName, $LasttName , $Password;
$Warning='';
	
	if(empty($UserID)){
		$errlog[]="UserID is empty";
	}
	if(empty($FirstName)){
		$errlog[]="FirstName is empty";
	}
	if(empty($LasttName)){
		$errlog[]="LasttName is empty";
	} 

	if(empty($Password)){
		$errlog[]="Password is empty";
	}
	$_SESSION['warnings']=$Warning;
	return $errlog;
}


//Desc:Function to get all the form values from $_POST 
 //input:None
 //output:array of error messages
function validateProdField(){

$errlog=array();
$data=array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
if(isset($_POST["id"])){
 $data['id']=test_input($_POST["id"]);
 }
  $data['ProductName']=test_input($_POST["name"]);

  $data['Desc']=test_input($_POST["description"]);

  $data['Price']=test_input($_POST["price"]);
  $data['QTY']= test_input($_POST["quantity"]);
 $data['SalePrice']= test_input($_POST["salesPrice"]);
  $data['Image']= "Uploads/".test_input($_FILES['image']['name']);
   $data['Password']= test_input($_POST["password"]);

  
}

  $err=getErrors( $data['ProductName'], $data['Desc'] , $data['Price'] ,$data['QTY'], $data['SalePrice'],$data['Image'],$data['Password']  ,$errlog );
  $_SESSION['error']=$err;
  return $data;

}

//Desc:Function to validate the form fields from admin page to edit/add product
 //input:form  values
 //output:array of errors
function getErrors( $ProductName, $Desc , $Price ,$QTY, $SalePrice,$Image,$Password ,$errlog){
$Warning='';
	
	if(empty($ProductName)){
		$errlog[]="ProductName is empty";
	}
	if(empty($Desc)){
		$errlog[]="Desc is empty";
	}
	if(empty($Price)){
		$errlog[]="Price is 0";
	}
 else if(!is_numeric($Price) ){
 $errlog[]=" Price is not a number" ;
 }
	if(empty($QTY) || $QTY<=0){
	$Warning.="QTY is 0. Product will be made unavailable";
	}
 else if(!is_numeric($QTY) ){
 $errlog[]=" QTY is not a number" ;
 }

 
	if(empty($SalePrice)){
		$Warning.="<p>SalePrice is set to 0 for ".$ProductName."</p>";
	}
 else if(!is_numeric($SalePrice) ){
 $errlog[]=" SalePrice is not a number" ;
 }
  if(empty($Image) || $Image=='' ){

  if( isset($_POST['img'])){
		$Warning.="<p>Existing image will be used</p>" ;
   }else{
   $Warning.=" No image will be loaded. Image can be added with Edit option later" ;
   }
	}
	if(empty($Password)){
		$errlog[]="Password is not provided";
	}
	$_SESSION['warnings']=$Warning;
	return $errlog;
	
	
}

//Desc:Function to display error
 //input:array of errors
 //output:HTML paragraph tag with error message embedded 
function showError($errLog){

if(!empty($errLog)){

foreach ($errLog as $v){

  return "<p>".$v."</p>";

}
}
}

//Desc:Function to display warnings
 //input:None
 //output:HTML paragraph tag with warnings embedded 
function showWarnings(){

  return "<p>".$_SESSION['warnings']."</p>";


}

//Desc:Function to move upoaded file to server
 //input:None
 //output:None

function moveFile(){
       $target = "Uploads/";
$target = $target . basename( $_FILES['image']['name']); 
$pic=($_FILES['image']['name']); 
       if(move_uploaded_file($_FILES['image']['tmp_name'], $target)) 
{ 
    
    $_SESSION['warnings'].= "The file  has been uploaded"; 
} 
else 
{ 
    //Gives and error if its not 
    $_SESSION['warnings'].= "Sorry, there was a problem uploading your file."; 
} 
  

}

?>