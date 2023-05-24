<!DOCTYPE html>
<html>
<head>
    <title>Edit Response</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <h1>Edit Response</h1>

    <?php
    require_once('DB_Connection.php');
    session_start();

    // Retrieve the response ID from the query parameter
    $response_id = $_GET['response_id'];

    // Retrieve the answers associated with the response from the database
    $answers_query = "SELECT a.id AS answer_id, a.question_id, q.question_text, q.question_type, a.answer_text FROM answers AS a INNER JOIN questions AS q ON a.question_id = q.id WHERE a.response_id = $response_id";
    $answers_result = $connection->query($answers_query);

    // Check if there are any answers available for the response
    if ($answers_result->rowCount() > 0) {
        echo '<form action="update_response.php" method="POST">';
        echo '<input type="hidden" name="response_id" value="' . $response_id . '">';

        // Display each question and its associated answer field based on the question type
        while ($answer_row = $answers_result->fetch(PDO::FETCH_ASSOC)) {
            $answer_id = $answer_row['answer_id'];
            $question_text = $answer_row['question_text'];
            $question_type = $answer_row['question_type'];
            $answer_text = $answer_row['answer_text'];

            echo '<div class="form-group">';
            echo '<label>' . $question_text . '</label>';

            switch ($question_type) {
                case 'yesno':
                    echo '<div class="form-check">';
                    echo '<input class="form-check-input" type="radio" name="answer_' . $answer_id . '" value="yes" ' . ($answer_text == 'yes' ? 'checked' : '') . '>';
                    echo '<label class="form-check-label">Yes</label>';
                    echo '</div>';

                    echo '<div class="form-check">';
                    echo '<input class="form-check-input" type="radio" name="answer_' . $answer_id . '" value="no" ' . ($answer_text == 'no' ? 'checked' : '') . '>';
                    echo '<label class="form-check-label">No</label>';
                    echo '</div>';
                    break;

                case 'shortanswer':
                    echo '<input type="text" class="form-control" name="answer_' . $answer_id . '" value="' . $answer_text . '">';
                    break;

                case 'mcq':
                    // Retrieve the MCQ options for the question
                    $mcq_options_query = "SELECT option_text FROM mcq_options WHERE question_id = " . $answer_row['question_id'];
                    $mcq_options_result = $connection->query($mcq_options_query);

                    // Display each MCQ option as a radio button
                    while ($mcq_option_row = $mcq_options_result->fetch(PDO::FETCH_ASSOC)) {
                        $option_text = $mcq_option_row['option_text'];

                        echo '<div class="form-check">';
                        echo '<input class="form-check-input" type="radio" name="answer_' . $answer_id . '" value="' . $option_text . '" ' . ($answer_text == $option_text ? 'checked' : '') . '>';
                        echo '<label class="form-check-label">' . $option_text . '</label>';
                        echo '</div>';
                    }
                    break;

                case 'likert':
                    // Display the Likert scale options as radio buttons
                    for ($i = 1; $i <= 5; $i++) {
                        echo '<div class="form-check">';
                        echo '<input class="form-check-input" type="radio" name="answer_' . $answer_id . '" value="' . $i . '" ' . ($answer_text == $i ? 'checked' : '') . '>';
                        echo '<label class="form-check-label">' . $i . ' (1 for lowest and 5 for highest)</label>';
                        echo '</div>';
                    }
                    break;

                default:
                    echo '<p>Unknown question type.</p>';
                    break;
            }

            echo '</div>';
        }

        echo '<button type="submit" class="btn btn-primary">Submit</button>';
        echo '</form>';
    } else {
        echo '<p>No answers found for the response.</p>';
    }

    // Close the database connection
    $connection = null;
    ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
