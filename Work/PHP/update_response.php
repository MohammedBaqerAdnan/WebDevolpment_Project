<?php
require_once('DB_Connection.php');
session_start();

// Check if the form is submitted and the response_id is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['response_id'])) {
    $response_id = $_POST['response_id'];

    // Iterate through each answer in the form and update the answers table
    foreach ($_POST as $key => $value) {
        // Check if the input field is an answer field
        if (strpos($key, 'answer_') === 0) {
            $answer_id = substr($key, strlen('answer_'));
            $answer_text = $value;

            // Update the answer in the answers table
            $update_answer_query = "UPDATE answers SET answer_text = :answer_text WHERE id = :answer_id";
            $update_answer_stmt = $connection->prepare($update_answer_query);
            $update_answer_stmt->bindParam(':answer_text', $answer_text);
            $update_answer_stmt->bindParam(':answer_id', $answer_id);
            $update_answer_stmt->execute();
        }
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
