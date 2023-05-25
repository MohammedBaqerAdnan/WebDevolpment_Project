<!DOCTYPE html>
<html>
<head>
    <title>Edit Responses</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <h1>Edit Responses</h1>

    <?php
    require_once('DB_Connection.php');
    session_start();

    // Retrieve the logged-in user's ID
    $login_id = $_SESSION['id'];

    // Retrieve the user's responses from the database
    $responses_query = "SELECT r.id AS response_id, r.quiz_id, q.title, q.description FROM responses AS r INNER JOIN quizzes AS q ON r.quiz_id = q.id WHERE r.login_id = $login_id";
    $responses_result = $connection->query($responses_query);

    // Check if the user has any responses
    if ($responses_result->rowCount() > 0) {
        echo '<div class="list-group">';

        // Display each response and its associated quiz details
        while ($response_row = $responses_result->fetch(PDO::FETCH_ASSOC)) {
            $response_id = $response_row['response_id'];
            $quiz_id = $response_row['quiz_id'];
            $quiz_title = $response_row['title'];
            $quiz_description = $response_row['description'];

            echo '<div class="list-group-item">';
            echo '<h5 class="mb-1">' . $quiz_title . '</h5>';
            echo '<p class="mb-1">' . $quiz_description . '</p>';

            // Retrieve the question types and number of questions for the quiz
            $question_types_query = "SELECT question_type, COUNT(*) as num_questions FROM questions WHERE quiz_id = $quiz_id GROUP BY question_type";
            $question_types_result = $connection->query($question_types_query);

            $question_types = array(); // Array to store question types

            // Retrieve the question types for the quiz
            while ($question_type_row = $question_types_result->fetch(PDO::FETCH_ASSOC)) {
                $question_type = $question_type_row['question_type'];

                // Map question type to appropriate name
                switch ($question_type) {
                    case 'yesno':
                        $question_types[] = 'Yes/No';
                        break;
                    case 'shortanswer':
                        $question_types[] = 'Short Answer';
                        break;
                    case 'mcq':
                        $question_types[] = 'MCQ';
                        break;
                    case 'likert':
                        $question_types[] = 'Likert Scale';
                        break;
                    default:
                        $question_types[] = 'Unknown Type';
                        break;
                }
            }

            // Display the question types and number of questions for the quiz
            echo '<p class="mb-1">Type: ' . implode(', ', $question_types) . '</p>';

            // Retrieve the total number of questions for the quiz
            $total_questions_query = "SELECT COUNT(*) as total_questions FROM questions WHERE quiz_id = $quiz_id";
            $total_questions_result = $connection->query($total_questions_query);
            $total_questions_row = $total_questions_result->fetch(PDO::FETCH_ASSOC);
            $total_questions = $total_questions_row['total_questions'];

            echo '<p class="mb-1">Number of Questions: ' . $total_questions . '</p>';
            echo '<a href="edit_response.php?response_id=' . $response_id . '" class="btn btn-primary">Edit Response</a>';
            echo '</div>';
        }

        echo '</div>';
    } else {
        echo '<p>No responses available.</p>';
    }

    // Close the database connection
    $connection = null;
    ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
