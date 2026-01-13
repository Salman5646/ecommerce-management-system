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

    $username = $_SESSION['username']; // Retrieve username from session

    // Connect to the database
    $conn = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve other POST data
    $item_name = $_POST['item'];
    $act = $_POST['action'];

    if ($act == "+1") {
        // Increment the quantity
        $sql_update = "UPDATE Cart SET item_quantity = item_quantity + 1 WHERE item_name = '$item_name' AND username = '$username'";
        if ($conn->query($sql_update) === TRUE) {
            // Quantity updated successfully
            header("Location: Cart.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } elseif ($act == "-1") {
        // Decrement the quantity, but ensure it doesn't go below 0
        $sql_update = "UPDATE Cart SET item_quantity = CASE WHEN item_quantity > 1 THEN item_quantity - 1 ELSE 1 END WHERE item_name = '$item_name' AND username = '$username'";
        if ($conn->query($sql_update) === TRUE) {
            // Quantity updated successfully
             header("Location: Cart.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    $conn->close();
?>
