<?php
$conn = new mysqli("localhost", "root", "", "ems");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['serialNumber'])) {
    $serialNumber = $conn->real_escape_string($_POST['serialNumber']);

    $query = "SELECT equipmentName FROM equipment WHERE serialNumber = '$serialNumber'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(["success" => true, "equipmentName" => $row['equipmentName']]);
    } else {
        echo json_encode(["success" => false, "message" => "Equipment not found"]);
    }
}
$conn->close();
?>
