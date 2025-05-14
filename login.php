<?php
session_start();

$enteredPassword = $_POST['password'];
$correctPassword = 'SECRET'; // Replace this with your actual password

if ($enteredPassword === $correctPassword) {
    $_SESSION['authenticated'] = true;
    header("Location: dashboard.html"); // Redirect to home page
    exit();
} else {
    header("Location: login.html?error=1"); // Redirect back with error
    exit();
}
