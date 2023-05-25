<?php session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password']) && isset($_SESSION['id'])) { ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>My Website Home</title>
        <link rel="stylesheet" href="../../Addition/css/bootstrap.min.css" />
        <link rel="stylesheet" href="../../Addition/css/all.min.css" />
        <link rel="stylesheet" href="../Css/styles.css">
    </head>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"> <a class="navbar-brand" href="Home.php">Homepage</a> <button
            class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li><a class="nav-link" href="userProfile.php">Edit Profile</a></li>
                <li class="nav-item"> <a class="nav-link" href="Logout.php">Logout</a> </li>
            </ul>
        </div>
    </nav>

    <body>
        <h3>Welcome to Quizzy
            <?php if (empty($_SESSION['username'])) {
                echo '<br><p>Email: ' . $_SESSION['email'] . '</p>';
            } else {
                echo '<p>' . $_SESSION['username'] . '</p>';
            } ?>
            </h1> <br>
             <li><a href="displayQuizzes.php">Attempt quiz</a></li> 
            <li><a href="displayResponses.php">Edit Responses</a></li>
            <script src="../../Addition/js/bootstrap.bundle.min.js"></script>
            <script src="../../Addition/js/all.min.js"></script>
    </body>

    </html>
<?php } else {
    header("Location: Login.php");
    exit();
} ?>