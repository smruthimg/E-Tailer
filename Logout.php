<?php
	session_name("sg1626");//name of the cookie
	session_start();
	
	require_once("DB.class.php");
 require_once("LIB_project1.php");
include('main.html');
session_unset();
 	session_destroy();
  header("Location:Login.php");

  ?>