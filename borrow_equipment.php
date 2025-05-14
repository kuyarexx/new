<?php

$conn = new mysqli("localhost", "root", "", "ems");

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed"]));
}

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $conn->real_escape_string($data['user_id']);
$user_fullname = $conn->real_escape_string($data['user_fullname']);
$equipment_list = $data['equipment'];

$errors = [];

foreach ($equipment_list as $item) {
    $serial = $conn->real_escape_string($item['serial']);
    $name = $conn->real_escape_string($item['name']);

    $insertQuery = "INSERT INTO borrow_records (user_id, user_fullname, equipment_serial, equipment_name, date_borrowed, status)
                    VALUES ('$user_id', '$user_fullname', '$serial', '$name', NOW(), 'Borrowed')";

    if (!$conn->query($insertQuery)) {
        $errors[] = "Insert error: " . $conn->error;
        continue;
    }

    $updateQuery = "UPDATE equipment SET status = 'Borrowed' WHERE serialNumber = '$serial'";

    if (!$conn->query($updateQuery)) {
        $errors[] = "Update error: " . $conn->error;
    }
}

if (empty($errors)) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => implode(", ", $errors)]);
}

$conn->close();
?>
