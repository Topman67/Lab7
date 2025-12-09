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
    <style>
        /* Basic styling to match the table borders in the lab example */
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">User List</h2>
    
    <div style="text-align: right; margin-right: 20px; margin-top: 10px;">
        <a href="logout.php">Logout</a>
    </div>

<table>
        <tr>
            <th>Matric</th>
            <th>Name</th>
            <th>Level</th>
            <th>Action</th> </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["matric"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["role"] . "</td>"; 
                // Updated part below:
              echo "<td>
                    <a href='update.php?matric=" . $row["matric"] . "'>Update</a> |
                    <a href='delete.php?matric=" . $row["matric"] . "' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>
                     </td>";
            }
        } else {
            echo "<tr><td colspan='4'>No users found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>