<?php
// Establish connection to the database
$conn = mysqli_connect("localhost", "id21724899_root", "CO6i@2024", "id21724899_user");

// Check if connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize the search query variable
$search_query = "";

// Check if search query is provided in the URL
if(isset($_GET['search'])) {
    // Sanitize and store the search query
    $search_query = mysqli_real_escape_string($conn, $_GET['search']);
}

// Query to fetch products based on search query
$sql = "SELECT * FROM Product WHERE product_name LIKE '%$search_query%' OR product_description LIKE '%$search_query%'";

// Execute the query
$result = $conn->query($sql);

// Check if there are any products found
if ($result->num_rows > 0) {
    // Output the products
    echo '<div class="row">';
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-md-3 mb-4 d-flex">'; // Adjusted column size and added d-flex class
        echo '<div class="card flex-fill" style="width: 18rem;" data-aos="fade-right">'; // Added flex-fill class
        echo '<img src="'. $row["product_image"] .'" class="card-img-top width_card_img mx-auto d-block" style="max-width: 100%; height: auto;opacity:1! important" alt="'. $row["product_image"] .'">';
        echo '<div class="card-body d-flex flex-column">'; // Added d-flex and flex-column classes
        echo '<h5 class="card-title">'. $row["product_name"] .'</h5>';
        echo '<p class="card-text">'. $row["product_description"] .'</p>';
        echo '<p class="card-text">'. $row["product_discount"] .'% off - Rs.'. $row["product_price"] .'</p>';
        echo '<form action="addtocart.php" method="post">';
        echo '<input type="hidden" name="item" value="'. $row["product_name"] .'">';
        echo '<input type="hidden" name="value" value="'. $row["product_price"] .'">';
        echo '<input type="hidden" name="image" value="'. $row["product_image"] .'">';
        echo '<input type="hidden" name="description" value="'. $row["product_description"] .'">';
        echo '<center><input type="submit" class="btn btn-info mt-auto" value="Add to Cart"></center>'; // Added mt-auto class
        echo '</form></div></div></div>';

        $counter++;
        if ($counter % 4 == 0) {
            // Close the row after every fourth card
            echo '</div><div class="row"><center>';
        }
    }
    echo '</div>'; // Close the last row
} else {
    echo "<center style='font-size:36px;margin:100px'>No product found !</center>";
}

// Close the database connection
$conn->close();
?>
