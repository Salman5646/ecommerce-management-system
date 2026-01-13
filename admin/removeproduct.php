<?php
$conn = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$msg = "";
$productData = null;

// Handle product deletion (Remove)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['remove'])) {
    $productToRemove = mysqli_real_escape_string($conn, $_POST['product']);
    $deleteQuery = "DELETE FROM Product WHERE product_name = '$productToRemove'";
    if (mysqli_query($conn, $deleteQuery)) {
        $msg = "✅ Product removed successfully!";
    } else {
        $msg = "❌ Error removing product: " . $conn->error;
    }
}

// Handle product display (after AJAX selection)
if ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST['remove'])) {
    $selectedProduct = mysqli_real_escape_string($conn, $_POST['product']);
    $fetchQuery = "SELECT * FROM Product WHERE product_name = '$selectedProduct' LIMIT 1";
    $result = mysqli_query($conn, $fetchQuery);
    if ($result && mysqli_num_rows($result) > 0) {
        $productData = mysqli_fetch_assoc($result);
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Remove Product</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
</head>
<body style="background-color: black;">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6 bg-white p-4 rounded">
        <h2 class="text-center mb-4">Remove Product</h2>

        <?php if ($msg): ?>
          <div class="alert alert-info text-center"><?= htmlspecialchars($msg) ?></div>
          <script>
            setTimeout(() => window.location.href = 'removeproduct.php', 2000);
          </script>
        <?php endif; ?>

        <form id="removeForm" method="post" action="removeproduct.php">
          <div class="form-group">
            <label>Category</label>
            <select id="cat" class="form-control" name="category" required>
              <option selected>Select product category</option>
              <option>Laptop & Desktop</option>
              <option>Computer Accessories</option>
              <option>Anti Virus</option>
              <option>Printers,Routers & Switches</option>
              <option>CCTV Services</option>
              <option>Home and Office Automation</option>
            </select>
            <div id="categoryHelpBlock" class="form-text"></div>
          </div>

          <div class="form-group">
            <label>Product</label>
            <select id="product" class="form-control" name="product" required>
              <option selected>Select product</option>
            </select>
            <div id="productHelpBlock" class="form-text"></div>
          </div>

          <button type="submit" name="view" class="btn btn-primary btn-block">View Product</button>
        </form>

        <!-- Product Card Display -->
        <?php if ($productData): ?>
          <div class="card mt-4 mx-auto" style="max-width: 20rem;">
            <img src="/home/<?= htmlspecialchars($productData['product_image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($productData['product_name']) ?>" style="height:260px; object-fit:cover;">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($productData['product_name']) ?></h5>
              <p class="card-text"><?= htmlspecialchars($productData['product_description']) ?></p>
              <p class="card-text"><strong>Price:</strong> ₹<?= number_format($productData['product_price']) ?></p>
              <p class="card-text"><strong>Discount:</strong> <?= htmlspecialchars($productData['product_discount']) ?>%</p>
            </div>
          </div>
          <!-- Remove Button -->
          <form method="post" action="removeproduct.php" class="mt-3 text-center">
            <input type="hidden" name="product" value="<?= htmlspecialchars($productData['product_name']) ?>">
            <button type="submit" name="remove" class="btn btn-danger">Remove This Product</button>
          </form>
        <?php endif; ?>

        <!-- Footer -->
        <div class="text-center mt-4">
          <img src="blacklogo.png" alt="logo" style="width:150px;"><br>
          <small class="text-muted">&copy; 2023 Asmi Enterprises</small>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Preserve your AJAX category->product logic -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      function getProductsByCategory() {
        var cat = document.getElementById("cat").value;
        var productDropdown = document.getElementById("product");
        productDropdown.innerHTML = '<option selected>Select product</option>';

        var xhr = new XMLHttpRequest();
        xhr.open("GET", "getproducts.php?category=" + encodeURIComponent(cat), true);
        xhr.onload = function() {
          if (xhr.status === 200) {
            var products = JSON.parse(xhr.responseText);
            products.forEach(function(p) {
              var opt = document.createElement("option");
              opt.text = opt.value = p;
              productDropdown.add(opt);
            });
          }
        };
        xhr.send();
      }
      function validateForm() {
        var p = document.getElementById("product");
        var err = document.getElementById("productHelpBlock");
        if (!p.value || p.value === "Select product" || p.value === "No items to show") {
          err.innerText = "Please select a product.";
          return false;
        }
        err.innerText = "";
        return true;
      }
      document.getElementById("cat").addEventListener("change", getProductsByCategory);
      document.getElementById("removeForm").addEventListener("submit", function(e) {
        if (!validateForm()) e.preventDefault();
      });
    });
  </script>
</body>
</html>
