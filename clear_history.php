<?php
include 'db_connection.php';

header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

$data = json_decode(file_get_contents("php://input"), true);
$password = isset($data['password']) ? $data['password'] : '';

$correctPassword = 'SECRET';

if ($password !== $correctPassword) {
    echo json_encode(["success" => false, "message" => "Incorrect password."]);
    exit;
}

$checkQuery = "SELECT COUNT(*) AS total FROM borrow_records WHERE status = 'Returned'";
$result = $conn->query($checkQuery);

if ($result) {
    $row = $result->fetch_assoc();
    if ($row['total'] == 0) {
        echo json_encode(["success" => false, "message" => "No returned equipment to clear."]);
        $conn->close();
        exit;
    }
} else {
    echo json_encode(["success" => false, "message" => "Error checking records: " . $conn->error]);
    $conn->close();
    exit;
}

$sql = "DELETE FROM borrow_records WHERE status = 'Returned'";
if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true, "message" => "Returned equipment history cleared successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Error deleting records: " . $conn->error]);
}

$conn->close();
?>
