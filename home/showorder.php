<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: login.html");
    exit(); // Stop script execution
}

// Retrieve the current user's username from the session
$currentUser = $_SESSION['username'];

// Connect to the database
$conn = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve all orders for the current user
$orderQuery = "SELECT DISTINCT order_id, status, total_amount, payment_method, order_date, delivery_address FROM Orders WHERE username='$currentUser'";

$orderResult = $conn->query($orderQuery);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #000;
            color: #fff;
        }
        i {
            color: white;
            font-size: 24px;
            position: fixed;
            top: 15px;
            left: 15px;
        }
        .card {
            color: black;
            display: flex;
            flex-direction: row;
        }
        .card-body {
            flex: 1 1 auto;
        }
        .btn-view-details {
            margin-top: 10px;
        }
        .badge {
            cursor: default;
            position: absolute;
            top: 10px;
            right: 10px;
            color:white;
        }
    </style>
</head>
<body>
    <i onclick="window.open('index.php','_self');" class="fas fa-solid fa-arrow-left"></i>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <?php
                if ($orderResult->num_rows > 0) {
                    echo '<center><h2 class="mt-4 mb-3">My Orders</h2></center>';
                    while ($orderRow = $orderResult->fetch_assoc()) {
                        // Determine the badge class based on the status
                        $badgeClass = '';
                        if ($orderRow['status'] == 'Pending') {
                            $badgeClass = 'danger';
                        } elseif ($orderRow['status'] == 'Approved') {
                            $badgeClass = 'primary';
                        } elseif ($orderRow['status'] == 'Shipped') {
                            $badgeClass = 'info';
                        } elseif ($orderRow['status'] == 'Out for Delivery') {
                            $badgeClass = 'warning';
                        } elseif ($orderRow['status'] == 'Delivered') {
                            $badgeClass = 'success';
                        }
                        ?>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 offset-md-3">
                                    <div class="card mb-3">
                                        <span class="badge btn-<?php echo $badgeClass; ?>"><?php echo $orderRow['status']; ?></span>
                                        <div class="card-body">
                                            <p class="card-text" style="margin-top:10px"><strong>Order ID:</strong> <?php echo $orderRow['order_id']; ?></p>
                                            <p class="card-text"><strong>Address:</strong> <?php echo $orderRow['delivery_address']; ?></p>
                                            <p class="card-text"><strong>Date:</strong> <?php echo $orderRow['order_date']; ?></p>
                                            <p class="card-text"><strong>Total Price:</strong> <?php echo $orderRow['total_amount']; ?></p>
                                            <p class="card-text"><strong>Payment Method:</strong> <?php echo $orderRow['payment_method']; ?></p>
                                            <a href="order.php?order_id=<?php echo $orderRow['order_id']; ?>" class="btn btn-primary btn-view-details">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<center><h1 style='margin-top:50%'>No orders found.</h1></center>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>
