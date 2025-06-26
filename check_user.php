<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'db_connect.php';

header('Content-Type: application/json');

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Adjust the query to check for email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo json_encode(["valid" => true]);
        } else {
            echo json_encode(["valid" => false]);
        }
        
        $stmt->close();
    } else {
        echo json_encode(["valid" => false, "error" => $conn->error]);
    }
} else {
    echo json_encode(["valid" => false, "error" => "Missing email"]);
}
?>