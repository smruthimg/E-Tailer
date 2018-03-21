<?php
	session_name("sg1626");//name of the cookie
	session_start();
	
	require_once("DB.class.php");
 require_once("LIB_project1.php");
include('main.html');
//varibale to store error message
$Message = '';
//varibale to store warnings
$warnings = '';
//new DB instance

 if(isset($_POST['Register'])){
$db=new DB();
$data=validateRegField();

 $Message = showError($_SESSION['error']);
 $warnings = showWarnings();
 //add new user
if (empty($Message)){
$db->registerUser($_POST['UserID'],$_POST['FirstName'],$_POST['LastName'],'Cust',$_POST['Password']);
 header('Location:index.php');
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
<div id="page-wrapper"><?php if (!empty($Message)) {
    echo "<div class='container' style='color:red'><em>Errors:</em><p>" . $Message . "</p></div>";
}
if (!empty($warnings)) {
    echo "<div class='container' style='color:red'><em>Warnings:</em>" . $warnings . "</div>";
}
?>
</div>
<div class="row">
<form method="post">
<table>
<tr>
<td>UserID:</td>
<td><input name="UserID" type="text" style="size:10" value=""></td>
</tr>
<tr>
<td>First Name:</td>
<td><input name="FirstName" type="text" style="size:10" value=""></td>
</tr>
<tr>
<td>Last Name:</td>
<td><input name="LastName" type="text" style="size:10" value=""></td>
</tr>
<tr>
<td>Password:</td>
<td><input name="Password" type="password" size=10 value=""></td>
</tr>
<tr>
<td></td>
<td><input name="Register" type="submit" value="Register"></td>
</tr>
</form>
    
       	</div>
       	</div>

	</body>
</html>
