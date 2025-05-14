<?php
include 'db_connection.php';

$currentYear = date("Y");
$currentMonth = date("m");

$sql = "SELECT id_number, full_name, year, email, last_updated FROM users ORDER BY full_name ASC";
$result = $conn->query($sql);

$users = [];

while ($row = $result->fetch_assoc()) {
    $id_number = $row["id_number"];
    $year = intval($row["year"]);
    $lastUpdated = $row["last_updated"];
    
    $lastUpdatedYear = $lastUpdated ? date("Y", strtotime($lastUpdated)) : null;
    
    if ($currentMonth >= 8 && $lastUpdatedYear < $currentYear) { 
        $newYear = $year + 1;

        $updateQuery = "UPDATE users SET year = ?, last_updated = NOW() WHERE id_number = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("is", $newYear, $id_number);
        $stmt->execute();
        $stmt->close();

        $row["year"] = $newYear;
    }

    $users[] = $row;
}

echo json_encode($users);
$conn->close();
?>
