<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'mail/Exception.php';
require_once 'mail/PHPMailer.php';
require_once 'mail/SMTP.php';


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
date_default_timezone_set('Asia/Kolkata');
$time = date('Y-m-d H:i:s');

// Check if the payment method is set and not empty
if (isset($_GET['payment_method']) && !empty($_GET['payment_method'])) {
    // Sanitize the input
    $paymentMethod = $_GET['payment_method'];

    // Connect to the database
    $conn = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Generate a unique order ID and check for duplicates
    do {
        $orderId = uniqid('', true);
        $checkDuplicateQuery = "SELECT COUNT(*) AS count FROM Orders WHERE order_id = '$orderId'";
        $result = $conn->query($checkDuplicateQuery);
        $row = $result->fetch_assoc();
        $duplicateCount = $row['count'];
    } while ($duplicateCount > 0);

    // Calculate the total amount
    $totalAmountQuery = "SELECT SUM(total_price) AS total_amount FROM Cart WHERE username = '$currentUser'";
    $totalAmountResult = $conn->query($totalAmountQuery);
    $totalAmountRow = $totalAmountResult->fetch_assoc();
    $totalAmount = $totalAmountRow['total_amount'];

    // Get the delivery address from the account table
    $deliveryAddressQuery = "SELECT address FROM Account WHERE username = '$currentUser'";
    $deliveryAddressResult = $conn->query($deliveryAddressQuery);
    $deliveryAddressRow = $deliveryAddressResult->fetch_assoc();
    $deliveryAddress = $deliveryAddressRow['address'];

    // Start a transaction
    mysqli_autocommit($conn, false);

    // Insert all cart items into the Orders table with the same order ID
    $sql = "INSERT INTO Orders (order_id, username, payment_method, item_name, item_quantity, total_price, status, item_image, total_amount, delivery_address, order_date) 
        SELECT '$orderId', '$currentUser', '$paymentMethod', item_name, item_quantity, total_price, 'Pending', image, '$totalAmount', '$deliveryAddress', '$time'
        FROM Cart 
        WHERE username = '$currentUser'";

    if ($conn->query($sql) === TRUE) {
        // Delete all items from the cart for the current user
        $deleteCartQuery = "DELETE FROM Cart WHERE username = '$currentUser'";
        if ($conn->query($deleteCartQuery) === TRUE) {
            // Commit the transaction
            mysqli_commit($conn);

$emailQuery="select email from Account where username='$currentUser'";
if($res=mysqli_query($conn,$emailQuery))
{
if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $email = $row['email'];
    } else {
        // No email found for the given username
    }
}

$body="<b>Hello $currentUser,</b><br>Your order has been successfully placed.";
$orderDetailsQuery = "SELECT Distinct order_id,total_amount,delivery_address FROM Orders WHERE order_id = '$orderId'";
$query="Select * from Orders WHERE order_id = '$orderId'";
$orderDetailsResult = $conn->query($orderDetailsQuery);
$result = $conn->query($query);

if ($orderDetailsResult->num_rows > 0) {
    $body .= "<table style='margin:20px auto'><tr><th colspan=2>Order Details</th></tr>";
    while ($orderRow = $orderDetailsResult->fetch_assoc()) {
       $id=$orderRow['order_id'];
        $body .= "<tr><td>Order ID: </td><td>" . $orderRow['order_id'] . "</td></tr>";
        while($row = $result->fetch_assoc())
        {
          $body .= "<br><tr><td>Item : </td><td>" . $row['item_name'] . "</td></tr>";  
          $body .= "<tr><td>Quantity: </td><td>" . $row['item_quantity'] . "</td></tr>";  
          $body .= "<tr><td>Item Price: </td><td>" . $row['total_price'] . "</td></tr>"; 
          $body.="<tr></tr>";

        }
        $body .= "<br><tr><td>Total Price: </td><td>" . $orderRow['total_amount'] . "</td></tr>";
        $body .= "<tr><td>Delivering To: </td><td>" . $orderRow['delivery_address'] . "</td></tr>";
        
        $body .= "</table><br>";
    }
} else {
    $body .= "No order details found.";
}
//<a href='order.php?order_id=$id'>Track Order Now!</a>
$body .= "<br>Thank you for shopping with us!";
            // Send email to user
            $mail = new PHPMailer;
            $mail->isSMTP(); 
            $mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
            $mail->Host = "smtp.gmail.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
            $mail->Port = 587; // TLS only
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = 'asmientp24@gmail.com'; // email
            $mail->Password = 'ewrwerrsuswspqbb'; // password
            $mail->setFrom('asmientp24@gmail.com', 'Asmi Enterprises'); // From email and name
            $mail->addAddress($email, $currentUser); // to email and name
            $mail->Subject = 'Your Order Placed Successfully';
            $mail->msgHTML($body);
            $mail->AltBody = 'HTML messaging not supported';
            
            if(!$mail->send()) {
                echo "Error sending email: " . $mail->ErrorInfo;
            }
            // Close the connection
            $conn->close();

            // Redirect based on payment method
            if ($paymentMethod !== 'Cash on Delivery') {
                echo '<head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"></head>';
                echo '<style>
                #spinner-container {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    height: 100vh;
                    flex-direction: column;
                }
                .spinner-border {
                    font-size: 1rem; /* Set the initial font size */
                }
                .spinner-text {
                    font-size: 5rem;
                    margin-top: 20px;
                }
                </style>';

                echo '<div id="spinner-container" >';
                // Continuing from the previous code

                echo '<div class="spinner-border text-success" role="status">';
                echo '<span class="visually-hidden">Loading...</span>';
                echo '</div>';
                echo '<div>Payment Processing...</div>'; // Adding text below the spinner with increased font size
                echo '</div>';
                echo '<script>';
                echo 'setTimeout(function() {';
                echo 'window.location.href = "order.php?order_id=' . $orderId . '";'; // Corrected URL concatenation
                echo '}, 3000);';
                echo '</script>';
                exit();
            } else {
                // If payment method is COD, redirect directly to the order page
                header("Location: order.php?order_id=$orderId");
                exit();
            }
        }
    } else {
        // Rollback the transaction
        mysqli_rollback($conn);

        // If insertion failed, display error message
        echo "Error inserting order: " . $conn->error;
    }

    $conn->close();
} else {
    // If payment method is not set or empty, redirect to a failure page or handle accordingly
    header("Location: payment.php");
    exit();
}
?>

