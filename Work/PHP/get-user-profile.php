<?php
header('Content-Type: application/json');

// Replace with your database connection credentials
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die(json_encode(['error' => "Connection failed: " . $conn->connect_error]));
}

// Replace with the user ID of the currently logged-in user
$userId = 1;

$sql = "SELECT id, username, email,joined FROM users WHERE id = $userId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  echo json_encode([
    'username' => $row['username'],
    'email' => $row['email'],
    'joined' => $row['joined']
  ]);
} else {
  echo json_encode(['error' => 'User not found']);
}

$conn->close();