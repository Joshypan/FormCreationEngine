<?php
	// starts session
	session_start();
?>

<html>
<head>
	<title>Main Page</title>
    <link rel="stylesheet" href="homeStyle.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
	<h1> Welcome To Your Dashboard </h1>
	<?php

	if(!isset($_SESSION["user_id"])) {
		// if user_id cookie is not set, send user back to login screen
		print('<meta http-equiv="refresh" content="0; URL=login.html" />');
	}else{
		// get user id from cookie.
		$user_id = $_SESSION["user_id"];

		// build sql query
		$query = "Select * FROM surveys WHERE survey_owner = " . $user_id;

		// connect to database
		$db = mysqli_connect("localhost:3306", "root", "","isp");
		$er = mysqli_select_db($db,"isp");

		// get survey information
		$sql_info = mysqli_query($db,$query);

		// get number of surveys
		$num_rows = mysqli_num_rows($sql_info);

		print("<table>");
		print("<tr><th>Form Title</th><th>Take Form</th><th>View Results</th></tr>");
		// translate data into array of only users surveys
		for($current_row = 0;$current_row < $num_rows; $current_row++){
			print("<tr>");
			$data_array = mysqli_fetch_array($sql_info);
			print("<th>" . $data_array[2] . "</th>");
			$survey_id = $data_array[0];
			// Print out all information needed for each survey

			// <input type='hidden' value='sid' name='s_id'/>

			print("<th><form action='takeSurvey.php' method='post'><input type='hidden' value='$survey_id' name='s_id'><input type='submit'></form></th>");
			print("<th><form action='results.php' method='post'><input type='hidden' value='$survey_id' name='s_id'><input type='submit' value='Check results'></form></th>");


			print("</tr><tr></tr>");
		}

	} 

	?>

	<tr>
		<th></th>
		<th><a href="generator.php"><button>Generate Survey From Creator</button></a></th>
		<th><a href="fileToDB.php"><button>Generate Survey From File</button></a></th>
	</tr>

	</table>

</body>






</html>