<?php

$conn= mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main"); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted and the required fields are present
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id']) && isset($_POST['status'])) {
    // Retrieve order ID and new status from the form
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['status'];

    // Update the status of the order in the database
    $updateQuery = "UPDATE Orders SET status='$newStatus' WHERE order_id='$orderId'";
    $updateResult = $conn->query($updateQuery);

    if ($updateResult) {
        // Status updated successfully
        echo '<div class="alert alert-success" role="alert">Status updated successfully!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Error updating status: ' . $conn->error . '</div>';
    }
}

// Retrieve distinct order IDs
$distinctOrderQuery = "SELECT DISTINCT order_id FROM Orders";
$distinctOrderResult = $conn->query($distinctOrderQuery);

if ($distinctOrderResult->num_rows > 0) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="/tablogo.png">
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Add your custom CSS styles here */
    </style>
</head>
<body>
    
    
    <div class="container">
        
        <h1 class="mt-4 mb-4">Manage Orders</h1>
        <?php
            // Display status update form for each distinct order ID
            while ($distinctOrderRow = $distinctOrderResult->fetch_assoc()) {
                $orderId = $distinctOrderRow['order_id'];
                // Retrieve the latest status for the current order ID
                // $query="SELECT * FROM Orders";
                $latestStatusQuery = "SELECT * FROM Orders WHERE order_id='$orderId' ORDER BY order_id DESC LIMIT 1";
                $latestStatusResult = $conn->query($latestStatusQuery);
                $latestStatusRow = $latestStatusResult->fetch_assoc();
        ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Order ID: <?php echo $orderId; ?></h5>
                <p class="card-text">Status: <?php echo $latestStatusRow['status']; ?></p>
                <p class="card-text">Username: <?php echo $latestStatusRow['username']; ?></p>
                <p class="card-text">Total Price: <?php echo $latestStatusRow['total_price']; ?></p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="hidden" name="order_id" value="<?php echo $orderId; ?>">
                    <select name="status" class="form-control">
                        <option value="Pending" <?php if ($latestStatusRow['status'] == "Pending") echo "selected"; ?>>Pending</option>
                        <option value="Approved" <?php if ($latestStatusRow['status'] == "Approved") echo "selected"; ?>>Approved</option>
                        <option value="Shipped" <?php if ($latestStatusRow['status'] == "Shipped") echo "selected"; ?>>Shipped</option>
                        <option value="Out for Delivery" <?php if ($latestStatusRow['status'] == "Out for Delivery") echo "selected"; ?>>Out for Delivery</option>
                        <option value="Delivered" <?php if ($latestStatusRow['status'] == "Delivered") echo "selected"; ?>>Delivered</option>
                    </select>
                    <button type="submit" class="btn btn-primary mt-2">Update Status</button>
                </form>
            </div>
        </div>
        <button style="color:black!important;position: fixed !important; bottom: 30px!important; right: 20px!important;padding: 0px !important;background-color: transparent !important;border:none !important" 
            type="button" id="scrollButton" onclick="scrollToTopOrBottom()" class="btn btn-primary position-relative">
        <i id="scrollIcon" style="font-size: 24px;" class="fa-solid "></i>
    </button>
        <?php
            }
        ?>
        
    </div>
</body>
 <script>
 window.onload = function() {
            // Initialize icon to down arrow on page load
            scrollIcon.classList.add('fa-arrow-down');
            scrollIcon.classList.remove('fa-arrow-up');
        }
        let scrollIcon = document.getElementById('scrollIcon');
        let scrollButton = document.getElementById('scrollButton');

        function scrollToTopOrBottom() {
            if (scrollIcon.classList.contains('fa-arrow-down')) {
                window.scrollTo(0, document.body.scrollHeight);
                scrollIcon.classList.remove('fa-arrow-down');
                scrollIcon.classList.add('fa-arrow-up');
            } else {
                window.scrollTo(0, 0);
                scrollIcon.classList.remove('fa-arrow-up');
                scrollIcon.classList.add('fa-arrow-down');
            }
        }
    </script>
</html>
<?php
} else {
    echo "No orders found.";
}

$conn->close();
?>
