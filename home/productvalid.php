<?php
// Sanitize the product name input
$name = $_POST["name"];

// Connect to the database
$con = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");

// Query to check if the product name exists
$query = "SELECT * FROM Product WHERE product_name='$name'";
$result = mysqli_query($con, $query);

// Check if the query was successful and if the product name exists
if ($result && mysqli_num_rows($result) > 0) {
    echo "Product already exists"; // Product name exists
} else {
    echo "Available"; // Product name is available
}
?>