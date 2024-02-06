<html>
<head>
    <style>
        h1, h2 {
            text-align: center;
            font-size: 40px;
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
    </style>    
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<?php
// start the session
session_start();

if(!isset($_SESSION["user_id"]) or !isset($_POST["s_id"])) {
    // if user_id cookie is not set, send user back to login screen
    print('<meta http-equiv="refresh" content="0; URL=login.html" />');
}
    $user_id = $_SESSION["user_id"]; // get user ID

    $surveyid = $_POST["s_id"]; //get survey ID

    $db = mysqli_connect("localhost:3306", "root", "","isp");


    $results = mysqli_query($db, 
        "SELECT `question_number` FROM `questions` 
        WHERE question_surveyid = $surveyid;"
        );

    $num_questions = mysqli_num_rows($results);

    $results = mysqli_query($db, 
    "SELECT `survey_name` FROM `surveys` 
    WHERE survey_id = $surveyid;"
    );
    $data_array = mysqli_fetch_array($results);
    echo("<u><b><h2>");
    echo($data_array[0]);
    echo(" Results");
    echo("</h2></b></u>");

    for($i = 1; $i<$num_questions + 1;$i++)
    {
        //get question
        $results = mysqli_query($db, 
        "SELECT `question_name` FROM `questions` 
        WHERE question_surveyid = $surveyid and question_number = $i"
        );

        $data_array = mysqli_fetch_array($results);
        
        echo("<h3>$i: $data_array[0] </h3>");

        //get all answers
        $results1 = mysqli_query($db, 
        "SELECT `result_answer` FROM `results` 
        WHERE result_survey = $surveyid and result_question = $i"
        );

        foreach ($results1 as $row) {
            echo($row["result_answer"]);
            echo("<br>");
        }

    }
?>
</html>