<?php
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $selected_image = trim($_POST['selected_image']);
    $password_segments = trim($_POST['password_segments']);
    $confirm_password_segments = trim($_POST['confirm_password_segments']);

    // Check for empty fields
    if (empty($email) || empty($selected_image) || empty($password_segments) || empty($confirm_password_segments)) {
        die("Please fill out all the fields.");
    }

    // Confirm password match
    if ($password_segments !== $confirm_password_segments) {
        die("Passwords do not match.");
    }

    // Check if email exists in DB
    $check_user = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check_user->bind_param("s", $email);
    $check_user->execute();
    $result = $check_user->get_result();

    if ($result->num_rows === 0) {
        die("No account found with this email.");
    }

    // Update password
    $update = $conn->prepare("UPDATE users SET selected_image = ?, password_segments = ? WHERE email = ?");
    $update->bind_param("sss", $selected_image, $password_segments, $email);

    if ($update->execute()) {
        echo "Password reset successful. Redirecting to login...";
        header("Refresh: 2; URL=login.html");
        exit();
    } else {
        echo "Error: " . $update->error;
    }

    $check_user->close();
    $update->close();
    $conn->close();
}
?>
