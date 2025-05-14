<?php
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_number = $_POST['id_number'];
    $serialNumber = $_POST['serialNumber'];

    $user_query = $conn->prepare("SELECT full_name FROM users WHERE id_number = ?");
    $user_query->bind_param("s", $id_number);
    $user_query->execute();
    $user_result = $user_query->get_result();

    if ($user_result->num_rows > 0) {
        $user_data = $user_result->fetch_assoc();
        $full_name = $user_data['full_name'];

        $equipment_query = $conn->prepare("SELECT equipmentName FROM equipment WHERE serialNumber = ?");
        $equipment_query->bind_param("s", $serialNumber);
        $equipment_query->execute();
        $equipment_result = $equipment_query->get_result();

        if ($equipment_result->num_rows > 0) {
            $equipment_data = $equipment_result->fetch_assoc();
            $equipmentName = $equipment_data['equipmentName'];

            echo json_encode(["success" => true, "full_name" => $full_name, "equipmentName" => $equipmentName]);
        } else {
            echo json_encode(["success" => false, "message" => "Serial Number not found in the database."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "User ID not found in the database."]);
    }
}
?>
