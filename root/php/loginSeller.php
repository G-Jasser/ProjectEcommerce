<?php
// Connect to the database
$json = file_get_contents('../database/cloudDBinfo.json');
$info = json_decode($json, true);
$dbinfo = [];

foreach($info as $items) {
    $dbinfo[]=$items["value"];
}

$db = mysqli_connect($dbinfo[1], $dbinfo[5], $dbinfo[2], $dbinfo[0]);

// Check if the form has been submitted
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Get the user credentials from the form
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Query the database to check if the user exists
    $query = "SELECT * FROM sellers WHERE username='$username' AND password='$password'";
    $result = mysqli_query($db, $query);

    // Check if the query returned any rows
    if (mysqli_num_rows($result) == 1) {
        // The user credentials are correct, redirect to the home page
        header("Location: ../pages/home.html");
        exit();
    } else {
        // The user credentials are incorrect, show an error message
        echo "Invalid username or password.";
    }
}