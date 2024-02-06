<?php
    // starts session
    session_start();
?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <title>CSV Converter</title>
    <link rel="stylesheet" href="converterStyles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>CSV File Upload</h1>
        <h2>If you have a .csv file or a .txt file, you can use it to generate your survey. You can select "Preview" to see a preview of your file. Select "Upload" to create your survey.
            <br><a href="help.html">Refer to our help page for more info!</a><br>
            <br>Thanks for using Form Creation Engine</h2>
        <form action="uploadFile.php" method="post" enctype="multipart/form-data" id="uploadForm">
            <label for="name">Survey Name:</label>
            <input type="text" id="name" name="survey_name" required>

            <div id="dropArea">
                <label for="myFile" class="fileLabel">Click Here To Insert A File</label>
                <input type="file" id="myFile" name="uploadedFile" class="fileInput" accept=".csv, .txt" required onchange="displaySelectedFile()">
                <br><span id="selectedFileName">No file selected</span>
            </div>

            <div id="filePreview" style="display: none;">
                <h3>File Preview:</h3>
                <pre id="previewContent"></pre>
            </div>

            <input class="submitButton" type="button" value="Preview" onclick="previewFile()">
            <input class="submitButton" type="submit" value="Upload">
        </form>
    </div>

    <script>
        function previewFile() {
            var fileInput = document.getElementById('myFile');

            if (window.File && window.FileReader && window.FileList && window.Blob) {
                if (fileInput.files.length > 0) {
                    var file = fileInput.files[0];
                    if (['text/csv', 'text/plain'].includes(file.type)) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            document.getElementById('filePreview').style.display = 'block';
                            document.getElementById('previewContent').textContent = e.target.result;
                        };
                        reader.readAsText(file);
                    } else {
                        alert('Invalid file type. Please upload a .csv or .txt file.');
                    }
                } else {
                    alert('Please select a file to preview.');
                }
            } else {
                alert('File API is not supported in this browser.');
            }
        }
        function displaySelectedFile() {
            var fileInput = document.getElementById('myFile');
            var selectedFileName = document.getElementById('selectedFileName');

            if (window.File && window.FileReader && window.FileList && window.Blob) {
                if (fileInput.files.length > 0) {
                    selectedFileName.textContent = 'Selected File: ' + fileInput.files[0].name;
                } else {
                    selectedFileName.textContent = 'No file selected';
                }
            } else {
                alert('File API is not supported in this browser.');
            }
        }
        document.addEventListener('DOMContentLoaded', function () {
            displaySelectedFile();
        });
    </script>
</body>

</html>
