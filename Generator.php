<html>
<head>
    <!--<meta http-equiv="refresh" content="1; URL=home.php" />-->
    <title>Survey Generator</title>
    <link rel="stylesheet" href="GeneratorStyles.css">
    <script src="Generatoranimation.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<?php
// start the session
session_start();

if(!isset($_SESSION["user_id"])) {
    // if user_id cookie is not set, send user back to login screen
    print('<meta http-equiv="refresh" content="0; URL=login.html" />');
}
    

    $user_id = $_SESSION["user_id"];

    include 'createSurveyEntry.php';
?>


<body onload=setFormInputs()>
<h1>Survey Generator</h1>

<?php

//$myfile = fopen("test.php", "w") or die("Unable to open file!"); //CREATE NEW PHP FILE
//fwrite($myfile,"<body><input type='button'></body>");  //WRITE TO PHP FILE

//unlink(realpath("test.php")); REMOVE A PHP FILE

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['questions']))
{
    $db = mysqli_connect("localhost:3306", "root", "","isp");
    $que = $_POST["questions"];
    $title = $_POST["maintitle"];
    $que_arr = explode("|", $que);


    $count = $type = $name = $data = "";


    //CREATE NEW ENTRY IN SURVEYS TABLE  - GET SURVEY ID TO ADD TO QUESTIONS TABLE

    $surveyid  = createSurveyEntry($title,$user_id);


    for ($i = 0; $i < count($que_arr)/4; $i++) {
        $count = $que_arr[4*$i];
        $type = $que_arr[4*$i + 1];
        $name = $que_arr[4*$i + 2];
        $data = $que_arr[4*$i + 3];

        mysqli_query($db, 
        "INSERT INTO questions(question_number, question_type, question_name, question_parameters, question_surveyid)
        VALUES ('$count','$type' ,'$name' ,'$data', '$surveyid')"
        );
    }

    print('<meta http-equiv="refresh" content="0; URL=home.php" />');
}
?>
<h3>Enter Survey Name:</h3> <input type="text" placeholder="Survey Name" id=sTitle> <button onclick="updateOfficialTitle()">Update</button>
<div class="flex-container">
    <div class="half-width">
        <input type="button" value="Multiple Choice" onclick="popup(event)" id="MPbutton">
        <br>
            <div id="MPpanel" class="panel">
                <div class="flex-container">
                    <div>
                        <label>Name of Question:</label>
                        <input type="text" placeholder="Question Name" id="MPtitle">
                        <button onclick="updateTitle(event)" id="MPtitleButton">Set</button>
                        <br>
                        <label>Add option:</label>
                        <input type="text" placeholder="Option" id="MPoption">
                        <button onclick="updateMPDemo(event)">Add</button>
                    </div>
                    <div>
                        <label>Sample</label>
                        <hr>
                        <u><label id="MPTitleContainer">Default Question</label></u>
                        <div id="MPcontainer">
                        </div>
                    </div>
                </div>
                <button onclick=submitToTable(event) id="MPsubmit">ADD QUESTION</button>
            </div>
        <input type="button" value="Check list" onclick="popup(event)" id="CLbutton">
        <br>
            <div id="CLpanel" class="panel">
                
    
                <div class="flex-container">
                    <div>
                        <label>Name of Question:</label>
                        <input type="text" placeholder="Question Name" id="CLtitle">
                        <button onclick="updateTitle(event)" id="CLtitleButton">Set</button>
                        <br>
                        <label>Add option:</label>
                        <input type="text" placeholder="Option" id="CLoption">
                        <button onclick="updateCLDemo(event)">Add</button>
                    </div>
                    <div>
                        <label>Sample</label>
                        <hr>
                        <u><label id="CLTitleContainer">Default Question</label></u>
                        <div id="CLcontainer">
                        </div>
                    </div>
                </div>
                <button onclick=submitToTable(event) id="CLsubmit">ADD QUESTION</button>
            </div>



        <input type="button" value="Extended Response" onclick="popup(event)" id="ERbutton">
        <br>
            <div id="ERpanel" class="panel">
                
    
                <div class="flex-container">
                    <div>
                        <label>Name of Question:</label>
                        <input type="text" placeholder="Question Name" id="ERtitle">
                        <button onclick="updateTitle(event)" id="ERtitleButton">Set</button>
                    </div>
                    <div>
                        <label>Sample</label>
                        <hr>
                        <u><label id="ERTitleContainer">Default Question</label></u>
                        <br>
                        <input type="text">
                    </div>
                </div>
                <button onclick=submitToTable(event) id="ERsubmit">ADD QUESTION</button>
            </div>

        <input type="button" value="Date" onclick="popup(event)" id="DTbutton">
        <br>
            <div id="DTpanel" class="panel">
                    
        
                    <div class="flex-container">
                        <div>
                            <label>Name of Question:</label>
                            <input type="text" placeholder="Question Name" id="DTtitle">
                            <button onclick="updateTitle(event)" id="DTtitleButton">Set</button>
                        </div>
                        <div>
                            <label>Sample</label>
                            <hr>
                            <u><label id="DTTitleContainer">Default Question</label></u>
                            <br>
                            <input type="date">
                            
                        </div>
                    </div>
                    <button onclick=submitToTable(event) id="DTsubmit">ADD QUESTION</button>
            </div>

        
        <input type="button" value="Time" onclick="popup(event)" id="Tbutton">
        <br>
            <div id="Tpanel" class="panel">
                    
        
                    <div class="flex-container">
                        <div>
                            <label>Name of Question:</label>
                            <input type="text" placeholder="Question Name" id="Ttitle">
                            <button onclick="updateTitle(event)" id="TtitleButton">Set</button>
                        </div>
                        <div>
                            <label>Sample</label>
                            <hr>
                            <u><label id="TTitleContainer">Default Question</label></u>
                            <br>
                            <input type="time">
                            
                        </div>
                    </div>
                    <button onclick=submitToTable(event) id="Tsubmit">ADD QUESTION</button>
            </div>



    </div>
    <div class="half-width">
        <table id="surveyTable">
            <tr>
                <td>Question number</td>
                <td>Question type</td>
                <td>Question name</td>
                <td>Question details</td>
            </tr>
        </table>
    </div>

    
    
</div>
<br><br><br><br>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" onsubmit="return fillFormInputs()" id="myForm">
        <input class = "generate" type="submit" value="Generate Page" name="gen" >
        <!-- Add each question as an input delimited like: 'questionnumber'/'questiontype'/'data'  
    iterate through this post data in php-->
    </form>
</body>
</html>