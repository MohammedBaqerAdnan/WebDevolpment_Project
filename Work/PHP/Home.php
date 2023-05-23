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
            <?php
            if (empty($_SESSION['username'])) {
                echo '<br><p>Email: '.$_SESSION['email'].'</p>';
            }else {
                echo '<p>'.$_SESSION['username'].'</p>';
            }
            ?>
        </h1>
        <li><a href="userProfile.php">User Profile</a></li>
        <li><a href="Logout.php">Logout</a></li>
        
    </body>

    </html>

    <?php
} else {
    header("Location: Login.php");
    exit();
}