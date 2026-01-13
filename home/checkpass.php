<?php
session_start();

$username = $_SESSION['username'];
$lastPassword = $_POST['lastPassword'];
$conn = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");

// Query the database to check if the username and last password are valid
$query = "SELECT * FROM Account WHERE username = '$username'";
$result = mysqli_query($con, $query);

// If a row is returned, it means the username exists
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
   if (password_verify($lastPassword, $row['password'])) {
        echo 'valid';
    } else {
        echo 'invalid';
   }
} else {
    echo 'invalid';
}

?>