<?php
include('db_connect.php');

if (isset($_GET['userid'])) {
    $userid = $_GET['userid'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE userid = ?");
    $stmt->bind_param("s", $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "❌ User ID is already taken.";
    } else {
        echo "✅ User ID is available.";
    }

    $stmt->close();
    $conn->close();
}
?>
