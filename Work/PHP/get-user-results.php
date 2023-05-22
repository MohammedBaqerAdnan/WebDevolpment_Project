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

$sql = "SELECT questionnaire, date, score FROM questionnaire_results WHERE user_id = $userId";
$result = $conn->query($sql);

$results = [];
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $results[] = [
      'questionnaire' => $row['questionnaire'],
      'date' => $row['date'],
      'score' => $row['score']
    ];
  }
}

echo json_encode($results);

$conn->close();