<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_number = $_POST['id_number'];
    $full_name = $_POST['full_name'];
    $year = $_POST['year'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE users SET full_name = ?, year = ?, email = ? WHERE id_number = ?");
    $stmt->bind_param("ssss", $full_name, $year, $email, $id_number);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User updated successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
