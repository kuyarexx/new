<?php
include 'db_connection.php';

header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recordID = isset($_POST['recordID']) ? trim($_POST['recordID']) : '';
    $equipmentSerial = isset($_POST['equipmentSerial']) ? trim($_POST['equipmentSerial']) : '';

    if (empty($recordID) || empty($equipmentSerial)) {
        echo json_encode(["success" => false, "message" => "Missing required fields."]);
        exit;
    }

    $updateStmt = $conn->prepare("UPDATE borrow_records SET status = 'Returned', date_returned = NOW() WHERE id = ?");
    $updateStmt->bind_param("s", $recordID);
    if ($updateStmt->execute()) {
        $updateEquip = $conn->prepare("UPDATE equipment SET status = 'Available', personAccountable = NULL WHERE serialNumber = ?");
        $updateEquip->bind_param("s", $equipmentSerial);
        $updateEquip->execute();
        echo json_encode(["success" => true, "message" => "Equipment returned successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update borrow record."]);
    }

    $updateStmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>
