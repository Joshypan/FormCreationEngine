<?php
function createSurveyEntry($name,$user_id){
	$db = mysqli_connect("localhost:3306", "root", "","isp");
	$er = mysqli_select_db($db,"isp");

	$query = "INSERT INTO surveys VALUE (NULL," . $user_id . ",'" . $name . "');";

	$sql_info = mysqli_query($db,$query);

	$query = "SELECT survey_id FROM surveys WHERE survey_name='" . $name . "' AND survey_owner=" . $user_id;
	
	$sql_info = mysqli_query($db,$query);

    $data_array = mysqli_fetch_array($sql_info);

	return $data_array[0];


}
?>