<?php
require('DB_connection.php');

// if (isset($_POST['email'])) {
//     $email = $_POST['email'];
//     $stmt = $connection->prepare("SELECT * FROM `login` WHERE email = :email");
//     $stmt->bindParam(":email", $email);
//     $stmt->execute();
//     $result_query = $stmt->fetch();
//     if ($result_query) {
//         echo "Email is already exists";
//     }
// }
if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $stmt = $connection->prepare("SELECT * FROM `login` WHERE username = :username");
    $stmt->bindParam(":username", $name);
    $stmt->execute();
    $result_query = $stmt->fetch();
    if ($result_query) {
        echo "name is already exists";
    }
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $stmt = $connection->prepare("SELECT * FROM `login` WHERE email = :email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $result_query = $stmt->fetch();
    if ($result_query) {
        echo "Email is already exists";
    }
}
// if (isset($_POST['name'])) {
//     $name = $_POST['name'];
//     $stmt = $connection->prepare("SELECT * FROM `login` WHERE name = :name");
//     $stmt->bindParam(":name", $name);
//     $stmt->execute();
//     $result_query = $stmt->fetch();
//     if ($result_query) {
//         echo "Username is already exists";
//     }
// }
?>