<?php

require "DB_Connection.php";
<<<<<<< HEAD
=======
$create_table_query = "CREATE TABLE IF NOT EXISTS Que_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT
)";
$connection->exec($create_table_query);
>>>>>>> 040969bfc276ec33ae9e8ad9ff69650bd60c4a8c

$input = file_get_contents("php://input");
$quizData = json_decode($input, true);

<<<<<<< HEAD
// Insert the quiz
$stmt = $connection->prepare("INSERT INTO quizzes (title, description) VALUES (:title, :description)");
$stmt->execute([
    'title' => $quizData['title'],
    // Removed extra $ sign
    'description' => $quizData['description'] // Removed extra $ sign
]);

// Get the inserted quiz ID
$quiz_id = $connection->lastInsertId();

//
print_r($quizData['questions']);
print_r($quizData['title']);
print_r($quizData['description']);
print_r($quizData['questions'][0]['question_text']);
print_r($quizData['questions'][0]['question_type']);
print_r($quizData['questions'][0]['options'][0]);
print_r($quizData['questions'][0]['options'][1]);
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
=======
    // Prepare and execute the SQL statement to insert data into the table
    $insert_query = "INSERT IGNORE INTO Que_details (title, description) VALUES ('$quiz_title', '$quiz_description')";
    try {
        // Execute SQL query
        $connection->exec($insert_query);
        echo "Data inserted successfully into the Que_details table";
    } catch (PDOException $e) {
        // Output error message if data insertion fails
        echo "Error inserting data: " . $e->getMessage();
    }
}
$create_table_query = "CREATE TABLE IF NOT EXISTS QUIS (
    qid INT AUTO_INCREMENT PRIMARY KEY,
    Question TEXT,
    type TEXT,
    id INT,
    FOREIGN KEY (id) REFERENCES Que_details(id)
)";
$connection->exec($create_table_query);

// Confirm if the table was created
if ($connection->errorCode() === "00000") {
    echo "";
} else {
    $error_info = $connection->errorInfo();
    echo "Error creating table: " . $error_info[2];
}
$type = isset($_POST["question_type_select"]) ? $_POST["question_type_select"] : ""; // Initialize with empty value
$Question = $_POST["question_text"];
$options = "";

if ($type === "likert") {
    $options = $_POST["option"];
} else if ($type === "yesno") {
    $options = $_POST["yeso"];
} else if ($type === "shortanswer") {
    $options = $_POST["short_answer_text"];
} else if ($type === "mcq") {
    $options = $_POST["mcq_option"];
} else {
    echo "error";
}
$insert_query = "INSERT IGNORE INTO QUIS (Question, type, id) VALUES ('$Question', '$type', LAST_INSERT_ID())";
try {
    // Execute SQL query
    $connection->exec($insert_query);
    echo "Data inserted successfully into the QUIS table";
} catch (PDOException $e) {
    // Output error message if data insertion fails
    echo "Error inserting data: " . $e->getMessage();
}
header("Location: admin-index.php");
exit();

?>
>>>>>>> 040969bfc276ec33ae9e8ad9ff69650bd60c4a8c
