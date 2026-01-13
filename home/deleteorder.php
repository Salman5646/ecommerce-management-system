<?php
session_start();
if (!isset($_SESSION['username']) && isset($_COOKIE['ae_username'])) {

    $_SESSION['username'] = $_COOKIE['ae_username'];
}
$currentUser = $_SESSION['username'];
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

if (isset($_GET['order_id']) && !empty($_GET['order_id'])) {
    $orderId = $_GET['order_id'];

    $conn = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete the order based on order ID and username
    $deleteQuery = "DELETE FROM Orders WHERE order_id='$orderId' AND username='$currentUser'";
    if ($conn->query($deleteQuery) === TRUE) { 

       header("refresh:0;url=index.php");

        
    } else {
        echo "Error deleting order: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Order ID not provided.";
}
?>