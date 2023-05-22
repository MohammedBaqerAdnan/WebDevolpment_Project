<!-- Display the quiz title and description -->
<h2>
    <?= htmlspecialchars($quiz['title']) ?>
</h2>
<p>
    <?= htmlspecialchars($quiz['description']) ?>
</p>

<!-- Display the statistics for each question -->
<?php foreach ($questions as $question): ?>
    <h3>
        <?= htmlspecialchars($question['_text']) ?>
    </h3>
    <?php
    // Initialize the counters for each question type
    $yes_count = 0;
    $no_count = 0;
    $likert_sum = 0;
    $mcq_counts = array();
    $short_answers = 0;

    // Loop through the answers and count the statistics
    foreach ($answers as $response_answers) {
        foreach ($response_answers as $answer) {
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