<!-- This file is the backend of the password changing process. Prompts the user to log back in -->
<?php

session_start();

try{
	
	$config = parse_ini_file("finalDB.ini");
	$dbh = new PDO($config['dsn'], $config['username'], $config['password']);
	
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	//Loads the student's old username and password, replacing the old password with the new input from the previous page (editPass)
	$statement = $dbh->prepare(" update student_account set Password=:password where Username=:username");
	
	$result = $statement->execute(array(':password'=> $_POST['password'], ':username' => $_SESSION['username']));
	
} catch (PDOException $e){
	print "Error!". $e -> getMessage(). "<br/>";
	die();
}
?>
<html>
	<body><center> Password change complete.
		<a href=https://classdb.it.mtu.edu/~mszguric/finalLogin.php> Log in again here. </a>
	</body></center>
<style>
	body {background-color: cornsilk;}
	form {text-align: center;}
</style>
</html>
