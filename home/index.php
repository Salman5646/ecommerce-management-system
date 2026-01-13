<?php
session_start();

if (!isset($_SESSION['username']) && isset($_COOKIE['ae_username'])) {

    $_SESSION['username'] = $_COOKIE['ae_username'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-comm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/x-icon" href="/tablogo.png">
    <link rel="stylesheet" href="laptop.css">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
<style>
    
@media screen and (max-width: 576px) {
  
    .card-title {
        font-size: 13px; /* Slightly smaller title font */
        margin-bottom: 0.2rem; /* Reduced margin below title */
        white-space: nowrap; /* Prevents title from wrapping */
        overflow: hidden;
        text-overflow: ellipsis; /* Ensures titles are short */
    }

    .card-text {
        font-size: 11px; /* Smaller text for descriptions and prices */
        line-height: 1.1; /* Reduced line height for compactness */
        margin-bottom: 0.1rem; /* Reduced margin between text elements */
        overflow: hidden;
        text-overflow: ellipsis;
        max-height: 2.2em; /* Keep it limited to two lines (or less line height) */
    }
    
    .card-img-top {
        max-height: 90px!important; /* Slightly smaller image height */
        object-fit: cover;
        width: 100%;
        border-radius: 5px 5px 0 0;
    }
}
@media screen and (max-width: 576px) {
    .dropdown-menu-fixed {
        left: 20px;
        top: 70px!important;
        min-width: 100px!important;
    }
}

    .offcanvas-body{
        height:50%;
    }
.dropdown-menu-fixed {
    position: fixed;
    top: 100px;
    left: 15px;
    min-width: 150px;
    max-width: 50%;
    z-index: 1000;
}


  .cart:disabled {
    background-color: #0dcaf0 !important; /* Matches Bootstrap btn-info */
    border-color: #0dcaf0 !important;
    opacity: 0.6; /* Slight transparency to indicate disabled */
    cursor: not-allowed;

}

       
    .nav-link:hover{
        text-decoration:none;
        transform:none;
        background-color:lightblue;
        color:black;
        border-radius:10px;
    }
    .btn-account {
    position: fixed;
    bottom: 25px;
    background-color:transparent;
    border:none;
    z-index:999;
    left: 0px;
    font-size:24px;
    padding: 0px !important;
       margin: 0px !important;
}
   .btn-account:hover{
        background-color:transparent;   border:none;
   }
  .offcanvas-body a{
       text-decoration:none;
       font-size:20px;
       color:white;
   }
@media (max-width: 768px) {
    .navbar-brand img {
    width: 6rem;}
  
    #liveSearchInput {
    max-width: 50%!important;
  }
}
 #liveSearchInput {
    max-width: 40%!important;
  }
  .mb-4{
    margin-bottom:0!important;
  }
</style>

</head>

<body style="background-color: rgb(13, 15, 28);">
      <?php

    if(isset($_SESSION['username'])) {

        echo '<button class="btn-account btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><i class="fas fa-solid fa-user"></i></button>';
    }
    ?>

<div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasScrollingLabel">   <?php


// Check if the user is logged in
if(isset($_SESSION['username'])) 
    echo "Hello ",$_SESSION['username'];
    ?>
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
     <div class="text-bg-dark p-3"><a>
         <?php
    $conn = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");
    $currentUser=$_SESSION['username'];
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM Account WHERE username='$currentUser'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $gid=$row['google_id'];
            echo "<h5>Fullname : " . $row["name"] . "</h5>";
            echo "<h6>Email : " . $row["email"] . "</h6>";
           echo "<h6>Phone No : " . $row["phone"] . "</h6>";
        }
    } 
    $conn->close();
?>
     </a></div> 
     <div class="text-bg-dark p-3"><a href="deliveryadd.php">Delivery Address</a></div>
     <?php 
     if (is_null($gid)) {
  echo'<div class="text-bg-dark p-3"><a href="changepass.php">Change Password</a></div>';
}
  ?>
<div class="text-bg-dark p-3"><a href="showorder.php">Orders</a></div>
<div class="text-bg-dark p-3"><a data-bs-toggle="modal" data-bs-target="#logoutModal">Log  Out</a></div>


  </div>
</div>


                                <button style="padding:0.7rem;" class="btn btn-dark dropdown-toggle dropdown-menu-fixed" data-bs-toggle="dropdown" aria-expanded="false">

                                  Categories
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                  <li><a class="dropdown-item" href="index.php?#lap">Laptop & Desktop Services</a></li>
                                  <li><a class="dropdown-item" href="index.php?#cct">CCTV Services</a></li>
                                  <li><a class="dropdown-item" href="index.php?#hom">Home and Office Automation</a></li>
                                  <li><a class="dropdown-item" href="index.php?#ant">Anti Virus</a></li>
                
  <li><a class="dropdown-item" href="index.php?#com"> Computer Accessories</a></li>
  
  <li><a class="dropdown-item" href="index.php?#pri">Printers, Routers & Switches</a></li>
                                </ul>
                              
    
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="aelogo.png" alt="ecom" width="30" height="24">
        </a>

