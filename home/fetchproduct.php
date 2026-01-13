<?php
header('Content-Type: application/json');

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Logging (optional)
error_log("fetchproduct.php called");

$servername = "sql213.byethost22.com";
$username = "b22_39801860";
$password = "Salman@56";
$dbname = "b22_39801860_main";

// Connect to DB
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    http_response_code(500);
    echo json_encode(["error" => "DB connection failed"]);
    exit;
}

// Get search query
$search = $_GET['search'] ?? '';

if (empty($search)) {
    echo json_encode([]);
    exit;
}

$search = $conn->real_escape_string($search);

error_log("Search query: $search");

// Search across ALL products in both name and description
$sql = "SELECT * FROM Product 
        WHERE (product_name LIKE '%$search%' OR product_description LIKE '%$search%')
        ORDER BY category, product_name 
        LIMIT 100;";

$result = $conn->query($sql);

// Check result
if (!$result) {
    error_log("Query failed: " . $conn->error);
    http_response_code(500);
    echo json_encode(["error" => "Query failed"]);
    exit;
}

$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = [
        'product_name' => $row['product_name'],
        'product_description' => $row['product_description'],
        'product_price' => $row['product_price'],
        'product_discount' => $row['product_discount'],
        'product_image' => $row['product_image'],
        'stock' => $row['stock'],
        'category' => $row['category']
    ];
}

// Return as JSON
echo json_encode($products);
$conn->close();
?>