<?php
session_start();
require 'DB_Connection.php';
require 'db_table.php';



if (isset($_POST['Login_button']) && isset($_POST['email']) && isset($_POST['password'])) {

    // Validate user input
    function validate_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Check for empty input fields
    function empty_input_login($email, $password)
    {
        if (empty($email)) {
            throw new Exception("Email is Required");
        } elseif (empty($password)) {
            throw new Exception("Password is Required");
        }
    }

    // Check user credentials and start session
    function login($email, $password, $connection)
    {
        $stmt = $connection->prepare("SELECT * FROM `login` WHERE email = :email");
        $stmt->bindParam(":email", $email);
        // $stmt->bindParam(":password", $password);
        $stmt->execute();
        $result_query = $stmt->fetch();

        if ($result_query !== false && password_verify($password, $result_query['password'])) {
            $_SESSION['email'] = $result_query['email'];
            $_SESSION['password'] = $result_query['password'];
            $_SESSION['id'] = $result_query['id'];
            header("Location:Home.php");
            exit();
        } else {
            throw new Exception("Invalid email or password. Please check your email and password and try again. If you haven't registered yet, please sign up first");
        }
    }

    try {
        $email = validate_input($_POST['email']);
        $password = validate_input($_POST['password']);
        empty_input_login($email, $password);
        // $password = password_hash($password, PASSWORD_DEFAULT);
        // echo $password;
        login($email, $password, $connection);
    } catch (Exception $e) {
        $_SESSION['Error_message'] = $e->getMessage();
        $_SESSION['email_refill'] = $email;
        // header("Location:Login.php?error=" . urlencode($e->getMessage()));
        header("Location:Login.php");
        exit();
    }

} else {
    $_SESSION['Error_message'] = "Please fill in all the fields";
    // header("location:Login.php?error=Please fill in all the fields");
    header("location:Login.php?error=Please fill in all the fields");
    exit();
}

?>