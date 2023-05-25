<?php
require "DB_Connection.php";
require "db_table.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get the submitted data
$quiz_id = $_POST['quiz_id'];
$answers = $_POST['answers'];

// Insert a new response
$response_stmt = $connection->prepare("INSERT INTO responses (quiz_id) VALUES (?)");
$response_stmt->execute([$quiz_id]);
$response_id = $connection->lastInsertId();

// Insert the answers and get the correct answers
$correct_answers = [];
foreach ($answers as $question_id => $answer_text) {
    $answer_stmt = $connection->prepare("INSERT INTO answers (response_id, question_id, answer_text) VALUES (?, ?, ?)");
    $answer_stmt->execute([$response_id, $question_id, $answer_text]);

    $correct_answer_stmt = $connection->prepare("SELECT answer_text FROM correct_answers WHERE question_id = ?");
    $correct_answer_stmt->execute([$question_id]);
    $correct_answer = $correct_answer_stmt->fetch(PDO::FETCH_ASSOC);
    if (is_array($correct_answer)) {
        $correct_answers[$question_id] = $correct_answer['answer_text'];
    } else {
        $correct_answers[$question_id] = '';
    }
}

// Get the user's answers
$user_answers_stmt = $connection->prepare("SELECT * FROM answers WHERE response_id = ?");
$user_answers_stmt->execute([$response_id]);
$user_answers = $user_answers_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results</title>
    <link rel="stylesheet" href="../../Addition/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../Addition/css/all.min.css" />
    <link rel="stylesheet" href="../Css/add.css" />
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="user-index.php">Homepage</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
        <h2>Results</h2>

        <?php foreach ($user_answers as $answer): ?>
            <div class="result">
                <h3>Question
                    <?= $answer['question_id'] ?>
                </h3>
                <p>Your answer:
                    <?= htmlspecialchars($answer['answer_text']) ?>
                </p>
                <p>Correct answer:
                    <?= htmlspecialchars($correct_answers[$answer['question_id']]) ?>
                </p>
            </div>
            <hr>
        <?php endforeach; ?>

        <a href="user-index.php">Back to Homepage</a>
    </div>

    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../js/all.min.js"></script>
</body>

</html>