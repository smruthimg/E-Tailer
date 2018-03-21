<?php
	session_name("sg1626");//name of the cookie
	session_start();
	
	require_once("DB.class.php");
 require_once("LIB_project1.php");
include('main.html');


 if(isset($_POST['UserID'])){

 if(ValidateUser($_POST['UserID'],$_POST['Password'])){
$_SESSION['loggedIn']=true;
$_SESSION['UserID']=$_POST['UserID'];
 header("Location:index.php");
 exit;
 }else{
 session_unset();
 	session_destroy();
   header("Location:reLogin.php");
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
<div class="row">
<form method="post">
<table>
<tr>
<td>UserID:</td>
<td><input name="UserID" type="text" style="size:10"></td>
</tr>
<tr>
<td>Password:</td>
<td><input name="Password" type="password" size=10></td>
</tr>
<tr>
<td></td>
<td><input name="Login" type="submit" value="Login"></td>
</tr>
</form>
    
       	</div>
       	</div>

	</body>
</html>
