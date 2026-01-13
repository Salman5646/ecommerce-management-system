<?php
session_start();

if (!isset($_SESSION['username']) && isset($_COOKIE['ae_username'])) {

    $_SESSION['username'] = $_COOKIE['ae_username'];
}
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: login.html");
    exit(); // Stop script execution
}

// Retrieve the current user's username from the session
$currentUser = $_SESSION['username'];

// Check if the order ID is set in the URL parameter
if (isset($_GET['order_id']) && !empty($_GET['order_id'])) {
    // Sanitize the input
    $orderId = $_GET['order_id'];

    // Connect to the database
    $conn = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve the order details based on the order ID and username
    $orderQuery = "SELECT * FROM Orders WHERE order_id='$orderId' AND username='$currentUser'";
    $orderResult = $conn->query($orderQuery);

    if ($orderResult->num_rows > 0) {
        // Fetch the order details
        $orderRow = $orderResult->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/x-icon" href="/tablogo.png">
  

<style>
        body {
            background-color: #000;
            color: #fff;
            padding-top: 56px; /* Adjust the padding to accommodate the fixed navbar */
        }    
        i {
            color:white;
            font-size:20px;
            position:fixed;
            top:18x;
            left:8px;
            z-index: 1000; /* Ensure the icon appears above other content */
        }
        .navbar {
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        .card {
            color:black;
            display: flex;
            flex-direction: row;
        }
        .card-img {
            padding:1rem;
            flex: 0 0 auto;
            margin-left: 1rem; /* Adjust margin to create space between image and text */
        }
        .card-body {
            flex: 1 1 auto;
        }
        .hh-grayBox {
            background-color: #F8F8F8;
            margin-bottom: 10px;
            padding: 35px;
            margin-top: 20px;
        }
        .pt45 {
            padding-top:45px;
        }
        .order-tracking {
            display: flex;
            align-items: center; /* Align items vertically */
            margin-bottom: 20px; /* Adjust margin as needed */
            width: 100%; /* Set width to 100% */
            margin-left: 0; /* Remove left margin */
            margin-right: 0; /* Remove right margin */
        }

        .order-tracking .is-complete {
            display: block;
            position: relative;
            border-radius: 50%; /* Make it perfectly rounded */
            height: 30px;
            width: 30px;
            border: 0px solid #AFAFAF;
            background-color: #f7be16;
            margin-right: 10px; /* Space between circle and label */
            transition: background 0.25s linear;
            -webkit-transition: background 0.25s linear;
            z-index: 2;
        }

        .order-tracking.completed .is-complete {
            border-color: #27aa80;
            border-width: 0px;
            background-color: #27aa80;
        }

        .order-tracking.past .is-complete {
            border-color: #27aa80;
            border-width: 0px;
            background-color: #27aa80;
        }

        .order-tracking p {
            margin: 0; /* Reset margin */
        }

        .connector {
            position: absolute;
            left: 50%; /* Position connector in the middle horizontally */
            top: 0; /* Position connector at the top of the container */
            transform: translateX(-50%); /* Center the connector horizontally */
            width: 2px;
            height: 100%; /* Set height to 100% to cover the full height of the container */
            background-color: #AFAFAF;
            z-index: 1; /* Ensure the connector is behind the circles */
        }

        .order-tracking:not(:last-child) .connector {
            margin-right: 2%; /* Add margin to create space between connectors */
        }

        .order-tracking.completed .connector {
            background-color: #27aa80; /* Change color for completed phases */
        }

        .order-tracking.past .connector {
            background-color: #27aa80; /* Change color for past phases */
        }

        .order-tracking .dashed-connector {
            border: 1px dashed #AFAFAF;
            position: absolute;
            width: 2px;
            height: calc(100% - 30px); /* Adjust height based on circle size */
            z-index: 1; /* Ensure the dashed connector is behind the circles */
        }

        .order-tracking:not(:last-child) .dashed-connector {
            top: 30px; /* Position the dashed connector below the circle */
            left: 50%; /* Position the dashed connector in the middle */
            transform: translateX(-50%);
        }

        .order-tracking.completed .dashed-connector {
            background-color: #27aa80; /* Change color for completed phases */
        }

        .order-tracking.past .dashed-connector {
            background-color: #27aa80; /* Change color for past phases */
        }

        .cancel-btn {
            margin-top: 5px!important; 
        }
    </style>
</head>
<body>
    
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <div class="d-flex align-items-center">
            <button type="button" style="background-color: transparent;color:white;border:none" onclick="window.open('index.php','_self');" class="fas fa-regular fa-arrow-left"></button>
            <a class="navbar-brand d-flex align-items-center" style="padding-left:10px">
                <span class="ms-2">Order Details</span>
            </a>
        </div>
        <!-- Cancel button -->
        <div class="ml-auto" style="margin-top:-3px">
            <?php if ($orderRow['status'] == 'Pending') : ?>
                <a href="deleteorder.php?order_id=<?php echo $orderId; ?>" class="cancel-btn btn btn-danger mt-3">Cancel Order</a>
            <?php else : ?>
                <div style="width: 120px;"></div> <!-- Reserve space for cancel button -->
            <?php endif; ?>
        </div>
    </div>
</nav>




    <div class="container" style="padding-bottom:10px;padding-top:25px">

        <div class="row">
            <div class="col-md-6 offset-md-3">
               

                <div class="container">
                    <div class="row card mb-3" style="color:black;background-color:#F8F8F8!important;">
                        <div class="col-md-10 hh-grayBox pt-4 pb-2" style="margin-left:5%;">
                            <div class="order-tracking <?php echo ($orderRow['status'] == 'Out for Delivery' ||$orderRow['status'] == 'Shipped' ||$orderRow['status'] == 'Delivered' ||$orderRow['status'] == 'Approved' ||$orderRow['status'] == 'Pending') ? 'completed' : ''; ?>">
                                <span class="is-complete"></span>
                                <p>Pending</p>
                            </div>
                            <!-- Remove connector -->
                            <div class="order-tracking <?php echo ($orderRow['status'] == 'Out for Delivery' ||$orderRow['status'] == 'Shipped' ||$orderRow['status'] == 'Delivered' ||$orderRow['status'] == 'Approved') ? 'completed' : ''; ?>">
                                <span class="is-complete"></span>
                                <p>Approved</p>
                            </div>
               <!-- Remove connector -->
                            <div class="order-tracking <?php echo ($orderRow['status'] == 'Shipped' || $orderRow['status'] == 'Out for Delivery' || $orderRow['status'] == 'Delivered') ? 'completed' : ''; ?>">
                                <span class="is-complete"></span>
                                <p>Shipped</p>
                            </div>
                            <!-- Remove connector -->
                            <div class="order-tracking <?php echo ($orderRow['status'] == 'Out for Delivery' || $orderRow['status'] == 'Delivered') ? 'completed' : ''; ?>">
                                <span class="is-complete"></span>
                                <p>Out for Delivery</p>
                            </div>
                            <!-- Remove connector -->
                            <div class="order-tracking <?php echo ($orderRow['status'] == 'Delivered') ? 'completed' : ''; ?>">
                                <span class="is-complete"></span>
                                <p>Delivered</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3" >
                    <div class="card-body">
                        <p class="card-text"><strong>Order ID:</strong> <?php echo $orderRow['order_id']; ?></p>
   <p class="card-text"><strong>Address:</strong> <?php echo $orderRow['delivery_address']; ?></p>
                        <p class="card-text"><strong>Status:</strong> <?php echo $orderRow['status']; ?></p>
                         <p class="card-text"><strong>Date :</strong> <?php echo $orderRow['order_date']; ?></p>
                        <p class="card-text"><strong>Total Price:</strong> <?php echo $orderRow['total_amount']; ?></p>
                        <p class="card-text"><strong>Payment Method:</strong> <?php echo $orderRow['payment_method']; ?></p>
                    </div>
                </div>

                <!-- Display order items -->
                <center><h3>Items</h3></center>
                <?php
                    // Retrieve and display order items
                    $itemQuery = "SELECT * FROM Orders WHERE order_id='$orderId' AND username='$currentUser'";
                    $itemResult = $conn->query($itemQuery);

                    if ($itemResult->num_rows > 0) {
                        while ($itemRow = $itemResult->fetch_assoc()) {
                ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="card-text"><strong>Item Name:</strong> <?php echo $itemRow['item_name']; ?></p>
                        <p class="card-text"><strong>Quantity:</strong> <?php echo $itemRow['item_quantity']; ?></p>
                        <p class="card-text"><strong>Price:</strong> <?php echo $itemRow['total_price']; ?></p>
                    </div>
                    <img style="width:170px;height:150px" src="<?php echo $itemRow['item_image']; ?>" class="card-img" alt="Item Image">
                </div>
                <?php
                        } 
                    } else {
                        echo "<p>No items found for this order.</p>";
                    }
                ?>
            </div>
        </div>
    </div>

 <div style="padding-bottom:10px" class="text-center mt-4">
        <a href="index.php" class="btn btn-primary" style="width: 50%;margin:0 auto">Continue Shopping</a>
    </div>


</body>
</html>
<?php
    } else {
        // Order not found for the current user, display error message or handle accordingly
        echo "Order not found.";
    }

    $conn->close();
} else {
    // If order ID is not set or empty in the URL parameter, display error message or handle accordingly
    echo "Order ID not provided.";
}
?>