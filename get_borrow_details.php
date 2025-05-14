<?php
include 'db_connection.php';

header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = isset($_POST['userID']) ? trim($_POST['userID']) : '';

    if (empty($userID)) {
        echo json_encode(["success" => false, "message" => "User ID is required."]);
        exit;
    }

    $stmt = $conn->prepare("SELECT id, equipment_serial, status FROM borrow_records WHERE user_id = ? AND status = 'Borrowed' LIMIT 1");
    if ($stmt === false) {
        echo json_encode(["success" => false, "message" => "SQL Prepare Error: " . $conn->error]);
        exit;
    }
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        echo json_encode(["success" => false, "message" => "No active borrow record found for this user."]);
        $stmt->close();
        $conn->close();
        exit;
    }

    $stmt->bind_result($recordId, $equipmentSerial, $borrowStatus);
    $stmt->fetch();
    $stmt->close();

    $equipStmt = $conn->prepare("SELECT equipmentName FROM equipment WHERE serialNumber = ?");
    if ($equipStmt === false) {
        echo json_encode(["success" => false, "message" => "SQL Prepare Error (Equipment): " . $conn->error]);
        exit;
    }
    $equipStmt->bind_param("s", $equipmentSerial);
    $equipStmt->execute();
    $equipStmt->store_result();
    $equipStmt->bind_result($equipmentName);
    $equipStmt->fetch();
    $equipStmt->close();

    echo json_encode([
        "success" => true,
        "recordId" => $recordId,
        "equipment_serial" => $equipmentSerial,
        "equipment_name" => $equipmentName,
        "user_id" => $userID,
        "borrow_status" => $borrowStatus
    ]);
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>
