<?php
include 'db_connection.php';

$userId = $_POST['user_id'] ?? '';

$response = [];

if (!empty($userId)) {
    $stmt = $conn->prepare("SELECT equipment_serial, equipment_name FROM borrow_records WHERE user_id = ? AND status = 'Borrowed' AND date_returned IS NULL");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }

    $stmt->close();
    $conn->close();

    $response = [
        "status" => "success",
        "data" => $items
    ];
} else {
    $response = [
        "status" => "error",
        "message" => "Missing user ID"
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
