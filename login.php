 <?php
// db_connect.php connection
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userid = $_POST['username'];
    $email = $_POST['email'];
    $selected_image = $_POST['selected_image'];
    $password_sequence = $_POST['password_sequence'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE userid = ? AND email = ?");
    $stmt->bind_param("ss", $userid, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($user['selected_image'] === $selected_image && $user['password_segments'] === $password_sequence) {
            echo json_encode(['valid' => true]);  // ONLY success flag
        } else {
            echo json_encode(['valid' => false]);  // Wrong image or sequence
        }
    } else {
        echo json_encode(['valid' => false]);  // No such user
    }

    $stmt->close();
    $conn->close();
}
?>