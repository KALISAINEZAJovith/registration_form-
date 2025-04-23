<?php
session_start();
$conn = new mysqli("localhost", "root", "", "accountdb");

if ($conn->connect_error) 
    die("Connection failed: " . $conn->connect_error);

$user = $_POST['username'];
$pass = $_POST['password'];

// Update SQL query to use the new table name
$sql = "SELECT * FROM credentials WHERE username = '$user'";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    if (password_verify($pass, $row['password'])) {
        $_SESSION['username'] = $user;

        // Fetch all registered users
        $allUsersSql = "SELECT * FROM credentials";
        $allUsersResult = $conn->query($allUsersSql);
        
        echo "<script>alert('Login successful');</script>";
        echo "<h2>All Registered Users:</h2>";
        
        // Start of the table
        echo "<table style='width: 100%; border-collapse: collapse;'>";
        echo "<tr style='background-color: #f2f2f2;'>";
        echo "<th style='border: 1px solid #ddd; padding: 8px;'>First Name</th>";
        echo "<th style='border: 1px solid #ddd; padding: 8px;'>Last Name</th>";
        echo "<th style='border: 1px solid #ddd; padding: 8px;'>Address</th>";
        echo "<th style='border: 1px solid #ddd; padding: 8px;'>Telephone</th>";
        echo "<th style='border: 1px solid #ddd; padding: 8px;'>Username</th>";
        echo "</tr>";

        // Loop through all registered users and display them in the table
        while ($userRow = $allUsersResult->fetch_assoc()) {
            echo "<tr>";
            echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . $userRow['first_name'] . "</td>";
            echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . $userRow['last_name'] . "</td>";
            echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . $userRow['address'] . "</td>";
            echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . $userRow['telephone'] . "</td>";
            echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . $userRow['username'] . "</td>";
            echo "</tr>";
        }

        echo "</table>"; // End of the table
        echo "<a href='welcome.php'>Go to Welcome Page</a>";
    } else {
        echo "<script>alert('Invalid password'); window.location='index.html';</script>";
    }
} else {
    echo "<script>alert('User  not found'); window.location='index.html';</script>";
}

$conn->close();
?>