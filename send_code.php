<?php
// Include PHPMailer's autoloader
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Safely get email input
    $email = $_POST['email'] ?? '';
    $username = explode('@', $email)[0]; // Derive a username from email if not provided

    // Basic validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit();
    }

    // Generate a random 6-digit verification code
    $verificationCode = rand(100000, 999999);

    // Store in session
    $_SESSION['verification_code'] = $verificationCode;
    $_SESSION['email'] = $email;
    $_SESSION['username'] = $username;

    // Send the email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'shalushalini11223344@gmail.com'; // Your Gmail
        $mail->Password = 'lyxq xqfm eqpd rcjv'; // App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('shalushalini11223344@gmail.com', 'GraphicalPassword');
        $mail->addAddress($email, $username);

        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for Password Reset';
        $mail->Body = "
            <p>Hello <b>$username</b>,</p>
            <p>Your OTP for password reset is:</p>
            <h2>$verificationCode</h2>
            <p>If you didn’t request this, you can ignore this email.</p>
        ";

        $mail->send();

        // Redirect to verify_code.php
        header("Location: verify_code.php");
        exit();

    } catch (Exception $e) {
        echo "Error sending email: {$mail->ErrorInfo}";
    }
}
?>
