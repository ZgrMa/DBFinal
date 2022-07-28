<!-- This file loads and displays the correct answers and point values for any selected exam that has been taken -->
<html>
	<body> <center>

<?php

session_start();


if($_SESSION['loggedin'] && isset($_POST['examname']) && isset($_POST['questionnumber']))
{

try {   
        $config = parse_ini_file("finalDB.ini");
        $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $username = $_SESSION['username'];
        $getID = $dbh->query("Select id from student_account where username = '$username'");
        $user = $getID->fetch(PDO::FETCH_NUM);
        $id = $user[0];
		
		//Each specific exam and its questions all have a point value display following the format of correct|total
        $examname = $_POST['examname'];
        $qnum = (int) $_POST['questionnumber'];
        $getScore = $dbh->query("Select total_score from grade_exam where exam_name = '$examname' and id = '$id'");
        $examScore = $getScore->fetch(PDO::FETCH_NUM);
        $score = $examScore[0];
        $getTotalPoints = $dbh->query("Select total_points from exam where exam_name = '$examname'");
        $examTotal = $getTotalPoints->fetch(PDO::FETCH_NUM);
        $totalpoints = $examTotal[0];
        
        echo "<table border='1'>";
        echo "<TR>";
        echo "<TH>Exam</TH>";
        echo "<TH>Score</TH>";
        echo "<TH>Points Possible</TH>";
        echo "</TR>";

        echo "<TR>";
        echo "<TH>".$examname."</TH>";
        echo "<TH>".$score."</TH>";
        echo "<TH>".$totalpoints."</TH>";
        echo "</TR>";

        echo "<TR>";
        echo "<TH>Question #</TH>";
        echo "<TH>Your Answer</TH>";
        echo "<TH>correct Answer</TH>";
        echo "<TH>Score</TH>";
        echo "<TH>Points Possible</TH>";
        echo "</TR>";

        //a simple table is generated to keep the data orderly and easy to interpret
        foreach($dbh->query("Select question.question_number, grade_question.student_choice, question.answer_identifier, grade_question.points, question.point_value from grade_question left join question on question.question_number = grade_question.question_number and question.exam_name = grade_question.exam_name where grade_question.exam_name = '$examname' and grade_question.id = '$id'") as $row) {
                echo "<TR>";
                echo "<TD>".$row[0]."</TD>";
                echo "<TD>".$row[1]."</TD>";
                echo "<TD>".$row[2]."</TD>";
                echo "<TD>".$row[3]."</TD>";
                echo "<TD>".$row[4]."</TD>";
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

