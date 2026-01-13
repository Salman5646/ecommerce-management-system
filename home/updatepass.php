<?php
session_start();

if(isset($_SESSION["username"]) && isset($_POST["password"]) && isset($_POST["npass"])) {
    $un = $_SESSION["username"];
    $pass = $_POST["password"];
    $np = $_POST["npass"];

    if (strlen($np) < 8) {
        header("refresh:2;url=changepass.php");
        echo "New Password should be at least 8 characters long!";
        exit();
    }

    $hp = password_hash($np, PASSWORD_BCRYPT);
    $con = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "UPDATE Account SET password='$hp' WHERE username='$un'";

    $result = mysqli_query($con, $query);

    if ($result) {
        header("refresh:2;url=index.php");
        echo "Password updated successfully!";
    } else {
        header("refresh:2;url=changepass.html");
        echo "Unable to update your password! Please try again.";
    }

    mysqli_close($con);
} else {
    echo "Invalid request!";
}
?>