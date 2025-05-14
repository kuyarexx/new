<?php
include 'db_connection.php';

$currentMonth = date("m");
if ($currentMonth >= 6) {
    $sql = "UPDATE users SET year = year + 1";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Years updated successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error updating years: " . $conn->error]);
    }
}

$conn->close();
?>
