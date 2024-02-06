<html>
<head>
	<title>Thank You!</title>
</head>
<body>
<?php

    $db = mysqli_connect("localhost:3306", "root", "","isp");
	$er = mysqli_select_db($db,"isp");

$total_questions = $_POST["num_q"];
$survey_id = $_POST["s_id"];
$answers = array();


for($question_number = 0; $question_number < $total_questions; $question_number++){
	if(isset($_POST["q$question_number"])){
		$answers[$question_number] = $_POST["q$question_number"];
	}
	else{
		$answers[$question_number] = '';
	}
}

for($question_number = 1; $question_number < $total_questions+1; $question_number++){
	$answer = $answers[$question_number-1];
	if(is_array($answer)){
		$csv_answer = "";
		for($index = 0; $index < count($answer);$index++){
			$csv_answer = $csv_answer . $answer[$index] . ',';
		}
		mysqli_query($db,"INSERT INTO results VALUE (NULL,$survey_id,$question_number,'$csv_answer')");
	}
	else{
		mysqli_query($db,"INSERT INTO results VALUE (NULL,$survey_id,$question_number,'$answer')");
	}

}

print("Thank you for completing the survey<br>");
print("<form action='takeSurvey.php' method='post'><input type='hidden' value='$survey_id' name='s_id'><input value='Submit another result' type='submit'>");


?>
</body>
<a href="home.php">Go back to home</a>
</html>