<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredCode = $_POST['code'] ?? '';
    $sessionCode = $_SESSION['verification_code'] ?? '';

    if ($enteredCode == $sessionCode) {
        header("Location: reset_password.html");
        exit();
    } else {
        $error = "❌ Invalid verification code. Please try again.";
    }
}
?>

<!-- verify_code.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enter OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 350px;
        }
        h2 {
            text-align: center;
        }
        input[type="text"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Verify OTP</h2>
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="verify_code.php">
            <label for="code">Enter the OTP sent to your email:</label>
            <input type="text" id="code" name="code" required>
            <input type="submit" value="Verify OTP">
        </form>
    </div>
</body>
</html>
