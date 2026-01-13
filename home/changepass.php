<?php
session_start(); // Start the session
if (!isset($_SESSION['username']) && isset($_COOKIE['ae_username'])) {

    $_SESSION['username'] = $_COOKIE['ae_username'];
}

if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: login.html");
    exit(); // Stop script execution
}
// Assuming $currentUser is set in a previous part of your code
$currentUser = isset($_SESSION['username']) ? $_SESSION['username'] : '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Password</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="index.css">
  <link rel="icon" type="image/x-icon" href="/tablogo.png">
  
  <style>
.login-container {
  margin-top: 5%;
}

#back {
  color: white;
  font-size: 24px;
  position: fixed;
  top: 15px;
  left: 15px;

}

.password-toggle {
  border: none;
  position: absolute; 
  right:0;
  top:5px;
  background-color:transparent!important ;
  cursor: pointer;
}
.input-group-text {
  background-color: white; /* Add this to ensure the background is white */
  z-index: 1; /* Add this to make sure the input field is above the icon */
}

.form-group {
  position: relative; /* Add this to make it a positioned container for relative positioning */
}

  .password-toggle[disabled] i {
    visibility: hidden;
  }
  </style>
  
</head>
<body style="background-color: black;">
<i onclick="window.open('index.php','_self')" id="back" class="fas fa-solid fa-arrow-left"></i>
<div class="container" style="margin-top:5%;">
  <div class="row justify-content-center">
    <div class="col-md-6 col-sm-8 col-10" style="background-color: white;border:10px solid white;border-radius:10px!important">
      <div class="login-container">
        <div class="text-center mb-4">
          <h2>Change Your Password</h2>
        </div>
        <form  onsubmit="validatePassword(event)" action="updatepass.php" style="padding-bottom: 10px;" method="post">
          <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php
                      echo $currentUser;
              ?>" readOnly>
          </div>
          <div class="form-group">
            <label for="password">Last Password:</label>
            <div class="input-group">
              <input type="password" class="form-control" id="lastPassword" name="password"  required>
              <div class="input-group-append">
                <span class="input-group-text password-toggle" onclick="togglePasswordVisibility('lastPassword', 'eyeIcon')"><i id="eyeIcon" class="fas fa-eye"></i></span>
              </div>
            </div>
          </div>
           <div class="form-group">
            <label for="password">New Password:</label>
            <div class="input-group">
              <input type="password" class="form-control" id="newPassword" name="npass" disabled required>
              <div class="input-group-append">
                
              <span class="input-group-text password-toggle" onclick="togglePasswordVisibility('newPassword','eyeIconNew')"><i style="visibility:hidden" id="eyeIconNew" class="fas fa-eye"></i></span>
              </div>
            </div>
          </div>
           <div class="row">
            <div class="col">
              <button type="button" class="btn btn-primary btn-block" onclick="checkPassword()">Check</button>
            </div>
            <div class="col">
              <button type="submit" class="btn btn-primary btn-block" id="changePasswordForm" disabled>Update</button>
            </div>
          </div>
        </form>
        <!-- Error message display area -->
        <div id="errorMessage" class="text-danger text-center mt-3"></div>
  <div id="err" class="text-danger text-center mt-3"></div>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
function checkPassword() {
    var lastPassword = document.getElementById("lastPassword").value;
    // Send AJAX request to check if the last password is valid
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "checkpass.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (xhr.responseText === 'valid') {
                document.getElementById("newPassword").disabled = false;
                document.getElementById("eyeIconNew").style.visibility = "visible"; // Show eye icon for new password
                document.getElementById("errorMessage").innerText = "";
                document.getElementById("changePasswordForm").removeAttribute("disabled");
            } else {
                document.getElementById("newPassword").disabled = true;
                document.getElementById("changePasswordForm").disabled = true;
                document.getElementById("eyeIconNew").style.visibility = "hidden"; // Hide eye icon for new password
                document.getElementById("errorMessage").innerText = "Invalid username or last password.";
            }
        }
    };
    xhr.send("lastPassword=" + lastPassword);
}
function togglePasswordVisibility(fieldId,id) {
    var passwordField = document.getElementById(fieldId);
    var eyeIcon = document.getElementById(id);

    if (passwordField.type === "password") {
      passwordField.type = "text";
      eyeIcon.className = "fas fa-eye-slash";

    } else {
      passwordField.type = "password";
      eyeIcon.className = "fas fa-eye";
      eyeIcon.style.visibility= "visible";
    }
}
function validatePassword(event) {
    var lastPassword = document.getElementById("lastPassword").value;
    var newPassword = document.getElementById("newPassword").value;

    // Reset error message
    document.getElementById("errorMessage").innerText = "";

    // Check if the new password is less than 8 characters
    if (newPassword.length < 8) {
        document.getElementById("errorMessage").innerText = "New password must be at least 8 characters long.";
         event.preventDefault(); // Stop further execution
    }

    // Check if the new password is the same as the last password
    if (lastPassword === newPassword) {
        document.getElementById("errorMessage").innerText = "New password must be different from the last password.";
          event.preventDefault(); // Stop further execution
    }

    document.getElementById("changePasswordForm").submit();
}
</script>

</body>
</html>
