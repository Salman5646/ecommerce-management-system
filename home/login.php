<?php
session_start(); // Start the session

$un = $_POST["username"];
$pass = $_POST["password"];

$con = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");

$query = "SELECT * FROM Account WHERE username='$un'";

$result = mysqli_query($con, $query);

if ($row = mysqli_fetch_assoc($result)) {
    // Verify the hashed password
    if (password_verify($pass, $row['password'])) {
        // Set session variables
        $_SESSION['username'] = $un;
        
        // Check if the user has accepted cookies
        if(isset($_COOKIE['accept_cookie']) && $_COOKIE['accept_cookie'] === 'true') {
            // Set the username in a cookie to remember it for 30 days
            setcookie('ae_username', $un, time() + (30 * 24 * 60 * 60), "/");
        }
        
        header("Location:index.php");
        exit();
    } else {
        header("refresh:2;url=login.html");
        echo "Invalid Credentials! Try Again";
    }
} else {
    header("refresh:2;url=login.html");
    echo "Invalid Credentials! Try Again";
}
?>
