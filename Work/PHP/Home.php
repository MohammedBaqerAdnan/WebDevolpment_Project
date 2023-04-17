<?php

session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password']) && isset($_SESSION['id'])) {

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>My Website Home</title>
    </head>

    <body>
        <h1>Welcome to my website
            <?php echo $_SESSION['id'] ?>
        </h1>
        <a href="Logout.php">Logout</a>
    </body>

    </html>

    <?php
} else {
    header("Location: Login.php");
    exit();
}