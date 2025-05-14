<?php
include 'db_connection.php';

if (isset($_GET['id_number'])) {
    $id_number = $_GET['id_number'];

    $stmt = $conn->prepare("SELECT year FROM users WHERE id_number = ?");
    $stmt->bind_param("s", $id_number);
    $stmt->execute();
    $stmt->bind_result($year);

    if ($stmt->fetch()) {
        echo json_encode(["success" => true, "year" => $year]);
    } else {
        echo json_encode(["success" => false, "message" => "User not found"]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Missing ID number"]);
}

$conn->close();
?>
