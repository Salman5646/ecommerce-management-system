<?php
session_start();
if (!isset($_SESSION['username']) && isset($_COOKIE['ae_username'])) {

    $_SESSION['username'] = $_COOKIE['ae_username'];
}
if (!isset($_SESSION['username'])) {

    header("Location: login.html");
    exit(); // Stop script execution
}

// Retrieve the current user's username from the session
$currentUser = $_SESSION['username'];

// Check if the user's account exists
$conn = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM Account WHERE username='$currentUser'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    // If the user's account doesn't exist, log them out and redirect to login page
    session_unset();
    session_destroy();
    header("Location: login.html");
    exit();
}

// Proceed to display the cart page if the user's account exists
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/x-icon" href="/tablogo.png">
    <link rel="stylesheet" href="index.css">
    <style>

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

        
        .quantity-form button {
            border-radius: 0; /* Remove border radius */
        }
        .navbar .btn-close {
            color: white; /* Set close button color to white */
        }

    </style>
</head>

<body style="background-color:black;color:white;">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <div class="d-flex align-items-center">
                <div data-bs-theme="dark">
                    <button type="button" style="background-color: white;" onclick="window.open('index.php','_self');"
                        class="btn-close" aria-label="Close"></button>
                </div>

                <a class="navbar-brand d-flex align-items-center" style="padding-left:10px">
                    <i class="fas fa-cart-shopping"></i>
                    <span class="ms-2">My Cart</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <?php
            $conn = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM Cart WHERE username='$currentUser'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='container' >"; // Start container for each item
                    echo "<div style='width:90%;margin-top:30px;' class='row g-0 bg-body-secondary position-relative'>";
                    echo "<div class='col-md-6 mb-md-0 p-md-4'>";
                    echo "<img src='/home/" . $row['image'] . "' class='w-100' alt='" . $row['image'] . "'>";
                    echo "</div>";
                    echo "<div class='col-md-6 p-4 ps-md-0'>";
                    echo "<h5 class='mt-0'>" . $row["item_name"] . "</h5>";
                    echo "<p class='text-wrap' style='font-size:16px'>Description : " . $row['description'] ."</p>";
                    echo "<div class='input-group mb-3'>";
                    echo "<span class='input-group-text' style='color:white;background-color:black;'>Quantity:</span>";
                    
                    // Decrement form
                    echo "<form action='updatecart.php' method='post' class='quantity-form'>";
                    echo "<input type='hidden' name='item' value='" . $row['item_name'] . "'>";
                    echo "<input type='hidden' name='action' value='-1'>";
                    echo "<button type='submit' class='btn btn-dark minusBtn' style='border:1px solid white;color:white;background-color:black;' >-</button>";
                    echo "</form>";
                    
                    // Quantity display
    echo "<input type='number' style='border:0px solid black;text-align: right!important;' readonly class='quant form-control text-center' value='" . $row['item_quantity'] . "'>";
                    
                    // Increment form
                    echo "<form action='updatecart.php' method='post' class='quantity-form'>";
                    echo "<input type='hidden' name='item' value='" . $row['item_name'] . "'>";
                    echo "<input type='hidden' name='action' value='+1'>";
                    echo "<button type='submit' style='border:1px solid white;color:white;background-color:black;'  class='btn btn-dark'>+</button>";
                    echo "</form>";
                    
                    echo "</div>";
                    echo "<p>Price : ₹ " . $row['item_price'] ." x " . $row['item_quantity'] ." = ₹ " . $row['total_price'] ."</p>";
                    echo "<div class='d-flex justify-content-end'>"; // Start div to align remove button to right
                    echo "<form action='removefromcart.php' method='post'>";
                    echo "<input type='hidden' name='item' value='" . $row['item_name'] . "'>";
                    echo "<input type='submit' style='margin-top: 1rem;' class='btn btn-danger' value='Remove'>";
                    echo "</form>";
                    echo "</div>"; // Close div for remove button alignment
                    echo "</div>";
                    echo "</div>";
                    echo "</div>"; // Close container for each item
                }
            } else {
                echo "<center style='font-size:36px;margin:100px'>Cart is empty !</center>";
            }
            $conn->close();
        ?>
    </div>
<br><br><br><br>
    <div class="bottom-navbar">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <?php
                        $con = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");

                        if (mysqli_connect_errno()) {
                            echo "Failed to connect to MySQL: " . mysqli_connect_error();
                            exit();
                        }

                        $query = "SELECT SUM(total_price) as total FROM Cart WHERE username='$currentUser'";
                        $result = mysqli_query($con, $query);

                        if ($result) {
                            $row = mysqli_fetch_assoc($result);
                            $rowCount = $row['total'];

                            if($rowCount!="")
                                echo "Total Amount : Rs  " . $rowCount;
                            else
                                echo "Total Amount : Rs 0 ";
                        } else {
                            echo "No result Found !";
                        }

                        mysqli_close($con);
                    ?>
                </div>
                <div class="col-6 text-end">
                    <?php
                        $conn = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT * FROM Cart WHERE username='$currentUser'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // If cart is not empty, show the "Proceed to checkout" button
                            echo '<button onclick="window.open(\'payment.php\',\'_self\')" class="btn btn-primary">Proceed to checkout</button>';
                        }

                        $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function updateQuantityButtons() {
                var quantityInputs = document.querySelectorAll('.quant');
                var minusButtons = document.querySelectorAll('.minusBtn');

                // Check if the quantity inputs and minus buttons are aligned
                if (quantityInputs.length !== minusButtons.length) {
                    console.error("Error: Quantity inputs and minus buttons are not aligned.");
                    return;
                }

                quantityInputs.forEach(function(input, index) {
                    var quantityValue = parseInt(input.value);

                    if (minusButtons[index]) {
                        minusButtons[index].disabled = (quantityValue <= 1);
                    }
                });
            }

            updateQuantityButtons();

            document.querySelectorAll('.quant').forEach(function(input) {
                input.addEventListener('change', updateQuantityButtons);
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpccrossorigin="anonymous"></script>
</body>

</html>
