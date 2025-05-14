<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ems";

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "No equipment ID provided"]);
    exit;
}

$id = intval($_GET['id']);

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM equipment WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$data = $result->fetch_assoc();
$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
