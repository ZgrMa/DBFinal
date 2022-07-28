<!-- Student's landing page to pick from between taking the exam or viewing the results -->
</html>
<?php

session_start();

if($_SESSION["loggedin"]){	

	try{

?>

		<!-- a simple landing page with hyperlinks to the exam, answers, and password changer-->
		<h2><center> Welcome! What would you like to do?</center></h2>
		<body> <center>
			<a href=https://classdb.it.mtu.edu/~mszguric/examPage.php> Take Exam</a>
			| 
			<a href=https://classdb.it.mtu.edu/~mszguric/resultsPage.php> View Results</a>
			| 
			<a href=https://classdb.it.mtu.edu/~mszguric/editPass.php> Change Password</a>
			|
			<a href=https://classdb.it.mtu.edu/~mszguric/finalLogin.php> Logout </a>
		</body> </center>

		<h4><center>If you are a first time user, you are advised to change your password. Once an exam has been completed, check your results in View Results.</center></h4> 
<?php
	} catch (PDOException $e) {
		print "Error.". $e -> getMessage()."<br/>";
		die();
	}
} else {
	echo "You should not be here. Login first.";
}

?>

<style>
	body {background-color: cornsilk;}
	form {text-align: center;}
</style>
</html>
