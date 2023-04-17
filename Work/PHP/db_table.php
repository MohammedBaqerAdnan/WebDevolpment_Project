<?php

include 'DB_Connection.php';

// SQL to create table
$sql = "CREATE TABLE IF NOT EXISTS login (
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
)";

try {
    // Execute SQL query
    $connection->exec($sql);
    // echo "Table created successfully";
} catch (PDOException $e) {
    // Output error message if table creation fails
    echo "Error creating table: " . $e->getMessage();
}

// $connection = null;

?>