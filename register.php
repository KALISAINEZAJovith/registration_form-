<?php
$conn = new mysqli("localhost", "root", "", "accountdb");

// Check connection
if ($conn->connect_error) 
    die("Connection failed: " . $conn->connect_error);

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO credentials (first_name, last_name, address, telephone, username, password) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $first, $last, $address, $tel, $user, $pass);

// Get form values
$first = $_POST['first_name'];
$last = $_POST['last_name'];
$address = $_POST['address'];
$tel = $_POST['telephone'];
$user = $_POST['username'];
$pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Execute the query
if ($stmt->execute()) {
    echo "<script>alert('Registered successfully'); window.location='index.html';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>