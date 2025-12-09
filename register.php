<?php
include 'db.php';

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // 1. CHECK FOR DUPLICATES
    // We select any user who already has this matric number
    $checkQuery = "SELECT * FROM users WHERE matric='$matric'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        // 2. IF DUPLICATE FOUND: Show Popup
        echo "<script>alert('Error: The Matric number $matric is already registered!');</script>";
    } else {
        // 3. IF NO DUPLICATE: Proceed with Registration
        $sql = "INSERT INTO users (matric, name, password, role) VALUES ('$matric', '$name', '$password', '$role')";

        if ($conn->query($sql) === TRUE) {
            // Success Popup
            echo "<script>alert('New record created successfully!'); window.location.href='login.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lab 7: Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <h2>Registration Form</h2>
        <form action="register.php" method="post">
            <label for="matric">Matric:</label>
            <input type="text" name="matric" id="matric" required>

            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <label for="role">Role:</label>
            <select name="role" id="role" required>
                <option value="">Please select</option>
                <option value="student">Student</option>
                <option value="lecturer">Lecturer</option>
            </select>

            <input type="submit" name="submit" value="Submit">
        </form>
        <p style="margin-top: 20px;">
            Already have an account? <a href="login.php">Login here</a>
        </p>
    </div>
</body>
</html>