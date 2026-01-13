<?php
// Create connection
$conn = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the selected category from the URL parameter
$category = $_GET['category'];

// Fetch all product names from the database based on the selected category
$query = "SELECT product_name FROM Product WHERE category = '$category'";
$result = $conn->query($query);

// Create an array to store product names
$products = array();

// Check if any result is found
if ($result->num_rows > 0) {
    // Fetch all product names and add them to the array
    while ($row = $result->fetch_assoc()) {
        $products[] = $row['product_name'];
    }
}
else {

    $products[] = "No items to show";
}

// Encode the array as JSON and echo it
header('Content-Type: application/json');
echo json_encode($products);

// Close the database connection
$conn->close();
?>