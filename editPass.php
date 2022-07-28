<!-- This file lets a student input a new password that they would like -->
<html>
	<body>
<?php

session_start();
if (!$_SESSION["loggedin"]){
    header("LOCATION: finalLogin.php");
    return;
}

?>

<form method ="post" action="changePass.php">
	New password: <input type="password" name="password">
	</br>
	<input type='submit' password='Change' value='Submit'>
</form>
   

</body>
<style>
	body {background-color: cornsilk;}
	form {text-align: center;}
</style>
</html>
