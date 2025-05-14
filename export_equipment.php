<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ems";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set headers to force download as Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=all_equipment_data.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Begin HTML table output
echo "<table border='1'>";

// Table header row with bold styling
echo "<tr style='font-weight: bold; background-color: #f2f2f2;'>
        <th>Serial Number</th>
        <th>Equipment Name</th>
        <th>Brand</th>
        <th>Year Purchased</th>
        <th>Property Number</th>
        <th>Model Number</th>
        <th>Acquisition Date</th>
        <th>Acquisition Cost</th>
        <th>Person Accountable</th>
        <th>Status</th>
      </tr>";

// Fetch data with updated column names
$sql = "SELECT 
            serialNumber,
            equipmentName,
            brand,
            yearPurchased,
            propertyNumber,
            modelNumber,
            acquisitionDate,
            acquisitionCost,
            personAccountable,
            status
        FROM equipment
        ORDER BY equipmentName ASC";

$result = $conn->query($sql);

// Output data rows
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['serialNumber']}</td>
                <td>{$row['equipmentName']}</td>
                <td>{$row['brand']}</td>
                <td>{$row['yearPurchased']}</td>
                <td>{$row['propertyNumber']}</td>
                <td>{$row['modelNumber']}</td>
                <td>{$row['acquisitionDate']}</td>
                <td>{$row['acquisitionCost']}</td>
                <td>{$row['personAccountable']}</td>
                <td>{$row['status']}</td>
              </tr>";
    }
}

// Close table and connection
echo "</table>";
$conn->close();
?>
