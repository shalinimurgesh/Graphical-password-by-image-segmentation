<?php 
// Include database connection file
include('db_connect.php');



// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get POST values safely
    $userid = trim($_POST['userid']);
    $email = trim($_POST['email']);
    $selected_image = trim($_POST['selected_image']);
    $password_segments = trim($_POST['password_segments']);
    $confirm_password_segments = trim($_POST['confirm_password_segments']);

    // Simple validation
    if (empty($userid) || empty($email) || empty($selected_image) || empty($password_segments) || empty($confirm_password_segments)) {
        die("Please fill out all the fields.");
    }

    // Validate that the password sequences match
    if ($password_segments !== $confirm_password_segments) {
        die("Passwords do not match.");
    }

    // Check if User ID already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE userid = ?");
    $stmt->bind_param("s", $userid);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        die("User ID already exists.");
    }

    // Check if Email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        die("Email already registered.");
    }

    // Insert new user into database
    $stmt = $conn->prepare("INSERT INTO users (userid, email, selected_image, password_segments) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $userid, $email, $selected_image, $password_segments);

    if ($stmt->execute()) {
        // Redirect to login page after successful registration
        header('Location: login.html');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close everything
    $stmt->close();
    $conn->close();
}
?>