<!-- 🔍 Responsive Search Bar -->
<input class="form-control me-2 bg-dark text-white border-info"
       type="search"
       name="search"
       id="liveSearchInput"
       placeholder="Search here"
       aria-label="Search"
       value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
       style="font-size: 14px; height: 32px;background-color: white !important;">

<button class="navbar-toggler" type="button"
        data-bs-toggle="offcanvas"  data-bs-target="#offcanvasNavbar"
        aria-controls="offcanvasNavbar"
        aria-expanded="false"
        aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>
        
        
<div class="offcanvas offcanvas-end" style="height: max-content;width:max-content;background-color:black" tabindex="-1" id="offcanvasNavbar" 
     aria-labelledby="offcanvasNavbarLabel">
    
    <div class="offcanvas-header" style="color:white">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel" >Menu</h5>
        <button type="button" class="btn-close btn-close-white text-reset" 
        data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3" >

            <li class="nav-item">
                <a class="nav-link small-nav-link" href="#" id="getQuoteBtn" >Get Quote</a>
            </li>

            <li class="nav-item">
                <a class="nav-link small-nav-link" href="aboutus.html" >About Us</a>
            </li>

            <li class="nav-item">
                <a class="nav-link small-nav-link" href="index.php#ftr">Contact Us</a>
            </li>

            <?php if (!isset($_SESSION['username'])) { ?>
                <li class="nav-item">
                    <a class="nav-link small-nav-link"
                       data-bs-toggle="modal"
                       data-bs-target="#staticBackdrop"
                       data-bs-dismiss="offcanvas" > Sign In
                    </a>
                </li>
            <?php } ?>

        </ul>
        </div>
</div>


            
            <button style="position: fixed !important; bottom: 60px!important; right: 5px!important;padding: 0px !important;background-color: transparent !important;border:none !important;" type="button" onclick="window.open('Cart.php','_self');" class="btn btn-primary position-relative">
                <i style="font-size: 24px;" class="fas fa-cart-shopping"></i>
                <span class="position-absolute top-50 start-100 translate-middle badge rounded-pill bg-danger" style="top: 15px!important;left:10px!important">
  <?php


// Check if the user is logged in
if(isset($_SESSION['username'])) {
    // Assuming the user is logged in, retrieve their username from the session
    $username = $_SESSION['username'];

    // Establish connection to the database
    $con = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");

    // Check for connection errors
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    // Prepare and execute the query to count cart items for the current user
    $query = "SELECT COUNT(item_name) as total FROM Cart WHERE username = '$username'";
    $result = mysqli_query($con, $query);

    // Check if the query was successful
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $rowCount = $row['total'];
        if($rowCount>99)
        echo "99+";

        // Output the count of cart items
        else
        echo $rowCount;
    } else {
        echo "0";
    }

    // Close the database connection
    mysqli_close($con);
} else {
    // If the user is not logged in, show 0 items in the cart
    echo "0";
}
?>            </span>
            </button>
              <button style="position: fixed !important; bottom: 20px!important; right: 5px!important;padding: 0px !important;background-color: transparent !important;border:none !important" type="button" onclick="window.scrollTo(0,0)" class="btn btn-primary position-relative">
                <i style="font-size: 24px;" class="fa-solid fa-arrow-up"></i>
            </button>
        </div>
    </nav>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Sign In</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Login to Asmi Enterprises or create a new account
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="window.open('NewAccount.html','_self')" class="btn btn-success">Create a new Account</button>
                    <button type="button" onclick="window.open('login.html','_self')"  class="btn btn-primary">Login</button>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade" id="quoteModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="quoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quoteModalLabel">Get a Quote</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="quoteName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="quoteName" placeholder="Enter your name" required>
                    </div>
                    <div class="form-group">
            <label for="address">Your Quote</label>
            <textarea class="form-control" id="quotemsg" rows="3" placeholder="Enter your quote here" required></textarea>
            </div>
            <p id="err" style="color:red"></p>
                    <br><br>
                    <center><button class="btn btn-success" onclick="sendWhatsAppMessage()">Send through WhatsApp</button></center>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to logout?
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" style="padding:.65rem;" data-bs-dismiss="modal">No</button>
                <button onclick="window.open('logout.php','_self')" class="btn btn-primary">Yes</button>
            </div>
        </div>
    </div>
