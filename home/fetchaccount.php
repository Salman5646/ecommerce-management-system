<?php

// Database connection parameters
$servername = "localhost";
$username = "id21724899_root";
$password = "CO6i@2024";
$database = "id21724899_user";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data
$sql = "SELECT * FROM Account";
$result = $conn->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Fetch associative array
    $data = array();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Convert data array to JSON
    $json_data = json_encode($data);

    // Output JSON
    header('Content-Type: application/json');
    echo $json_data;
} else {
    echo "No data found.";
}

// Close connection
$conn->close();
?>