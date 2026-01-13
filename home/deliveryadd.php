<?php
session_start();

if (!isset($_SESSION['username']) && isset($_COOKIE['ae_username'])) {
    $_SESSION['username'] = $_COOKIE['ae_username'];
}

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$username = $_SESSION['username'];
$success = "";
$error = "";

// Connect to DB
$conn = new mysqli("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = trim($_POST['address']);

    // Validate address length
    if (strlen($address) < 15) {
        $error = "Address should be at least 15 characters long.";
    } else {
        $stmt = $conn->prepare("UPDATE Account SET address = ? WHERE username = ?");
        $stmt->bind_param("ss", $address, $username);
        if ($stmt->execute()) {
            $success = "Address updated successfully!";
        } else {
            $error = "Failed to update address.";
        }
        $stmt->close();
    }
}

// Fetch current address to display in textarea
$currentAddress = "";
$stmt = $conn->prepare("SELECT address FROM Account WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($currentAddress);
$stmt->fetch();
$stmt->close();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Delivery Address</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="index.css" />
  <link rel="icon" type="image/x-icon" href="/tablogo.png" />
  <style>
    .create-account-container {
      margin-top: 5%;
    }
    i {
      color: white;
      font-size: 24px;
      position: fixed;
      top: 15px;
      left: 15px;
      cursor: pointer;
    }
    .error {
      border-color: red;
    }
  </style>
</head>
<body style="background-color: black;">
<i onclick="window.open('index.php','_self')" class="fas fa-solid fa-arrow-left"></i>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6 col-sm-8 col-10" style="background-color: white;margin:30px auto;border:10px solid white;border-radius:10px!important">
      <div class="create-account-container">
        <div class="text-center mb-4">
          <h2>Your Delivery Address</h2>
        </div>

        <!-- Show success or error messages -->
        <?php if ($success): ?>
          <div class="alert alert-success text-center"><?php echo htmlspecialchars($success); ?></div>
        <?php elseif ($error): ?>
          <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form id="updateAddressForm" style="padding-bottom: 10px;" action="" method="post">
          <div class="form-group">
            <label for="address">Address:</label>
            <textarea class="form-control <?php echo $error ? 'error' : ''; ?>" id="address" name="address" rows="5" readonly><?php echo htmlspecialchars($currentAddress); ?></textarea>
            <div style="color:red" id="addressHelpBlock" class="form-text"></div>
          </div>
          <div class="row">
            <div class="col">
              <button type="button" id="editBtn" class="btn btn-primary btn-block">Edit</button>
            </div>
            <div class="col">
              <button type="submit" id="updateBtn" class="btn btn-primary btn-block" disabled>Update</button>
            </div>
          </div>
        </form>
      </div>
      <div class="card footer" style="background-color:white;border:none;font-size:20px">
        <div class="card-body">
          <footer class="blockquote-footer">
            <div class="footer-logo"><img src="blacklogo.png" alt="logo" style="width:150px;"></div>
            <div class="copyright">© 2023 Asmi Enterprises</div>
          </footer>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
document.getElementById('editBtn').addEventListener('click', function() {
  document.getElementById('address').readOnly = false;
  document.getElementById('updateBtn').disabled = false;
});

document.getElementById('updateAddressForm').addEventListener('submit', function(event) {
  // Optional: client side validation here
  var address = document.getElementById('address').value;
  if (address.length < 15) {
    event.preventDefault();
    document.getElementById('address').classList.add('error');
    document.getElementById('addressHelpBlock').textContent = 'Address should be at least 15 characters long.';
  }
});
</script>

</body>
</html>