</div>

    <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="laptop_student.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Best Laptops For Students</h5>
                    <p>Optimal laptops for students combine portability, reliable performance, and long battery life</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="officeautomationbanner.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Best Services for Office and Home Automation</h5>
                    <p>
                        Streamlining your spaces, from office to home, with unparalleled automation excellence.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="cctv_banner.jpg" class="d-block w-100">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Best Quality CCTV Services</h5>
                    <p>Elevate your security with CCTV excellence, safeguarding what matters most, seamlessly integrated.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

<?php
$conn = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");

$category_id = $_GET['category_id'] ?? ''; // Get category ID from URL parameter

$sql = "SELECT DISTINCT category FROM Product;"; // Select distinct categories
$category_result = $conn->query($sql);

while ($category_row = $category_result->fetch_assoc()) {
$category = $category_row["category"];
$category_id_for_comparison = strtolower(substr($category, 0, 3)); // Take first 3 characters and convert to lowercase
    echo '<h2 style="margin-top:20px;color:white" id="'. $category_id_for_comparison .'" class="text-center">'. $category .'</h2>'; // Display category in h2 tag with unique ID and center it
    echo '<div class="row" id="product-container">';    
    if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $sql_products = "SELECT * FROM Product WHERE category='$category' AND (product_name LIKE '%$search%' OR product_description LIKE '%$search%') ORDER BY rand();";
} else {
    $sql_products = "SELECT * FROM Product WHERE category='$category' ORDER BY rand();";
}

    $result = $conn->query($sql_products);
    
    if ($result->num_rows > 0) {
        $counter = 0; // Initialize counter to keep track of cards in a row
        while ($row = $result->fetch_assoc()) {
           echo '<div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex">';

echo '    <div class="card flex-fill" data-aos="fade-right">';
echo '     <img src="/home/' . $row["product_image"] . '" class="card-img-top img-fluid mx-auto d-block" style="opacity:0.8;max-height: 200px;object-fit: contain;background-color: #f0f0f0; /* to fill empty space */" alt="' . $row["product_image"] . '">';
echo '        <div class="card-body d-flex flex-column" style="height: 100%;">';
echo '            <center><h5 class="card-title">' . $row["product_name"] . '</h5></center>';
echo '            <center><p class="card-text">' . $row["product_description"] . '</p></center>';
$total=($row["product_price"]*100)/(100-$row["product_discount"]);
echo '            <center><p class="card-text">Price : Rs.' . round($total). '</p></center>';
echo '            <center><p class="card-text">' . $row["product_discount"] . '% off - Rs.' . $row["product_price"] . '</p></center>';
$stock = $row["stock"];

if ($stock=="in_stock") {
    echo '<center><p class="card-text text-success">In Stock</p></center>';
} elseif ($stock=="few_left") {
    echo '<center><p class="card-text text-warning">Few Left</p></center>';
} else {
    echo '<center><p class="card-text text-danger">Unavailable</p></center>';
}

echo '            <form action="addtocart.php" method="post">';
echo '                <input type="hidden" name="item" value="' . $row["product_name"] . '">';
echo '                <input type="hidden" name="value" value="' . $row["product_price"] . '">';
echo '                <input type="hidden" name="image" value="' . $row["product_image"] . '">';
echo '                <input type="hidden" name="description" value="' . $row["product_description"] . '">';
if ($stock!="out_of_stock") {
    echo '                <center><input type="submit" class="cart btn btn-info mt-3" value="Add to Cart"></center>';

} else {
    echo '                <center><input type="submit" class="cart btn btn-info mt-3" value="Add to Cart" disabled></center>';

}

echo '            </form>';
echo '        </div>';
echo '    </div>';
echo '</div>';

    
            $counter++;
            if ($counter % 4 == 0) {
                // Close the row after every fourth card
                echo '</div><div class="row"><center>';
            }
        }
    } else {
        echo "<center style='font-size:36px;margin:100px'>No product found !</center>";
    }
    
    echo '</div>'; // Close the last row
}

$conn->close();
?>

<script src="scroll.js">
  
