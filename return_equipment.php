<?php
include 'db_connection.php';

$data = json_decode(file_get_contents("php://input"), true);
$serial = $data['serial'] ?? '';
$userId = $data['user_id'] ?? '';

$response = ['status' => 'error'];

if (!empty($serial) && !empty($userId)) {
    $stmt1 = $conn->prepare("UPDATE equipment SET status = 'available' WHERE serialNumber = ?");
    $stmt1->bind_param("s", $serial);
    $stmt1->execute();
    $stmt1->close();

    $stmt2 = $conn->prepare("UPDATE borrow_records SET status = 'Returned', date_returned = NOW() WHERE user_id = ? AND equipment_serial = ? AND status = 'Borrowed'");
    $stmt2->bind_param("ss", $userId, $serial);
    $stmt2->execute();
    $stmt2->close();

    $response['status'] = 'success';
    $response['message'] = 'Equipment returned successfully.';
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
?>
