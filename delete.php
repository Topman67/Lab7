<?php
include 'db.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];
    
    // SQL Delete Query
    $sql = "DELETE FROM users WHERE matric='$matric'";

    if ($conn->query($sql) === TRUE) {
        header("Location: display.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
$conn->close();
?>