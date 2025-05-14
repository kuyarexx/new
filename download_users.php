<?php
require 'db_connection.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=users_data.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Start the table
echo "<table border='1'>";

// Bold header row
echo "<tr style='font-weight: bold; background-color: #f2f2f2;'>
        <th>Student ID</th>
        <th>Full Name</th>
        <th>Year</th>
        <th>Email</th>
      </tr>";

// Query to sort by year then full name
$query = "SELECT id_number, full_name, year, email FROM users ORDER BY year ASC, full_name ASC";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['id_number']}</td>
            <td>{$row['full_name']}</td>
            <td>{$row['year']}</td>
            <td>{$row['email']}</td>
          </tr>";
}

echo "</table>";
$conn->close();
?>
