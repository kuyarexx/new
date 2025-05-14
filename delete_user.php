<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_number = $_POST['id_number'];

    $stmt = $conn->prepare("DELETE FROM users WHERE id_number = ?");
    $stmt->bind_param("s", $id_number);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User deleted successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
