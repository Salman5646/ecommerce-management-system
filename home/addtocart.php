<?php
session_start(); // Start the session
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
$total = $_POST["value"];
$img = $_POST["image"];
$desc = $_POST["description"];
$con = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

date_default_timezone_set('Asia/Kolkata');
$time = date('Y-m-d H:i:s');

// Check if the item already exists in the cart for the current user
$query = "SELECT * FROM Cart WHERE username = '$currentUser' AND item_name = '$item'";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

if (mysqli_num_rows($result) > 0) {
    // If the item exists, update its quantity
    $row = mysqli_fetch_assoc($result);
    $quant = $row['item_quantity'];
    $quant++; // Increment quantity
    $query = "UPDATE Cart SET item_quantity = '$quant' WHERE username = '$currentUser' AND item_name = '$item'";
} else {
    // If the item doesn't exist, insert a new record
    $query = "INSERT INTO Cart (`username`, `item_price`,`total_price`, `Time_of_adding`, `item_name`,`description`, `image`) VALUES ('$currentUser', '$total', '$total', '$time', '$item', '$desc' , '$img')";
}

$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

// Check if the user's account exists
$query = "SELECT * FROM Account WHERE username='$currentUser'";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

if (mysqli_num_rows($result) == 0) {
    // If the user's account doesn't exist, log them out and redirect to login page
    session_unset();
    session_destroy();
    header("Location: login.html");
    exit();
}

header("Location: index.php");
exit();
?>
