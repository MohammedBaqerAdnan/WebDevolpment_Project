<?php
session_start();
include 'DB_Connection.php';
include 'db_table.php';


if (isset($_POST['Register_button']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['username']) && isset($_POST['confirm_password'])) {
    // Validate user input
    function validate_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Check for empty input fields
    function empty_input_register($email, $password, $username, $confirm_password)
    {
        if (empty($email)) {
            throw new Exception("Email is Required");
        } elseif (empty($password)) {
            throw new Exception("Password is Required");
        } elseif (empty($username)) {
            throw new Exception("Username is Required");
        } elseif (empty($confirm_password)) {
            throw new Exception("Confirm Password is Required");
        }
    }
    function password_match($password, $confirm_password)
    {
        if ($password !== $confirm_password) {
            throw new Exception("Password and Confirm Password must be same");
        }
    }
    function insert_user($email, $password, $username, $connection)
    {
        $stmt = $connection->prepare("INSERT INTO `login`(`email`, `password`, `username`) VALUES (:email, :password, :username)");
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":username", $username);
        if ($stmt->execute()) {
            header("Location:Login.php?success=You have successfully registered");
            exit();
        } else {
            throw new Exception("unknown error occurred");
        }
    }

    // Check user credentials and start session
    function check_email_username_exists($email, $username, $connection, $password)
    {
        $stmt = $connection->prepare("SELECT * FROM `login` WHERE email = :email OR username = :username");
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $result_query = $stmt->fetch();

        if ($result_query !== false) {
            // $_SESSION['email'] = $result_query['email'];
            // $_SESSION['password'] = $result_query['password'];
            // $_SESSION['id'] = $result_query['id'];
            throw new Exception("The username or email is taken try another one");
            // header("Location:Home.php");
            // exit();

        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
            // throw new Exception("Invalid email or password. Please check your email and password and try again. If you haven't registered yet, please sign up first");
            insert_user($email, $password, $username, $connection);
        }
    }

    try {
        $email = validate_input($_POST['email']);
        $password = validate_input($_POST['password']);
        $username = validate_input($_POST['username']);
        $confirm_password = validate_input($_POST['confirm_password']);
        empty_input_register($email, $password, $username, $confirm_password);
        password_match($password, $confirm_password);
        check_email_username_exists($email, $username, $connection, $password);
        // login($email, $password, $connection);
    } catch (Exception $e) {
        header("Location:registration.php?error=" . urlencode($e->getMessage()) . "&email=" . $email . "&username=" . $username);
        exit();
    }

} else {
    header("location:registration.php?error=Please fill in all the fields");
    exit();
}

?>