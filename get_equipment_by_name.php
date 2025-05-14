<?php
include 'db_connection.php';

if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $stmt = $conn->prepare("SELECT serialNumber, equipmentName, status FROM equipment WHERE equipmentName = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    $equipmentList = [];
    while ($row = $result->fetch_assoc()) {
        $equipmentList[] = $row;
    }

    echo json_encode($equipmentList);
    $stmt->close();
    $conn->close();
}
?>
