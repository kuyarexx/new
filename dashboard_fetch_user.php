<?php
$conn = new mysqli("localhost", "root", "", "ems");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['id_number'])) {
    $id_number = $conn->real_escape_string($_POST['id_number']);

    $query = "SELECT full_name FROM users WHERE id_number = '$id_number'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(["success" => true, "full_name" => $row['full_name']]);
    } else {
        echo json_encode(["success" => false, "message" => "User not found"]);
    }
}
$conn->close();
?>
