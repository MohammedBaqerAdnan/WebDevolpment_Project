<?php
// $host = "localhost";
// $username = "root";
// $password = "root";
// $database_name = "website_db";
// // $connection = mysqli_connect($host, $username, $password, $database_name);

// // if (!$connection) {
// //     die("Connection failed: " . mysqli_connect_error());
// // }

// try {
//     $connection = new PDO("mysql:host=$host;dbname=$database_name", $username, $password);
//     // set the PDO error mode to exception
//     $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     echo "Connection failed: " . $e->getMessage();
// }


$host = "localhost";
$username = "root";
$password = "root";


try {
    $connection = new PDO("mysql:host=$host", $username, $password);
    // set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // create the database if it does not already exist
    $database_name = "website_db";
    $create_database_query = "CREATE DATABASE IF NOT EXISTS $database_name";
    $connection->exec($create_database_query);
    // select the database
    $connection->exec("USE $database_name");

    // echo "Database created successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>