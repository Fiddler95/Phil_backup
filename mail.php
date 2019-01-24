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

$sql = "SELECT Username FROM users WHERE Username = '$myusername'";					//utilizzo due variabili flag per individuare se l'username o la mail
$result = mysqli_query($conn,$sql);													//sono già stati utilizzati.
$count = mysqli_num_rows($result);
$usrFlag = 0;
if($count == 0){
    $usrFlag = 1;
}


$sql = "SELECT Email FROM users WHERE Email = '$mymail'";
$result = mysqli_query($conn,$sql);
$count = mysqli_num_rows($result);
$mailFlag = 0;
if($count == 0){
    $mailFlag = 1;
}

if($usrFlag == 1 && $mailFlag == 1) {													//se username e mail sono unici, procedo con l'invio della mail

    $url = "http://www.philvideos.org/register.php?email=" . $mymail . "&user=" . $myusername . "&pwd=" . $mypassword . "&name=" . $myname . "&surname=" . $mysurname;

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
        $mail->addAddress($mymail, $myusername);     // Add a recipient
        $mail->addReplyTo('support@philvideos.org', 'Information');


        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Account Verification';
        $mail->Body    = "Hello there <b>".$myusername."!</b><br>
                                    Thank you very much for your registration!<br>
                                    We hope you will enjoy the service we provide and help us grow as a community!<br>
                                    Before you go back to the website, here are your credentials:<br><br>
                                    Username: ".$myusername."<br>
                                    Password: ".$mypassword."<br><br>
                                    In order to verify your account, please click on the link below.<br>
                                    <a href= $url><b>Verify your account!</b></a><br><br>
                                    Remember: you can always change your password in your profile page<br>
                                    Have a nice day! ;)<br><br><br>
                                    The Philvideos Team";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }

}
else{
    if($usrFlag == 0){
        $message = "Errore, username già in uso.";
    }else if($mailFlag == 0){
        $message = "Errore, mail già in uso.";
    }
    echo "<script type='text/javascript'>
		alert('$message');
	    window.location.replace(\"home_Private.php\");
      </script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <link href="style.css" rel = "stylesheet" type = "text/css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div style="background-color: lightgoldenrodyellow; width: 100%; height: 100%; position: fixed">
    <div style="width: 50%; height: 50%; margin: 2% auto">
        <img class="img_search_bar" src="pics/wait.jpg" alt="wait" style="border-radius: 100%"/>
        <h1 style="text-align: center">Almost there!</h1>
        <h4 style="text-align: center">Thank you for your registration! We have sent an email to the registered address in order to verify your account. Please remember to check your spam folder.<br>
            Depending on the mail service you provided, this might take a while. If you don't receive an email in the next few minutes please write to the following address, stating the username and the email address that you provided. </h4>
        <p style="text-align: center">support@philvideos.org</p>
        <button class="reviewBtn" style="background-color: #408b40;margin:0 auto; display:block;" onClick="document.location.href='home.php'">Back to Home</button>
    </div>
</div>
</body>
</html}