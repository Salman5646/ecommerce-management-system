<?php
session_start();

if (!isset($_SESSION['username']) && isset($_COOKIE['ae_username'])) {

    $_SESSION['username'] = $_COOKIE['ae_username'];
}
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: login.html");
    exit(); // Stop script execution
}

// Retrieve the current user's username from the session
$currentUser = $_SESSION['username'];

$item = $_POST["item"];
$con = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");

date_default_timezone_set('Asia/Kolkata');
$time = date('Y-m-d H:i:s');
$query = "DELETE FROM Cart WHERE username = '$currentUser' AND `item_name`= '$item'";

$result = mysqli_query($con, $query);

if ($result) {
    header("Location: Cart.php");
    exit();
} else {
    echo "Unable to remove item!";
}
?>