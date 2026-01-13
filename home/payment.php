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

// Redirect if cart is empty
$conn = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM Cart WHERE username='$currentUser'";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    header("Location: index.php");
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/x-icon" href="/tablogo.png">
    <link rel="stylesheet" href="index.css">
    <style>
        body {
            background-color: black;
            color: white;
        }

       
tr,

        td {

            margin: 0!important;
            padding: 0.5rem!important;
            color: white!important;
            background-color: black!important;
        }

        .bottom-navbar {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #333;
            padding: 10px 20px;
            color: white;
            z-index: 1000;
        }
        @media (min-width: 576px) {
            .bottom-navbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            
        }
        .btn.btn-outline-warning {
            border-radius:0px;
        }


    .first-column {

        width: 40%;
    }
    .second-column {
        width: 60%;
    }


    </style>
</head>

<body>


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <div class="d-flex align-items-center">
                <div data-bs-theme="dark">
                    <button type="button" onclick="window.open('Cart.php','_self');" class="btn-close"
                        aria-label="Close"></button>
                </div>
                <a class="navbar-brand d-flex align-items-center" style="padding-left: 10px;">
                    <i class="fas fa-cart-shopping"></i>
                    <span class="ms-2">Payment</span>
                </a>
            </div>
        </div>
    </nav>

    <center>
        <h2 style="margin:20px auto;">Your Items</h2>
    </center>
<div class="table-container" style="margin:auto 10%">
<table class="table table-borderless" style="width: 90%; font-size: 16px; margin: 0 auto;">
        <?php
            $conn = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM Cart WHERE username='$currentUser'";
            $result = $conn->query($sql);
            $totalPrice = 0; // Variable to store total price

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td class='first-column'>" . $row["item_name"] . "</td>";
                    echo "<td class='second-column'>" . $row["item_quantity"] . " x " . $row["item_price"] . " = </td>";
                    echo "<td>Rs " . $row["total_price"] . "</td></tr>";
                    $totalPrice += $row["total_price"]; // Add to total price
                }
                echo "<tr><td colspan='2'>Total</td>";
                echo "<td>Rs " . $totalPrice . "</td></tr>"; // Display total price row
                echo "<tr><td>Delivery Fee</td>";
                echo "<td></td>";
                echo "<td>0 (Free)</td></tr>";
                echo '<tr><td></td></tr><tr><td></td></tr><tr><td>Delivering To</td><td></td><td><button type="button" class="btn btn-secondary btn-block" onclick="window.open(\'deliveryadd.php\', \'_self\')">Edit</button></td></tr></tr>';

                $currentUser = $_SESSION['username'];

                $sql = "SELECT * FROM Account WHERE username='$currentUser'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td colspan='3'>".$row["address"]."</td></tr>";         
                    }            
                }
            } else {
                header("Location: index.php");
                exit();
            }
            $conn->close();
        ?>
    </table>

</div>
    <center>
        <h2 style="margin-top:30px;">Choose your Payment option</h2>
    </center>
    <div class="container" style="margin-bottom:75px">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="btn-group d-flex flex-wrap" role="group">
                    <label class="btn btn-outline-warning m-2">
                        <input type="radio" name="payment" id="gpay" value="UPI" autocomplete="off">
                        UPI
                    </label>
                    <label class="btn btn-outline-warning m-2">
                        <input type="radio" name="payment" checked id="codPayment" value="Cash on Delivery"
                            autocomplete="off">
                        COD
                    </label>
                    <label class="btn btn-outline-warning m-2">
                        <input type="radio" name="payment" id="phonepe" value="Credit Card" autocomplete="off">
                        Credit Card
                    </label>

                </div>
            </div>
        </div>
    </div>

    <div class="bottom-navbar">
        <div class="container">
            <div class="row">
                <div class="col-6"></div>
                <div class="col-6 text-end">
                    <!-- Modal trigger button with onclick attribute to call showSpinner() -->
                    <button class="btn btn-primary" id="orderbtn"  data-bs-toggle="modal"
                        data-bs-target="#myModal">Order Now</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Order Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="myModalTitle">Confirm Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-black">
                    Are you sure you want to order these items?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" onclick="confirmOrder()">Confirm</button>
                </div>
            </div>
        </div>
    </div>

<script>
    function confirmOrder() {
        // Gather necessary data
        var paymentMethod = document.querySelector('input[name="payment"]:checked');

        // Check if a payment method is selected
        if (paymentMethod) {
            // Redirect to the payment processing page with the selected payment method
            window.location.href = 'insertorder.php?payment_method=' + encodeURIComponent(paymentMethod.value);
        } else {
            // Display an error message if no payment method is selected
            alert("Please select a payment method.");
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

</body>

</html>