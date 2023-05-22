<?php
require "DB_Connection.php";
$create_table_query = "CREATE TABLE IF NOT EXISTS Que_details(
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
         echo "QUe Table created successfully";
    } catch (PDOException $e) {
        // Output error message if table creation fails
        echo "QUe Error creating table: " . $e->getMessage();
    }
}
/*
$create_table_query="CREATE TABLE IF NOT EXISTS QUIS(
id INT,
FOREIGN KEY (id) REFERENCES Que_details(id),
Question TEXT,
Options VARCHAR(50) 
)";
$type=$_POST[""];
$Question=$_POST[""];
if($type==="likert"){$options=$_POST[""];}
else if($type==="yesno"){$options=$_POST[""];}
else if($type==="shortanswer"){$options=$_POST[""];}
else if($type==="mcq"){$options=$_POST[""];}
$insert_query="INSERT IGNORE INTO QUIS (Question,Options) VALUES ('$Question','$options')";
$insert_query = "INSERT IGNORE INTO Que_details (title, description) VALUES ('$quiz_title', '$quiz_description')";
try {
    // Execute SQL query
    $connection->exec($insert_query);
     echo "QUIS Table created successfully";
} catch (PDOException $e) {
    // Output error message if table creation fails
    echo "QUIS Error creating table: " . $e->getMessage();
}*/
?>
