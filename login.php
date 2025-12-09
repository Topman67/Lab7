<?php
session_start();
include 'db.php';

if (isset($_POST['login'])) {
    $matric = $_POST['matric'];
    $password = $_POST['password'];

    $sql = "SELECT matric, password, role, name FROM users WHERE matric = '$matric'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verify the encrypted password
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['logged_in'] = true;
            $_SESSION['matric'] = $row['matric'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['role'] = $row['role'];
            
            // Redirect to display page
            header("Location: user.php");
            exit();
        } else {
            $error = "Invalid username or password, try login again.";
        }
    } else {
        $error = "Invalid username or password, try login again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lab 7: Login</title>
</head>
<body>
    <h2>Login Page</h2>
    <form action="login.php" method="post">
        <label for="matric">Matric:</label>
        <input type="text" name="matric" id="matric" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>

        <input type="submit" name="login" value="Login">
    </form>
    
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <p><a href="register.php">Register</a> here if you have not.</p>
</body>
</html>