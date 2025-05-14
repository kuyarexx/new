<?php

$conn = new mysqli("localhost", "root", "", "ems");

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed"]));
}

if (isset($_GET['serial'])) {
    $serial = $conn->real_escape_string($_GET['serial']);
    $query = "SELECT equipmentName FROM equipment WHERE serialNumber = '$serial'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(["status" => "success", "equipmentName" => $row['equipmentName']]);
    } else {
        echo json_encode(["status" => "error", "message" => "Equipment not found"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Serial number not provided"]);
}

$conn->close();
?>
