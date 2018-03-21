<?php
 	if(empty($_SESSION['loggedIn']) ){
echo "<span style='color: seashell;'><a href='Login.php'>Login </a></span><span style='color: seashell; float:right'><a href='Registration.php'> Register </a></span>";
}
else{
echo "<p style='color: white;'>Hello " .$_SESSION['UserID'].   "   <a href='Logout.php'>Logout</a></h2></p>";
}
?>