<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['un'])) {
    // Redirect to login page or display an error message
    header("Location: login.html"); // Redirect to login page
    exit; // Stop further execution
}
$un = $_SESSION['un'];
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and new password from the form
    $username = $un;
    $new_password = $_POST['password'];

    $conn = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");
    
   if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

    
    // Hash the new password before updating it in the database
    $hashedPass = password_hash($new_password, PASSWORD_BCRYPT);

$sql = "UPDATE Account SET password='$hashedPass' WHERE username='$username'";
   
    if ($conn->query($sql) === TRUE) {
         header("refresh:2;url=login.html");
         echo '<div class="alert alert-success" role="alert">Resetting your password...</div>';

    } else {
        header("refresh:2;url=forgotpass.php");
        echo "Error updating password: " . $conn->error;
    }
    
    // Close the connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="index.css">
  <link rel="icon" type="image/x-icon" href="/tablogo.png">
  
  <style>
    .login-container {
      margin-top: 5%;
      position: relative; /* Ensure positioning relative to the container */
    }

    .password-toggle {
        background-color:white;
        border:none;
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      cursor: pointer;
    }
  </style>
  
</head>
<body style="background-color: black;">

<div class="container" style="margin-top:5%;">
  <div class="row justify-content-center">
    <div class="col-md-6 col-sm-8 col-10" style="background-color: white;border:10px solid white;border-radius:10px!important">
      <div class="login-container">
        <div class="text-center mb-4">
          <h2>Reset Password </h2>
        </div>
<form action="forgotpass.php" style="padding-bottom: 10px;" method="post" onsubmit="checkPasswordLength(event)">
    <div class="form-group">
        <label for="username">Username:</label>
  <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" value="<?php
  echo $un; ?>" disabled>
    </div>
    <div class="form-group">
        <label for="password">New Password:</label>
        <div class="input-group">
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
            <div class="input-group-append">
                <span class="input-group-text password-toggle" onclick="togglePasswordVisibility()"><i id="eyeIcon" class="fas fa-eye"></i></span>
            </div>
        </div>
    </div>
  <span id="passwordError"></span>
  <br>
    <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
    
</form>
             <div class="card footer" style="background-color:white;border:none;font-size:20px">
            <div class="card-body">
            <footer class="blockquote-footer">
                <div class="footer-logo"><img src="blacklogo.png" alt="logo" style="width:150px;">
                </div>
              
                <div class="copyright">© 2023 Asmi Enterprises</div>
               
            </footer> 
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>

  function togglePasswordVisibility() {
    var passwordField = document.getElementById("password");
    var eyeIcon = document.getElementById("eyeIcon");
    
    if (passwordField.type === "password") {
      passwordField.type = "text";
      eyeIcon.className = "fas fa-eye-slash";
    } else {
      passwordField.type = "password";
      eyeIcon.className = "fas fa-eye";
    }
  }

  function checkPasswordLength(event) {
    var passwordField = document.getElementById("password");
    var password = passwordField.value;
    var errorText = document.getElementById("passwordError");

    if (password.length < 8) {
      errorText.innerHTML = "Password must be at least 8 characters long.";
      errorText.style.color = "red";
      event.preventDefault(); // Prevent form submission
    } else {
      errorText.innerHTML = ""; // Clear error message if password length is valid
    }
  }
</script>
</body>
</html>