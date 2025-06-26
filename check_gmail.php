<?php
include('db_connect.php');

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "❌ Gmail already registered.";
    } else {
        echo "✅ Gmail is allowed.";
    }

    $stmt->close();
    $conn->close();
}
?>
