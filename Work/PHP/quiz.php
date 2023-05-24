<!DOCTYPE html>
<html>
<head>
    <title>Quiz</title>
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

    // Check if the quiz_id parameter is provided in the URL
    if (isset($_GET['quiz_id'])) {
        $quiz_id = $_GET['quiz_id'];

        // Retrieve the quiz details from the database
        $quiz_query = "SELECT id, title, description FROM quizzes WHERE id = $quiz_id";
        $quiz_result = $connection->query($quiz_query);
        $quiz_row = $quiz_result->fetch(PDO::FETCH_ASSOC);

        $quiz_title = $quiz_row['title'];
        $quiz_description = $quiz_row['description'];

        // Retrieve the questions for the selected quiz
        $questions_query = "SELECT id, question_text, question_type FROM questions WHERE quiz_id = $quiz_id";
        $questions_result = $connection->query($questions_query);

        // Check if there are any questions available
        if ($questions_result->rowCount() > 0) {
            echo '<h1>' . $quiz_title . '</h1>';
            echo '<p>' . $quiz_description . '</p>';
            echo '<form action="submit_quiz.php" method="POST">';

            // Display each question and appropriate input field based on the question type
            while ($question_row = $questions_result->fetch(PDO::FETCH_ASSOC)) {
                $question_id = $question_row['id'];
                $question_text = $question_row['question_text'];
                $question_type = $question_row['question_type'];

                echo '<div class="card mb-3">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $question_text . '</h5>';

                // Display input fields based on the question type
                switch ($question_type) {
                    case 'yesno':
                        echo '<div class="form-check">';
                        echo '<input class="form-check-input" type="radio" name="response[' . $question_id . ']" value="yes" id="yes' . $question_id . '">';
                        echo '<label class="form-check-label" for="yes' . $question_id . '">Yes</label>';
                        echo '</div>';
                        echo '<div class="form-check">';
                        echo '<input class="form-check-input" type="radio" name="response[' . $question_id . ']" value="no" id="no' . $question_id . '">';
                        echo '<label class="form-check-label" for="no' . $question_id . '">No</label>';
                        echo '</div>';
                        break;
                    case 'shortanswer':
                        echo '<input type="text" class="form-control" name="response[' . $question_id . ']" required>';
                        break;
                    case 'mcq':
                        $mcq_options_query = "SELECT id, option_text FROM mcq_options WHERE question_id = $question_id";
                        $mcq_options_result = $connection->query($mcq_options_query);

                        while ($mcq_option_row = $mcq_options_result->fetch(PDO::FETCH_ASSOC)) {
                            $option_id = $mcq_option_row['id'];
                            $option_text = $mcq_option_row['option_text'];

                            echo '<div class="form-check">';
                            echo '<input class="form-check-input" type="radio" name="response[' . $question_id . ']" value="' . $option_text . '" id="option' . $option_id . '">';
                            echo '<label class="form-check-label" for="option' . $option_id . '">' . $option_text . '</label>';
                            echo '</div>';
                        }
                        break;
                    case 'likert':
                        echo '<div class="form-check">';
                        echo '<input class="form-check-input" type="radio" name="response[' . $question_id . ']" value="1" id="likert1' . $question_id . '">';
                        echo '<label class="form-check-label" for="likert1' . $question_id . '">1 (Lowest)</label>';
                        echo '</div>';
                        echo '<div class="form-check">';
                        echo '<input class="form-check-input" type="radio" name="response[' . $question_id . ']" value="2" id="likert2' . $question_id . '">';
                        echo '<label class="form-check-label" for="likert2' . $question_id . '">2</label>';
                        echo '</div>';
                        echo '<div class="form-check">';
                        echo '<input class="form-check-input" type="radio" name="response[' . $question_id . ']" value="3" id="likert3' . $question_id . '">';
                        echo '<label class="form-check-label" for="likert3' . $question_id . '">3</label>';
                        echo '</div>';
                        echo '<div class="form-check">';
                        echo '<input class="form-check-input" type="radio" name="response[' . $question_id . ']" value="4" id="likert4' . $question_id . '">';
                        echo '<label class="form-check-label" for="likert4' . $question_id . '">4</label>';
                        echo '</div>';
                        echo '<div class="form-check">';
                        echo '<input class="form-check-input" type="radio" name="response[' . $question_id . ']" value="5" id="likert5' . $question_id . '">';
                        echo '<label class="form-check-label" for="likert5' . $question_id . '">5 (Highest)</label>';
                        echo '</div>';
                        break;
                    default:
                        echo '<p>Unknown question type.</p>';
                        break;
                }

                echo '</div>';
                echo '</div>';
            }

            echo '<input type="hidden" name="quiz_id" value="' . $quiz_id . '">';
            echo '<button type="submit" class="btn btn-primary">Submit</button>';
            echo '</form>';
        } else {
            echo '<p>No questions available for this quiz.</p>';
        }
    } else {
        echo '<p>No quiz selected.</p>';
    }

    // Close the database connection
    $connection = null;
    ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
