<?php
session_start(); // Start the session

$un = $_POST["username"];
$no = $_POST["phone"];
$email = $_POST["email"];
$add = $_POST["address"];
$name = $_POST["fullname"];
$pass = $_POST["password"];

// Hash the password using bcrypt
$hashedPass = password_hash($pass, PASSWORD_BCRYPT);

$con = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");

date_default_timezone_set('Asia/Kolkata');
$time = date('Y-m-d H:i:s');

$query = "INSERT INTO Account VALUES ('$un','$hashedPass','$email',$no,'$add','$name','$time')";

$result = mysqli_query($con, $query);

if ($result) {
    // Set session variables
    $_SESSION['username'] = $un;
    
    // Check if the user has accepted cookies
    if(isset($_COOKIE['accept_cookie']) && $_COOKIE['accept_cookie'] === 'true') {
        // Set the username in a cookie to remember it for 30 days
        setcookie('ae_username', $un, time() + (30 * 24 * 60 * 60), "/");
    }
    
    header("Location:index.php");
} else {
    echo "Unable to create your account<br>Please recheck the data provided by you and Try Again!";
}
?>
