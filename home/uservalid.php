<?php
    // Sanitize the username input
    $con = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");
    $username = mysqli_real_escape_string($con, $_GET["username"]);
    
    // Query to check if the username exists
    $query = "SELECT * FROM Account WHERE username='$username'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "Username not available"; // Username exists
    } else {
        echo "Available"; // Username is available
    }

?>
