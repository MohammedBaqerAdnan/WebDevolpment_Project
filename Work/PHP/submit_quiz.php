<?php
require_once('DB_Connection.php');
session_start();

// Check if the form is submitted and the quiz_id is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quiz_id'])) {
    $quiz_id = $_POST['quiz_id'];

    // Create a new empty record in the responses table
    $login_id = $_SESSION['id'];
    $create_response_query = "INSERT INTO responses (quiz_id, login_id) VALUES (:quiz_id, :login_id)";
    $create_response_stmt = $connection->prepare($create_response_query);
    $create_response_stmt->bindParam(':quiz_id', $quiz_id);
    $create_response_stmt->bindParam(':login_id', $login_id);
    $create_response_stmt->execute();

    // Get the response_id of the newly created response
    $response_id = $connection->lastInsertId();

    // Iterate through each question in the form and insert the answers into the answers table
    foreach ($_POST['response'] as $question_id => $answer) {
        // Insert the answer into the answers table
        $create_answer_query = "INSERT INTO answers (response_id, question_id, answer_text) VALUES (:response_id, :question_id, :answer_text)";
        $create_answer_stmt = $connection->prepare($create_answer_query);
        $create_answer_stmt->bindParam(':response_id', $response_id);
        $create_answer_stmt->bindParam(':question_id', $question_id);
        $create_answer_stmt->bindParam(':answer_text', $answer);
        $create_answer_stmt->execute();
    }

    // Redirect the user to a success page
    header("Location: quiz_submission_success.php");
    exit();
} else {
    // Redirect the user to an error page if the form is not submitted correctly
    header("Location: quiz_submission_error.php");
    exit();
}



?>
