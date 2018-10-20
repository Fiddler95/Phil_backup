<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 20/10/2018
 * Time: 15:44
 */
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
include 'functions.php';


$username = $_POST['username'];
$pwd_l=rand(8,15);
$password = generate_pwd($pwd_l);
$name = 	$_POST["name"];
$surname = $_POST["surname"];
$mail = 	$_POST["mail"];

$myusername = mysqli_real_escape_string($conn,$username);
$mypassword = mysqli_real_escape_string($conn,$password);
$myname = mysqli_real_escape_string($conn,$name);
$mysurname = mysqli_real_escape_string($conn,$surname);
$mymail = mysqli_real_escape_string($conn,$mail);

$url = "http://localhost/main.php?email=" . $email_address . "&event_id=" . $event_id;

echo $myusername."<br>";
echo $mypassword."<br>";
echo $mymail."<br>";
echo $myname."<br>";
echo $mysurname."<br>";

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'n3plcpnl0154.prod.ams3.secureserver.net';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'support@philvideos.org';                 // SMTP username
    $mail->Password = 'iFa6ceN6ZWdl';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('support@philvideos.org', 'Philvideos Team');
    $mail->addAddress($mymail, 'Real Mail');     // Add a recipient
    $mail->addReplyTo('support@philvideos.org', 'Information');


    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = "Hello there <b>".$myusername."!</b><br>
                                    Thank you very much for your registration!<br>
                                    We hope you will enjoy the service we provide and help us grow as a community!<br>
                                    Before you go back to the website, here are your credentials:<br><br>
                                    Username: ".$myusername."<br>
                                    Password: ".$mypassword."<br><br>
                                    Remember: you can always change your password in your profile page<br>
                                    Have a nice day! ;)<br><br><br>
                                    The Philvideos Team";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}