<?php

require 'DB_Connection.php';

// SQL to create table
// $sql1 = "CREATE TABLE IF NOT EXISTS login (
//     id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//     username VARCHAR(255) NOT NULL,
//     email VARCHAR(255) NOT NULL,
//     password VARCHAR(255) NOT NULL
// )";

// $sql2 = "CREATE TABLE IF NOT EXISTS quizzes (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     title VARCHAR(255) NOT NULL,
//     description TEXT
// )";

// $sql3 = "CREATE TABLE IF NOT EXISTS questions (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     quiz_id INT,
//     question_text TEXT NOT NULL,
//     question_type ENUM('likert', 'yesno', 'shortanswer', 'mcq') NOT NULL,
//     FOREIGN KEY (quiz_id) REFERENCES quizzes(id)
// )";

// $sql4 = "CREATE TABLE IF NOT EXISTS mcq_options (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     question_id INT,
//     option_text VARCHAR(255) NOT NULL,
//     FOREIGN KEY (question_id) REFERENCES questions(id)
// )";

// $sql5 = "CREATE TABLE IF NOT EXISTS responses (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     quiz_id INT,
//     FOREIGN KEY (quiz_id) REFERENCES quizzes(id)
// )";

// $sql6 = "CREATE TABLE IF NOT EXISTS answers (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     response_id INT,
//     question_id INT,
//     answer_text VARCHAR(255),
//     FOREIGN KEY (response_id) REFERENCES responses(id),
//     FOREIGN KEY (question_id) REFERENCES questions(id)
// )";
// $sql7 = "CREATE TABLE IF NOT EXISTS questions (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     quiz_id INT,
//     question_text TEXT NOT NULL,
//     question_type ENUM('likert', 'yesno', 'shortanswer', 'mcq') NOT NULL,
//     correct_answer VARCHAR(255),
//     FOREIGN KEY (quiz_id) REFERENCES(id)
// )";
// $sql8 = "CREATE TABLE IF NOT EXISTS correct_answers (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     question_id INT,
//     answer_text VARCHAR(255),
//     FOREIGN KEY (quiz_id) REFERENCES quizzes(id)
// )";



// SQL to create table
$sql1 = "CREATE TABLE IF NOT EXISTS login (
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
)";

$sql2 = "CREATE TABLE IF NOT EXISTS quizzes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT
)";
$sql3 = "CREATE TABLE IF NOT EXISTS questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT,
    question_text TEXT NOT NULL,
    question_type ENUM('likert', 'yesno', 'shortanswer', 'mcq') NOT NULL,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id)
)";

$sql4 = "CREATE TABLE IF NOT EXISTS mcq_options (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT,
    option_text VARCHAR(255) NOT NULL,
    FOREIGN KEY (question_id) REFERENCES questions(id)
)";

$sql5 = "CREATE TABLE IF NOT EXISTS responses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT,
    login_id int(10) UNSIGNED,
    FOREIGN KEY (login_id) REFERENCES login(id),
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id)
)";

$sql6 = "CREATE TABLE IF NOT EXISTS answers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    response_id INT,
    question_id INT,
    answer_text VARCHAR(255),
    FOREIGN KEY (response_id) REFERENCES responses(id),
    FOREIGN KEY (question_id) REFERENCES questions(id)
)";


$sql7 = "SELECT COUNT(*)
         FROM INFORMATION_SCHEMA.COLUMNS
         WHERE table_schema = 'website_db'
         AND table_name = 'questions'
         AND column_name = 'correct_answer'";

$sql8 = "CREATE TABLE IF NOT EXISTS correct_answers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT,
    answer_text VARCHAR(255),
    FOREIGN KEY (question_id) REFERENCES questions(id)
)";




try {
    // Execute SQL queries
    $connection->exec($sql1);
    $connection->exec($sql2);
    $connection->exec($sql3);
    $connection->exec($sql4);
    $connection->exec($sql5);
    $connection->exec($sql6);
    $result = $connection->query($sql7)->fetchColumn();
    if ($result == 0) {
        $connection->exec("ALTER TABLE questions ADD COLUMN correct_answer VARCHAR(255)");
    }
    $connection->exec($sql8);
    // echo "Tables created successfully";
} catch (PDOException $e) {
    // Output error message if table creation fails
    echo "Error creating tables: " . $e->getMessage();
}

// $connection = null;

?>