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
    function check_email_username_exists($email, $username, $connection, $password, $confirm_password)
    {
        $stmt = $connection->prepare("SELECT * FROM `login` WHERE email = :email OR username = :username");
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $result_query = $stmt->fetch();

        if ($result_query !== false) {
            throw new Exception("The username or email is taken try another one");

        } else {
            regex_check($email, $password, $username, $confirm_password);

            $password = password_hash($password, PASSWORD_DEFAULT);
            // throw new Exception("Invalid email or password. Please check your email and password and try again. If you haven't registered yet, please sign up first");
            insert_user($email, $password, $username, $connection);
        }
    }
    function regex_check($email, $password, $username, $confirm_password)
    {
        //use this regex for email validation
        $email_regex = "/^([\w.]+)@((\[[\d]{1,3}\.[\d]{1,3}\.[\d]{1,3}\.[\d]{1,3})|(([\w]+\.)+))([a-zA-Z]{2,4}|[\d]{1,3})(\]?)$/";
        //use this regex for password validation
        $password_regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W])[a-zA-Z\d\W]{8,}$/";

        //use this regex for username validation
        $username_regex = "/^\w{4,20}$/";
        if (!preg_match($email_regex, $email)) {
            throw new Exception("Invalid email");
        }
        if (!preg_match($password_regex, $password)) {
            $error_message = "Invalid password: ";
            if (strlen($password) < 8) {
                $error_message .= "Password must be at least 8 characters long";
            } else {
                if (!preg_match("/[a-z]/", $password)) {
                    $error_message .= "Password must contain at least one lowercase letter. ";
                }
                if (!preg_match("/[A-Z]/", $password)) {
                    $error_message .= "Password must contain at least one uppercase letter. ";
                }
                if (!preg_match("/\d/", $password)) {
                    $error_message .= "Password must contain at least one number. ";
                }
                if (!preg_match("/[\W_]/", $password)) {
                    $error_message .= "Password must contain at least one special character. ";
                }
            }
            throw new Exception($error_message);
        }

        if (!preg_match($username_regex, $username)) {
            if (strlen($username) < 4) {
                throw new Exception("Username must be at least 4 characters");
            } elseif (strlen($username) > 20) {
                throw new Exception("Username must be less than 20 characters");
            } else {
                throw new Exception("Username may only contain letters, numbers, and underscores.");
            }
        }
        if (!preg_match($password_regex, $confirm_password)) {
            $error_message = "Invalid password: ";
            if (strlen($confirm_password) < 8) {
                $error_message .= "Password must be at least 8 characters long";
            } else {
                if (!preg_match("/[a-z]/", $confirm_password)) {
                    $error_message .= "Password must contain at least one lowercase letter. ";
                }
                if (!preg_match("/[A-Z]/", $confirm_password)) {
                    $error_message .= "Password must contain at least one uppercase letter. ";
                }
                if (!preg_match("/\d/", $confirm_password)) {
                    $error_message .= "Password must contain at least one number. ";
                }
                if (!preg_match("/[\W_]/", $confirm_password)) {
                    $error_message .= "Password must contain at least one special character. ";
                }
            }
            throw new Exception($error_message);
        }
    }
    try {
        $email = validate_input($_POST['email']);
        $password = validate_input($_POST['password']);
        $username = validate_input($_POST['username']);
        $confirm_password = validate_input($_POST['confirm_password']);
        empty_input_register($email, $password, $username, $confirm_password);
        password_match($password, $confirm_password);
        check_email_username_exists($email, $username, $connection, $password, $confirm_password);
    } catch (Exception $e) {
        header("Location:registration.php?error=" . urlencode($e->getMessage()) . "&email=" . $email . "&username=" . $username);
        exit();
    }

} else {
    header("location:registration.php?error=Please fill in all the fields");
    exit();
}

?>