<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $serialNumber = mysqli_real_escape_string($conn, $_POST['serialNumber']);
    $equipmentName = mysqli_real_escape_string($conn, $_POST['equipmentName']);
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $yearPurchased = mysqli_real_escape_string($conn, $_POST['yearPurchased']);
    $propertyNumber = mysqli_real_escape_string($conn, $_POST['propertyNumber']);
    $modelNumber = mysqli_real_escape_string($conn, $_POST['modelNumber']);
    $acquisitionDate = mysqli_real_escape_string($conn, $_POST['acquisitionDate']);
    $acquisitionCost = mysqli_real_escape_string($conn, $_POST['acquisitionCost']);
    $personAccountable = mysqli_real_escape_string($conn, $_POST['personAccountable']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);

    $status = "available";

    $sql = "INSERT INTO equipment (
                serialNumber, equipmentName, brand, yearPurchased, 
                propertyNumber, modelNumber, acquisitionDate, acquisitionCost, 
                personAccountable, location, status
            ) VALUES (
                '$serialNumber', '$equipmentName', '$brand', '$yearPurchased',
                '$propertyNumber', '$modelNumber', '$acquisitionDate', '$acquisitionCost',
                '$personAccountable', '$location', '$status'
            )";

    if (mysqli_query($conn, $sql)) {
        echo "Success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Invalid request method.";
}
?>
