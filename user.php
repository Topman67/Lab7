<?php
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// SQL query to fetch data
$sql = "SELECT matric, name, role FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Users List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <div class="top-nav">
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
        
        <h2>User List</h2>
        
        <table>
            <tr>
                <th>Matric</th>
                <th>Name</th>
                <th>Level</th>
                <th>Action</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["matric"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["role"] . "</td>"; 
                    echo "<td>
                            <a href='update.php?matric=" . $row["matric"] . "'>Update</a> |
                            <a href='delete.php?matric=" . $row["matric"] . "' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No users found</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>