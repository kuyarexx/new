<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "ems";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$total = $conn->query("SELECT COUNT(*) AS count FROM equipment")->fetch_assoc()['count'];
$available = $conn->query("SELECT COUNT(*) AS count FROM equipment WHERE status = 'available'")->fetch_assoc()['count'];
$borrowed = $conn->query("SELECT COUNT(*) AS count FROM equipment WHERE status = 'borrowed'")->fetch_assoc()['count'];

echo json_encode([
    'total' => $total,
    'available' => $available,
    'borrowed' => $borrowed
]);

$conn->close();
?>
