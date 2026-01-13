<?php

$conn = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data
$sql = "SELECT * FROM Orders";
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