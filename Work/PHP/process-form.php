<?php
require "DB_Connection.php";
$create_table_query = "CREATE TABLE IF NOT EXISTS Que_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT
)";
$connection->exec($create_table_query);

// Confirm if the table was created
if ($connection->errorCode() === "00000") {
    echo "";
} else {
    $error_info = $connection->errorInfo();
    echo "Error creating table: " . $error_info[2];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $quiz_title = $_POST["quiz_title"];
    $quiz_description = $_POST["quiz_description"];

    // Prepare and execute the SQL statement to insert data into the table
    $insert_query = "INSERT IGNORE INTO Que_details (title, description) VALUES ('$quiz_title', '$quiz_description')";
    try {
        // Execute SQL query
        $connection->exec($insert_query);
        echo "Data inserted successfully into the Que_details table";
    } catch (PDOException $e) {
        // Output error message if data insertion fails
        echo "Error inserting data: " . $e->getMessage();
    }
}
$create_table_query = "CREATE TABLE IF NOT EXISTS QUIS (
    qid INT AUTO_INCREMENT PRIMARY KEY,
    Question TEXT,
    type TEXT,
    id INT,
    FOREIGN KEY (id) REFERENCES Que_details(id)
)";
$connection->exec($create_table_query);

// Confirm if the table was created
if ($connection->errorCode() === "00000") {
    echo "";
} else {
    $error_info = $connection->errorInfo();
    echo "Error creating table: " . $error_info[2];
}
$type = isset($_POST["question_type_select"]) ? $_POST["question_type_select"] : ""; // Initialize with empty value
$Question = $_POST["question_text"];
$options = "";

if ($type === "likert") {
    $options = $_POST["option"];
} else if ($type === "yesno") {
    $options = $_POST["yeso"];
} else if ($type === "shortanswer") {
    $options = $_POST["short_answer_text"];
} else if ($type === "mcq") {
    $options = $_POST["mcq_option"];
} else {
    echo "error";
}
$insert_query = "INSERT IGNORE INTO QUIS (Question, type, id) VALUES ('$Question', '$type', LAST_INSERT_ID())";
try {
    // Execute SQL query
    $connection->exec($insert_query);
    echo "Data inserted successfully into the QUIS table";
} catch (PDOException $e) {
    // Output error message if data insertion fails
    echo "Error inserting data: " . $e->getMessage();
}
header("Location: admin-index.php");
exit();

?>
