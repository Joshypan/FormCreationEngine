<?php
	session_start();
	$s_id = $_POST["s_id"];
	
    $db = mysqli_connect("localhost:3306", "root", "","isp");
	$er = mysqli_select_db($db,"isp");

?>
<html>
<head>
	<?php
		
		$sql_info = mysqli_query($db,"SELECT survey_name FROM surveys WHERE survey_id=$s_id");

		$title = mysqli_fetch_array($sql_info);

		$title = $title[0];

		print("<title>$title</title>")



	?>
 	<style>
        h1, h2 {
            text-align: center;
        }
		p {
			color: #fff;
		}
        body, html {
            width: 100%;
            height: 100%;
            overflow: hidden;
			color: #fff;
			text-align: center;
			font-family: 'Roboto', sans-serif;
        }

        body {
            background-image: linear-gradient(to right, #2c3531, #116466 400px, #181e1b);
            background-size: center;
            background-position: center;
            background-repeat: no-repeat;
        }

        .help {
            width: 100vw;
            text-align: center;
        }

        a {
            color: bisque;
        }

        a:hover {
            background-color: black;
        }
    </style>    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
<form action="resultTabulator.php" method="post">
<?php
	$sql_info = mysqli_query($db,"SELECT * FROM questions WHERE question_surveyid=$s_id");

	if(!$sql_info){
		print("Something has gone wrong"); 
	}
	else{

	$num_questions = mysqli_num_rows($sql_info);

	$question = mysqli_fetch_array($sql_info);

	print("<input type='hidden' value='$num_questions' name='num_q'>");
	print("<input type='hidden' value='$s_id' name ='s_id'>");

	print("<h1>$title</h1>");

	
	if($num_questions == 0){
		print("<p>This survey has no questions</p>");
	}

	for($question_number = 0; $question_number < $num_questions; $question_number++){
		$q_type = $question[2];
		// valid types: MC, CB, ER, D, T
		$q_title = $question[3];
		print("<h2>$q_title</h2>");

		if($q_type == "MC"){		// answers
			$q_param = $question[4];
			$answers = explode('`',$q_param);
			foreach($answers as $answer){
				print("<input type='radio' value='$answer' name='q$question_number'/>$answer<br>");
			}
			
		}
		else if($q_type == "CB"){	// answers
			$q_param = $question[4];
			$answers = explode('`',$q_param);
			foreach($answers as $answer){
				print("<input type='checkbox' value='$answer' name='q$question_number" . "[]'/>$answer<br>");
			}

		}
		else if($q_type ==  "ER"){	// blank
			print("<input type='text' name='q$question_number'/><br>");

		}
		else if($q_type == "D"){	// blank
			print("<input type='date' name='q$question_number'/><br>");
		}
		else if($q_type == "T"){	// blank
			print("<input type='time' name='q$question_number'/><br>");
		}
		$question = mysqli_fetch_array($sql_info);
	}

	print("<br><input type='submit' value='Submit'></input><br>");

	}
?>
</form>
<a href="home.php">Go back to home</a>

</body>
</html>

