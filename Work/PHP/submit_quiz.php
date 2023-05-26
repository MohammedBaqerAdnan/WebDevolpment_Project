<!DOCTYPE html>
<html>
<head>
    <title>Quiz Results</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }
    </style>
</head>
<body>
<?php

require_once('DB_Connection.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['quiz_id']) && isset($_POST['response'])) {
        $quiz_id = $_POST['quiz_id'];
        $responses = $_POST['response'];
        $total_questions = count($responses);

        $correct_answers = 0;

        // Create response entry for the user
        $login_id = $_SESSION['id'];
        $create_response_query = "INSERT INTO responses (quiz_id, login_id) VALUES (:quiz_id, :login_id)";
        $create_response_stmt = $connection->prepare($create_response_query);
        $create_response_stmt->bindParam(':quiz_id', $quiz_id);
        $create_response_stmt->bindParam(':login_id', $login_id);
        $create_response_stmt->execute();

        // Get the response_id of the newly created response
        $response_id = $connection->lastInsertId();

        foreach ($responses as $question_id => $response) {
            $question_query = "SELECT id, correct_answer, question_type FROM questions WHERE id = $question_id";
            $question_result = $connection->query($question_query);
            $question_row = $question_result->fetch(PDO::FETCH_ASSOC);

            $correct_answer = $question_row['correct_answer'];
            $question_type = $question_row['question_type'];

            switch ($question_type) {
                case 'yesno':
                case 'shortanswer':
                    if ($response === $correct_answer) {
                        $correct_answers++;
                    }
                    break;
                case 'mcq':
                    $mcq_option_query = "SELECT id FROM mcq_options WHERE question_id = $question_id AND option_text = '$response'";
                    $mcq_option_result = $connection->query($mcq_option_query);

                    $question_correct_answer_query = "SELECT correct_answer FROM questions WHERE id = $question_id";
                    $question_correct_answer_result = $connection->query($question_correct_answer_query);
                    $question_correct_answer_row = $question_correct_answer_result->fetch(PDO::FETCH_ASSOC);
                    $correct_answer = $question_correct_answer_row['correct_answer'];

                    if ($response === $correct_answer && $mcq_option_result->rowCount() > 0) {
                        $correct_answers++;
                    }
                    break;
                case 'likert':
                    header('Location: quiz_submission_success.php');
                    exit();
                    break;
                default:
                    break;
            }

            // Insert the answer into the answers table
            $create_answer_query = "INSERT INTO answers (response_id, question_id, answer_text) VALUES (:response_id, :question_id, :answer_text)";
            $create_answer_stmt = $connection->prepare($create_answer_query);
            $create_answer_stmt->bindParam(':response_id', $response_id);
            $create_answer_stmt->bindParam(':question_id', $question_id);
            $create_answer_stmt->bindParam(':answer_text', $response);
            $create_answer_stmt->execute();
        }

        $grade = round(($correct_answers / $total_questions) * 100, 2);
        echo '<h1>Quiz Results</h1>';

        if ($grade >= 90) {
            echo '<p>Your grade: <span style="color:#2CE574;">' . $grade . '%</span></p>';
        } else if ($grade >= 80 && $grade < 90) {
            echo '<p>Your grade: <span style="color:#CDF03A;">' . $grade . '%</span></p>';
        } else if ($grade >= 70 && $grade < 80) {
            echo '<p>Your grade: <span style="color:#FFE500;">' . $grade . '%</span></p>';
        } else if ($grade >= 60 && $grade < 70) {
            echo '<p>Your grade: <span style="color:#FF9600;">' . $grade . '%</span></p>';
        } else {
            echo '<p>Your grade: <span style="color:#FF3924;">' . $grade . '%</span></p>';
        }
        
    } else {
        echo '<p>Invalid quiz data.</p>';
    }
} else {
    echo '<p>Invalid request.</p>';
}

// Close the database connection
$connection = null;
?>
<a href="Home.php">return home</a>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
