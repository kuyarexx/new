<?php
include 'db_connection.php';

$response = ['success' => false, 'message' => ''];

if (isset($_POST['id_number'], $_POST['full_name'], $_POST['year'], $_POST['email'])) {
    $id_number = trim($_POST['id_number']);
    $full_name = trim($_POST['full_name']);
    $year = trim($_POST['year']);
    $email = trim($_POST['email']);

    $checkQuery = $conn->prepare("SELECT * FROM users WHERE id_number = ?");
    $checkQuery->bind_param("s", $id_number);
    $checkQuery->execute();
    $result = $checkQuery->get_result();

    if ($result->num_rows > 0) {
        $response['message'] = "Student ID already exists!";
    } else {
        $insertQuery = $conn->prepare("INSERT INTO users (id_number, full_name, year, email) VALUES (?, ?, ?, ?)");
        $insertQuery->bind_param("ssss", $id_number, $full_name, $year, $email);

        if ($insertQuery->execute()) {
            $response['success'] = true;
            $response['message'] = "User successfully added!";
        } else {
            $response['message'] = "Failed to save user.";
        }
    }

    $checkQuery->close();
    if (isset($insertQuery)) $insertQuery->close();
} else {
    $response['message'] = "Incomplete data.";
}

$conn->close();
echo json_encode($response);
?>
