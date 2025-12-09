<?php
include 'db.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

// Check if form is submitted (POST request)
if (isset($_POST['update'])) {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET name='$name', role='$role' WHERE matric='$matric'";

    if ($conn->query($sql) === TRUE) {
        header("Location: user.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Check if a matric is provided in the URL (GET request) to fetch data
if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];
    $sql = "SELECT * FROM users WHERE matric='$matric'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $role = $row['role'];
    } else {
        echo "User not found";
        exit(); // Stop execution if user not found
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
</head>
<body>
    <h2>Update User</h2>
    <form action="update.php" method="post">
        <label for="matric">Matric:</label>
        <input type="text" name="matric" value="<?php echo $matric; ?>" readonly><br><br>

        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $name; ?>" required><br><br>

        <label for="role">Access Level:</label>
        <select name="role" id="role" required>
            <option value="">Please select</option>
            <option value="student" <?php if ($role == 'student') echo 'selected'; ?>>Student</option>
            <option value="lecturer" <?php if ($role == 'lecturer') echo 'selected'; ?>>Lecturer</option>
        </select><br><br>

        <input type="submit" name="update" value="Update">
        <a href="user.php">Cancel</a>
    </form>
</body>
</html>