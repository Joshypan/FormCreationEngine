<html>
<head>

        <meta http-equiv="refresh" content="1; URL=login.html" />

</head>
<body>

<?php
// do all the add to database stuff

    $username = $_POST["username"];
    $password = $_POST["password1"];

    $db = mysqli_connect("localhost:3306", "root", "","isp");
	$er = mysqli_select_db($db,"isp");

    $query = "Select * from users where user_login = '";
    $query = $query . $username;
    $query = $query . "'";

    $sql_info = mysqli_query($db,$query);
    
    $data_array = mysqli_fetch_array($sql_info);

    if($data_array != NULL){
        print("Your account has not been created. Another User is already using the username: " . $username . " <br>You will be redirected back to the login screen");
    }
    else{

    $query = "INSERT INTO users VALUE (NULL,'";
    $query = $query . $username . "','" . $password . "');";

    //var_dump($query);

    
    $out = mysqli_query($db,$query);



    print("Your account has been succesfully created <br>You will be redirected back to the login screen");
    
    }

?>




</body>

</html>