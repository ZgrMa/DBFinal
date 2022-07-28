<html>
<?php


include_once('google-api-php-client-2.4.1/vendor/autoload.php');

//We use Google APIs for authentication
session_start();
$client = new Google_Client();
$client->setAuthConfig('client_credentials.json');
$client->addScope(Google_Service_Drive::DRIVE);
$client->setRedirectUri("https://classdb.it.mtu.edu/~mszguric/finalLogin.php");

//Load db
$config = parse_ini_file("finalDB.ini");
$dbh = new PDO($config['dsn'], $config['username'], $config['password']);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Once logged in, store credentials as POST variables to make access easier
if (isset($_POST["login"])){
        $username=$_POST['username'];
        $password=$_POST['password'];
        $sql= $dbh->query("Select username from student_account where username = '$username' and password = '$password'");
        $result = $sql->fetch(PDO::FETCH_NUM);
		
//It will say it is invalid if the user has not been created yet
	if($result[0] != $username){
		echo "Invalid username and/or password";
	} else {
        echo "Redirecting you now...";
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;
        header("Location: https://classdb.it.mtu.edu/~mszguric/landingPage.php");
	}
}

?>
<!-- Login form -->
<form method="post" action="finalLogin.php">
	username: <input type="text" name="username">
	<br>
	password: <input type="password" name="password">
	<br>
	<input type="submit" name="login" value="login">
</form>
<style>
	body {background-color: cornsilk;}
	form {text-align: center;}
</style>
</html>
