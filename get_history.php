<?php
include 'db_connection.php';

header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

$sql = "SELECT user_id, user_fullname, equipment_serial, equipment_name, date_borrowed, date_returned, status 
        FROM borrow_records 
        ORDER BY 
            CASE 
                WHEN status = 'Borrowed' THEN 1 
                WHEN status = 'Overdue' THEN 2 
                ELSE 3 
            END, 
            date_borrowed DESC";

$result = $conn->query($sql);
$records = array();

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
    echo json_encode(["success" => true, "records" => $records]);
} else {
    echo json_encode(["success" => false, "message" => "Error fetching history: " . $conn->error]);
}

$conn->close();
?>
