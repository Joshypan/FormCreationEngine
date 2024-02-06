<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="1; URL=home.php" />
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
    // start the session
    session_start();
    
    $db = mysqli_connect("localhost:3306", "root", "","isp");

    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (isset($_FILES['uploadedFile']) && isset($_POST['survey_name'])) {
        $file = $_FILES['uploadedFile'];

        // file props
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];
        $targetDir = 'uploads/';

        // file ext
        $file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext));

        $allowed = array('txt', 'csv');

        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // move to "upload/" (serverside)
        if (in_array($file_ext, $allowed)) {
            if ($file_error === 0) {
                if ($file_size < 2097152) {
                    $file_name_new = uniqid('', true) . '.' . $file_ext;
                    $file_destination = 'uploads/' . $file_name_new;

                    if (move_uploaded_file($file_tmp, $file_destination)) {
                        // get user id from session.
                        $user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;

                        if (!$user_id) {
                            // if user_id session is not set, send user back to login screen
                            print('<meta http-equiv="refresh" content="0; URL=login.html" />');
                        } else {
                            // get survey name from the form
                            $survey_name = $_POST['survey_name'];

                            // Insert survey and get survey_id
                            $survey_id = createSurveyEntry($survey_name, $user_id, $db);

                            $csvData = array_map('str_getcsv', file($file_destination));
                            // Assuming CSV structure is consistent
                            $firstRowSkipped = false;
                            foreach ($csvData as $row) {
                                // Skip the first row (headers)
                                if (!$firstRowSkipped) {
                                    $firstRowSkipped = true;
                                    continue;
                                }

                                $count = $row[0];
                                $type = $row[1];
                                $name = $row[2];
                                $data = $row[3];

                                $sql = "INSERT INTO questions(question_surveyid, question_number, question_type, question_name, question_parameters)
                                        VALUES ('$survey_id', '$count', '$type', '$name', '$data')";

                                $result = $db->query($sql);

                                if (!$result) {
                                    // handle query error
                                    die("Query failed: " . mysqli_error($db));
                                }
                            }

                            echo "Your file has been uploaded successfully!";
                        }
                    }
                }
            }
        }
    }

    $db->close();

    function createSurveyEntry($name, $user_id, $db)
    {
        $query = "INSERT INTO surveys (survey_owner, survey_name) VALUES ('$user_id', '$name')";
        $sql_info = mysqli_query($db, $query);

        if (!$sql_info) {
            // handle query error
            die("Query failed: " . mysqli_error($db));
        }

        $query = "SELECT survey_id FROM surveys WHERE survey_name='$name' AND survey_owner='$user_id'";
        $sql_info = mysqli_query($db, $query);

        if (!$sql_info) {
            // handle query error
            die("Query failed: " . mysqli_error($db));
        }

        $data_array = mysqli_fetch_array($sql_info);
        return $data_array[0];
    }
    ?>
</body>
</html>