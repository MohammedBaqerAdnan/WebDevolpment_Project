<?php
$host = "localhost";
$username = "root";
$password = "";
$database_name = "website_db";
// $connection = mysqli_connect($host, $username, $password, $database_name);

// if (!$connection) {
//     die("Connection failed: " . mysqli_connect_error());
// }

try {
    $connection = new PDO("mysql:host=$host;dbname=$database_name", $username, $password);
    // set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>
