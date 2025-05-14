<?php
include 'db_connection.php';

$serial = $_GET['serial'] ?? '';
$response = ['exists' => false, 'available' => false];

if (!empty($serial)) {
    $stmt = $conn->prepare("SELECT status, equipmentName FROM equipment WHERE serialNumber = ?");
    $stmt->bind_param("s", $serial);
    $stmt->execute();
    $stmt->bind_result($status, $name);

    if ($stmt->fetch()) {
        $response['exists'] = true;
        $response['available'] = (strtolower($status) === 'available');
        $response['equipment_name'] = $name;
    }

    $stmt->close();
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
?>
