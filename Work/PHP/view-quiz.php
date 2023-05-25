<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Quiz</title>
    <link rel="stylesheet" href="../../Addition/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../Addition/css/all.min.css" />
    <link rel="stylesheet" href="../Css/add.css" />
</head>

<body>
    <?php
    require "DB_Connection.php";
    $quiz_id = $_GET['id'];
    $quiz_stmt = $connection->prepare("SELECT * FROM quizzes WHERE id = ?");
    $quiz_stmt->execute([$quiz_id]);
    $quiz = $quiz_stmt->fetch(PDO::FETCH_ASSOC);

    $question_stmt = $connection->prepare("SELECT * FROM questions WHERE quiz_id = ?");
    $question_stmt->execute([$quiz_id]);
    $questions = $question_stmt->fetchAll(PDO::FETCH_ASSOC);

    $answers_stmt = $connection->prepare("SELECT * FROM answers JOIN responses ON answers.response_id = responses.id WHERE responses.quiz_id = ?");
    $answers_stmt->execute([$quiz_id]);
    $answers = $answers_stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="admin-index.php">Homepage</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="admin-quizzes.php">Quizzes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin-questions.php">Questions</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container">
            <!-- Display the quiz title and description -->
            <h2>
                <?= htmlspecialchars($quiz['title']) ?>
            </h2>
            <p>
                <?= htmlspecialchars($quiz['']) ?>
            </p>

            <!-- Display the statistics for each question -->
            <?php foreach ($questions as $question): ?>
                <h3>
                    <?= htmlspecialchars($question['question_text']) ?>
                </h3>
                <?php
                // Initialize the counters for each question type
                $yes_count = 0;
                $no_count = 0;
                $likert_sum = 0;
                $mcq_counts = array();
                $short_answers = 0;

                // Loop through the answers and count the statistics
                foreach ($answers as $answer) {
                    if ($answer['question_id'] == $question['id']) {
                        switch ($question['question_type']) {
                            case 'yesno':
                                if ($answer['answer_text'] == 'yes') {
                                    $yes_count++;
                                } else {
                                    $no_count++;
                                }
                                break;
                            case 'likert':
                                $likert_sum += intval($answer['answer_text']);
                                break;
                            case 'mcq':
                                if (!isset($mcq_counts[$answer['answer_text']])) {
                                    $mcq_counts[$answer['answer_text']] = 0;
                                }
                                $mcq_counts[$answer['answer_text']]++;
                                break;
                            case 'shortanswer':
                                $short_answers++;
                                break;
                        }
                    }
                }

                // Calculate and display the statistics
                switch ($question['question_type']) {
                    case 'yesno':
                        $total_yesno = $yes_count + $no_count;
                        $yes_percentage = $total_yesno > 0 ? ($yes_count / $total_yesno) * 100 : 0;
                        $no_percentage = $total_yesno > 0 ? ($no_count / $total_yesno) * 100 : 0;
                        echo "Yes: $yes_percentage%<br>";
                        echo "No: $no_percentage%";
                        break;
                    case 'likert':
                        $likert_average = count($answers) > 0 ? $likert_sum / count($answers) : 0;
                        echo "Likert Average: $likert_average";
                        break;
                    case 'mcq':
                        echo "MCQ Percentages:<br>";
                        foreach ($mcq_counts as $option => $count) {
                            $percentage = count($answers) > 0 ? ($count / count($answers)) * 100 : 0;
                            echo "Option $option: $percentage%<br>";
                        }
                        break;
                    case 'shortanswer':
                        echo "Short Answers: $short_answers";
                        break;
                }
                ?>
                <hr>
            <?php endforeach; ?>
        </div>
    </main>
    <script src="../../Addition/js/jquery.min.js"></script>
    <script src="../../Addition/js/popper.min.js"></script>
    <script src="../../Addition/js/bootstrap.min.js"></script>
</body>

</html>