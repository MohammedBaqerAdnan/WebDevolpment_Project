<?php
session_start();
include 'DB_Connection.php';
include 'db_table.php';



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
        $stmt = $connection->prepare("SELECT * FROM `login` WHERE email = :email AND password = :password");
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->execute();
        $result_query = $stmt->fetch();

        if ($result_query !== false) {
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
        login($email, $password, $connection);
    } catch (Exception $e) {
        header("Location:Login.php?error=" . urlencode($e->getMessage()));
        exit();
    }

} else {
    header("location:Login.php?error=Please fill in all the fields");
    exit();
}

?>