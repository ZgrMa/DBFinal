<!-- This file is used to access each set of answers-->
<html>

<h1><center> Choose Your Exam </h1></center>
<body> <center>
<?php

session_start();

if($_SESSION['loggedin'])
{

try {
        $config = parse_ini_file("finalDB.ini");
        $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $username = $_SESSION['username'];
        $getID = $dbh->query("Select id from student_account where username = '$username'");
        $user = $getID->fetch(PDO::FETCH_NUM);
        $id = $user[0];

        echo "<table border='1'>";
        echo "<TR>";
        echo "<TH> name </TH>";
        echo "<TH> points </TH>";
        echo "</TR>";

		//a simple table is generated with every exam that has been taken
        foreach($dbh->query("Select exam_name, total_points from exam where exam_name in (Select exam_name from grade_exam where id = '$id')") as $row) {
                echo "<TR>";
                echo '<form method="post" action="answers.php">';
                echo "<TD>".$row[0]."</TD>";
                echo "<TD>".$row[1]."</TD>";
                echo '<TD> <input type="submit" name="view" value="View"> </TD>';
                echo '<input type="hidden" name="examname" value="'.$row[0].'">';
                echo '<input type="hidden" name="questionnumber" value="1">';
                echo '</form>';
                echo "</TR>";
        }

        echo "</table>";

} catch (PDOException $e) {
        print "Error! ".$e->getMessage()."<br/>";
        die();
}
}

?>
			<a href=https://classdb.it.mtu.edu/~mszguric/landingPage.php> Return Home </a>
		</body> </center>


<style>
body {background-color: cornsilk;}
form {text-align: center;}
</style>
</html>