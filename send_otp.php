<?php
// Include PHPMailer's autoloader
require 'vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and email from the form
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Generate a random verification code (6 digits)
    $verificationCode = rand(100000, 999999);

    // Start session to store the verification code and user details
    session_start();
    $_SESSION['verification_code'] = $verificationCode;
    $_SESSION['email'] = $email;
    $_SESSION['username'] = $username;

    // Send the verification code to the user's email
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = '#add your email id';  // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'GraphicalPassword';  // Replace with your Gmail email
        $mail->Password = ' ';  // Replace with your Gmail password (or App Password if 2FA enabled)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('#add your email id', 'Your College Name');
        $mail->addAddress($email, $username);  // Add user's email

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Forgot Password Verification Code';
        $mail->Body    = 'Hello ' . $username . ',<br><br>Here is your verification code: <b>' . $verificationCode . '</b><br><br>If you did not request a password reset, please ignore this email.';

        $mail->send();
        echo 'Verification code has been sent to your email.';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
