<?php
header('Content-Type: application/json'); // Optional: set response type

$connection = new mysqli("localhost", "root", "", "ems");

if ($connection->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Connection failed: " . $connection->connect_error]);
    exit();
}

// Decode JSON input
$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->serialNumber)) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid or missing data"]);
    exit();
}

$query = "UPDATE equipment SET 
    equipmentName = ?, 
    brand = ?, 
    yearPurchased = ?, 
    propertyNumber = ?, 
    modelNumber = ?, 
    acquisitionDate = ?, 
    acquisitionCost = ?, 
    personAccountable = ?, 
    location = ?, 
    status = ?
    WHERE serialNumber = ?";

$stmt = $connection->prepare($query);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(["error" => "Prepare failed: " . $connection->error]);
    exit();
}

$stmt->bind_param("sssssssssss", 
    $data->equipmentName,
    $data->brand,
    $data->yearPurchased,
    $data->propertyNumber,
    $data->modelNumber,
    $data->acquisitionDate,
    $data->acquisitionCost,
    $data->personAccountable,
    $data->location,
    $data->status,
    $data->serialNumber
);

if ($stmt->execute()) {
    echo json_encode(["message" => "Updated"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Error updating: " . $stmt->error]);
}

$stmt->close();
$connection->close();
?>
