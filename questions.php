<!-- This file is used to populate the questions portion of each exam-->
<html>
<?php

session_start();

if($_SESSION['loggedin'] && isset($_POST['examname']) && isset($_POST['questionnumber']))
{

        try{
                $config = parse_ini_file("finalDB.ini");
                $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
                $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				
				//Maintains sessions, stores answers based on user
                $username = $_SESSION['username'];
                $getID = $dbh->query("Select id from student_account where username = '$username'");
                $user = $getID->fetch(PDO::FETCH_NUM);
                $id = $user[0];

                $examname = $_POST['examname'];
                $qnum = (int) $_POST['questionnumber'];

                $getText = $dbh->query("Select question_text from question where exam_name = '$examname' and question_number = $qnum");
                $entry = $getText->fetch(PDO::FETCH_NUM);
                $qtext = $entry[0];

                if(isset($_POST['answer'])) {
                        $answer = $_POST['answer'];
                        $oldquestion = $qnum - 1;
						//auto_grade is a special function Shirley made that does as the name suggests. Great function. 
                        $grade = $dbh->prepare("call auto_grade(?, ?, ?, ?)"); 
                        $grade->bindParam(1, $id, PDO::PARAM_STR);
                        $grade->bindParam(2, $examname, PDO::PARAM_STR);
                        $grade->bindParam(3, $oldquestion, PDO::PARAM_INT);
                        $grade->bindParam(4, $answer, PDO::PARAM_STR);
                        $grade->execute();

                        $wasLast = $dbh->query("Select question_number from question where question_number = '$qnum' and exam_name = '$examname'");
                        $result = $wasLast->fetch(PDO::FETCH_NUM);
                        if($result[0] != $qnum) {
                                header("Location: https://classdb.it.mtu.edu/~mszguric/landingPage.php");
                        }
                }

                echo "<h1><center> ".$examname." </h1></center>";
                echo "<h1> Question ".$qnum." </h1>";
                echo "<h1> ".$qtext." </h1>";

                $nextq = $qnum + 1;

		echo "<table border='1'>";
				//generates and populates the set of questions in each exam
                foreach($dbh->query("Select choice_text, choice_identifier from choice where question_number = '$qnum' and exam_name = '$examname'") as $row) {
                        echo "<TR>";
                        echo '<form method="post" action="questions.php">';
                        echo "<TD>".$row[0]."</TD>";
                        echo '<TD> <input type="submit" name="answer" value="'.$row[1].'"> </TD>';
                        echo '<input type="hidden" name="examname" value="'.$examname.'">';
                        echo '<input type="hidden" name="questionnumber" value="'.$nextq.'">';
                        echo '</form>';
                        echo "</TR>";
                }


        }catch (PDOException $e){
                print "Error:" . $e -> getMessage()."<br/>";
                die();
        }
}

?>

<style>
body {background-color: cornsilk;}
form {text-align: center;}
</style>
</html>
