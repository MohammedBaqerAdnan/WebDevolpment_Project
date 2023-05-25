<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Questionnaire</title>
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
    ?>
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
        <form method="post" id="questionnaire_form" action="submit-questionnaire.php">
            <input type="hidden" name="quiz_id" value="<?= $quiz_id ?>">
            <h2>
                <?= htmlspecialchars($quiz['title']) ?>
            </h2>
            <p>
                <?= htmlspecialchars($quiz['description']) ?>
            </p>

            <?php foreach ($questions as $index => $question): ?>
                <div class="question">
                    <h3>
                        <?= htmlspecialchars($question['question_text']) ?>
                    </h3>
                    <div class="options">
                        <?php
                        switch ($question['question_type']) {
                            case 'likert':
                                for ($i = 1; $i <= 5; $i++) {
                                    echo '<div class="form-check">
                    <input class="form-check-input" type="radio" name="answers[' . $question['id'] . ']" value="' . $i . '">
                    <label class="form-check-label">' . $i . '</label>
                  </div>';
                                }
                                break;
                            case 'yesno':
                                echo '<div class="form-check">
                  <input class="form-check-input" type="radio" name="answers[' . $question['id'] . ']" value="yes">
                  <label class="form-check-label">Yes</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="answers[' . $question['id'] . ']" value="no">
                  <label class="form-check-label">No</label>
                </div>';
                                break;
                            case 'shortanswer':
                                echo '<div class="form-group">
                  <input type="text" class="form-control" name="answers[' . $question['id'] . ']">
                </div>';
                                break;
                            case 'mcq':
                                $mcq_options_stmt = $connection->prepare("SELECT * FROM mcq_options WHERE question_id = ?");
                                $mcq_options_stmt->execute([$question['id']]);
                                $mcq_options = $mcq_options_stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($mcq_options as $option) {
                                    echo '<div class="form-check">
                    <input class="form-check-input" type="radio" name="answers[' . $question['id'] . ']" value="' . $option['id'] . '">
                    <label class="form-check-label">' . $option['option_text'] . '</label>
                  </div>';
                                }
                                break;
                        }
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <button type="submit" class="btn btn-primary d-block">Submit</button>
        </form>
    </div>

    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../js/all.min.js"></script>

</body>

</html>