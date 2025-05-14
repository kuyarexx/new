<?php
if (!isset($_GET['equipmentName'])) {
    die("No equipment name provided.");
}

$equipmentName = urldecode($_GET['equipmentName']);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ems";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set headers to prompt Excel download
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=" . str_replace(" ", "_", $equipmentName) . "_Details.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Start the table
echo "<table border='1'>";

// Output bold headers
echo "<tr style='font-weight: bold; background-color: #f2f2f2;'>
        <th>Serial Number</th>
        <th>Status</th>
        <th>Brand</th>
        <th>Year Purchased</th>
        <th>Property Number</th>
        <th>Model Number</th>
        <th>Acquisition Date</th>
        <th>Acquisition Cost</th>
        <th>Person Accountable</th>
        <th>Location</th>
      </tr>";

// Prepare and run query
$sql = "SELECT 
            serialNumber,
            status,
            brand,
            yearPurchased,
            propertyNumber,
            modelNumber,
            acquisitionDate,
            acquisitionCost,
            personAccountable,
            location
        FROM equipment
        WHERE equipmentName = ?
        ORDER BY serialNumber ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $equipmentName);
$stmt->execute();
$result = $stmt->get_result();

// Output data rows
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['serialNumber']}</td>
            <td>{$row['status']}</td>
            <td>{$row['brand']}</td>
            <td>{$row['yearPurchased']}</td>
            <td>{$row['propertyNumber']}</td>
            <td>{$row['modelNumber']}</td>
            <td>{$row['acquisitionDate']}</td>
            <td>{$row['acquisitionCost']}</td>
            <td>{$row['personAccountable']}</td>
            <td>{$row['location']}</td>
          </tr>";
}

echo "</table>";

// Clean up
$stmt->close();
$conn->close();
?>