</script>

        <div class="container text-center custom-laptop-section py-5" data-aos="fade-up">
            <h2 class="section-heading stylelapi">Custom Laptop Solutions</h2>
            <p class="fs-2">Any Custom laptop Demand? We've got you covered! Contact us on WhatsApp for personalized
                solutions.</p>
            <div class="whatsapp-container d-flex flex-column align-items-center">
                <img src="whatsapp.png" alt="WhatsApp Icon" class="whatsapp-icon img-fluid" style="width: 5rem;">
                <p class="whatsapp-text fs-4">Contact us on WhatsApp</p>
                <a href="whatsapp://send?phone=+919930731158&text=hello" target="_blank"
                    class="btn btn-primary mt-2">Chat Now</a>
            </div>
            <p class="get-quote-text mt-4">Or click <a class="get-quote-link" id="gq">here</a> to get a quote through
                our website.</p>
        </div>
    </section>
   
           
    <footer id="ftr" class="blockquote-footer">
        <div class="social-media">
            <a href="https://www.youtube.com/@kingsalman7867"><i style="padding:0rem !important;margin:0.5rem !important;font-size:20px" class="fa-brands fa-youtube"></i></a>
            <a href="https://instagram.com/oversquareleg_45?igshid=NTc4MTIwNjQ2YQ=="><i style="padding:0rem !important;margin:0.5rem !important;font-size:20px"
                    class="fa-brands fa-instagram"></i></a>
            <a href="https://www.facebook.com/artdhope/"><i style="padding:0rem !important;margin:0.5rem !important;font-size:20px" class="fa-brands fa-facebook"></i></a>
        </div>
    </footer>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        AOS.init({
            duration: 1000, // Set the animation duration (in milliseconds)
            once: false, // Only animate elements once
        });
         var getQuote= document.getElementById('gq');
        var getQuoteBtn = document.getElementById('getQuoteBtn');

        if (getQuoteBtn) {
            getQuoteBtn.addEventListener('click', function () {
                var quoteModal = new bootstrap.Modal(document.getElementById('quoteModal'));
                quoteModal.show();
            });
          getQuote.addEventListener('click', function () {
                var quoteModal = new bootstrap.Modal(document.getElementById('quoteModal'));
                quoteModal.show();
            });      
        }
function sendWhatsAppMessage() {
    var name = document.getElementById('quoteName').value;
    var quote = document.getElementById('quotemsg').value;

    var message = "Name: " + name + "%0AQuote: " + quote;
    if(name.length<=5||quote.length<=5)
    document.getElementById("err").textContent="Too small data minimum 5 characters for each field !";
    else
    window.open("https://wa.me/+919930731158/?text=" + message, "_blank");
}
document.getElementById('liveSearchInput').addEventListener('input', function () {
    let query = this.value;

    fetch('./fetchproduct.php?search=' + encodeURIComponent(query))
        .then(response => response.json())
      .then(data => {
    const container = document.getElementById('product-container');
    container.innerHTML = '';

    if (data.length === 0) {
        container.innerHTML = "<center style='font-size:36px;margin:100px'>No product found!</center>";
        return;
    }

    // Group products by category
    const categoryGroups = {};
    data.forEach(product => {
        if (!categoryGroups[product.category]) {
            categoryGroups[product.category] = [];
        }
        categoryGroups[product.category].push(product);
    });

    // Only display categories that have products
    for (const [category, products] of Object.entries(categoryGroups)) {
        // Category header
        const categoryHeader = `<h2 class="my-4">${category}</h2>`;
        container.innerHTML += categoryHeader;

        // Products
        let productCards = '<div class="row">';
        products.forEach(row => {
            const stockClass = row.stock === "in_stock" ? 'text-success' :
                               row.stock === "few_left" ? 'text-warning' :
                               'text-danger';
            const isDisabled = row.stock === "out_of_stock" ? 'disabled' : '';
            const totalPrice = Math.round((row.product_price * 100) / (100 - row.product_discount));

            productCards += `
            <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex">
                <div class="card flex-fill" style="width: 18rem;" data-aos="fade-right">
                    <img src="/home/${row.product_image}" class="card-img-top img-fluid mx-auto d-block"
                        style="opacity:0.8;max-height: 200px;object-fit: contain;background-color: #f0f0f0;"
                        alt="${row.product_image}">
                    <div class="card-body d-flex flex-column">
                        <center><h5 class="card-title">${row.product_name}</h5></center>
                        <center><p class="card-text">${row.product_description}</p></center>
                        <center><p class="card-text">Price : Rs.${totalPrice}</p></center>
                        <center><p class="card-text">${row.product_discount}% off - Rs.${row.product_price}</p></center>
                        <center><p class="card-text ${stockClass}">${row.stock.replace('_', ' ')}</p></center>
                        <form action="addtocart.php" method="post">
                            <input type="hidden" name="item" value="${row.product_name}">
                            <input type="hidden" name="value" value="${row.product_price}">
                            <input type="hidden" name="image" value="${row.product_image}">
                            <input type="hidden" name="description" value="${row.product_description}">
                            <center><input type="submit" class="cart btn btn-info mt-3" value="Add to Cart" ${isDisabled}></center>
                        </form>
                    </div>
                </div>
            </div>`;
        });
        productCards += '</div>';
        container.innerHTML += productCards;
    }
});

        
});
</script>

    
</body>

</html>
