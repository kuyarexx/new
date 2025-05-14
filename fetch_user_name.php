<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "ems";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_number = $_POST['id_number'];

$sql = "SELECT full_name FROM users WHERE id_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id_number);
$stmt->execute();
$result = $stmt->get_result();

$response = ["status" => "not_found"];

if ($row = $result->fetch_assoc()) {
    $response = [
        "status" => "success",
        "full_name" => $row['full_name']
    ];
}

echo json_encode($response);
$conn->close();
?>
