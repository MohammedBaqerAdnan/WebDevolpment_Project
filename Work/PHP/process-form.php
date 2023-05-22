<?php

require "DB_Connection.php";

$input = file_get_contents("php://input");
$quizData = json_decode($input, true);

// Insert the quiz
$stmt = $connection->prepare("INSERT INTO quizzes (title, description) VALUES (:title, :description)");
$stmt->execute([
    'title' => $quizData['title'],
    // Removed extra $ sign
    'description' => $quizData['description'] // Removed extra $ sign
]);

// Get the inserted quiz ID
$quiz_id = $connection->lastInsertId();

// Insert the questions
foreach ($quizData['questions'] as $question) {
    $stmt = $connection->prepare("INSERT INTO questions (quiz_id, question_text, question_type) VALUES (:quiz_id, :question_text, :question_type)");
    $stmt->execute([
        'quiz_id' => $quiz_id,
        'question_text' => $question['question_text'],
        'question_type' => $question['question_type']
    ]);

    // Get the inserted question ID
    $question_id = $connection->lastInsertId();

    // Insert the MCQ options if the question type is 'mcq'
    if ($question['question_type'] == 'mcq') {
        foreach ($question['options'] as $option) {
            $stmt = $connection->prepare("INSERT INTO mcq_options (question_id, option_text) VALUES (:question_id, :option_text)");
            $stmt->execute([
                'question_id' => $question_id,
                'option_text' => $option
            ]);
        }
    }
}

// Redirect to the admin page
// header("Location: admin-index.php");
// exit();
?>