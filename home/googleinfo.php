<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}

$username = $_SESSION['username'];

$conn = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch existing email
$email = "";
$sql = "SELECT email FROM Account WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($email);
$stmt->fetch();
$stmt->close();

$success = "";
$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        $error = "Please enter a valid 10-digit phone number.";
    } else {
        $update = $conn->prepare("UPDATE Account SET phone = ?, address = ? WHERE username = ?");
        $update->bind_param("sss", $phone, $address, $username);
        if ($update->execute()) {
             header("Location: index.php");
    exit;
        } else {
            $error = "❌ Failed to update information.";
        }
        $update->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Complete Profile</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous"/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="index.css" />
  <link rel="icon" type="image/x-icon" href="/tablogo.png" />
  <style>
    .login-container { margin-top: 5%; }
    .form-text { color: red; }
  </style>
</head>
<body style="background-color: black;">
<div class="container" style="margin-top:5%;">
  <div class="row justify-content-center">
    <div class="col-md-6 col-sm-8 col-10" style="background-color: white;border:10px solid white;border-radius:10px!important">
      <div class="login-container">
        <div class="text-center mb-4">
          <h2>Complete Your Profile</h2>
        </div>

        <?php if ($success): ?>
          <div class="alert alert-success text-center"><?php echo $success; ?></div>
        <?php elseif ($error): ?>
          <div class="alert alert-danger text-center"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="googleinfo.php" style="padding-bottom: 10px;">
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" readonly class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
          </div>

          <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter 10-digit phone number" required pattern="[0-9]{10}">
          </div>

          <div class="form-group">
            <label for="address">Address:</label>
            <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter address" required></textarea>
          </div>

          <button type="submit" class="btn btn-primary btn-block">Submit</button>
        </form>

        <div class="card footer" style="background-color:white;border:none;font-size:20px">
          <div class="card-body">
            <footer class="blockquote-footer text-center">
              <div class="footer-logo"><img src="blacklogo.png" alt="logo" style="width:150px;"></div>
              <div class="copyright">© 2023 Asmi Enterprises</div>
            </footer>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
