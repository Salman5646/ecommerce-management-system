<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require __DIR__ . '/mail/Exception.php';
require __DIR__ . '/mail/PHPMailer.php';
require __DIR__ . '/mail/SMTP.php';
$un = $_POST["username"];
$email = $_POST["email"];
$_SESSION['un']=$un;
$con= mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");

$query = "SELECT * FROM Account WHERE username='$un'";

$result = mysqli_query($con, $query);

if ($row = mysqli_fetch_assoc($result)) {
    if ($email==$row['email']) {
        
        $mail = new PHPMailer;
$body="<h4>Hello $un</h4>This is recovery email to recover your password<br><br><a href='forgotpass.php'>Click here to recover password!</a>";
            $mail->isSMTP(); 

            $mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
            $mail->Host = "smtp.gmail.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
            $mail->Port = 587; // TLS only
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = 'asmientp24@gmail.com'; // email
            $mail->Password = 'ewrwerrsuswspqbb'; // password
            $mail->setFrom('asmientp24@gmail.com', 'Asmi Enterprises'); // From email and name
            $mail->addAddress($email, $un); // to email and name
            $mail->Subject = 'Forgot Password ? ';
            $mail->msgHTML($body);
            $mail->AltBody = 'HTML messaging not supported';
            
            if(!$mail->send()) {
                echo "Error sending email: " . $mail->ErrorInfo;
            }
        
        header("refresh:2;url=login.html");
        echo "Mail sent to your gmail account! ";
    } else {
        header("refresh:2;url=fpass.html");
        echo "Invalid Credentials! Try Again";
    }
} else {
    header("refresh:2;url=fpass.html");
    echo "Invalid Credentials! Try Again";
}
?>
