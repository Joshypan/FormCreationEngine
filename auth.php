<?php
    // start the session
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUTHORIZATION</title>
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-image: linear-gradient(to right, #2c3531, #116466 400px, #181e1b);
            background-size: cover;
            color: white;
        }

        h1 {
            font-size: 50px;
            margin-bottom: 10px;
        }

        h2 {
            font-size: 20px;
            text-align: center;
        }

        .loading-spinner {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 4px solid #fff;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Loading...</h1>
        <div class="loading-spinner"></div>
        <h2>You will be redirected shortly.</h2>
    </div>
    <?php

    $username = $_POST["user"];
    $password = $_POST["password"];
    

    $db = mysqli_connect("localhost:3306", "root", "","isp");
	$er = mysqli_select_db($db,"isp");

    $query = "Select * from users where user_login = '";
    $query = $query . $username;
    $query = $query . "'";

    $sql_info = mysqli_query($db,$query);


    //var_dump($query);
    //var_dump($sql_info); 

    $data_array = mysqli_fetch_array($sql_info);

    //var_dump($data_array);
    if($data_array != NULL){
        $user_id = $data_array[0];
        $passkey = $data_array[2];
    }else{
        $user_id = 0;
        $passkey = "";
    }


    //var_dump($user_id);
    //var_dump($passkey);

    if($password == $passkey){
        // set session variable    
        $_SESSION["user_id"] = $user_id;
        // have direct to main page
        print('<meta http-equiv="refresh" content="1; URL=home.php" />');
    }
    else{
        // directs back to login page
        print('<meta http-equiv="refresh" content="1; URL=login.html" />');
    }

?>
</head>
<body>
You will be redirected shortly.
</body>
</html>