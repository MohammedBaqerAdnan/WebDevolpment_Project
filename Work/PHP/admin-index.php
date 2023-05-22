<!DOCTYPE html>
<html>

<head>
  <title>admin</title>
  <link rel="stylesheet" href="../../Addition/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../Addition/css/all.min.css" />
  <link rel="stylesheet" href="../Css/add.css" />
</head>

<body>
  <?php require "DB_Connection.php"; ?>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="admin.php">Homepage</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="add-quiz.php">Add Quiz</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../PHP/login.php">Logout</a>
          </li>
        </ul>
      </div>
    </nav>
    <div class="header">
      <h3 style="text-align:center">Questions</h3>
      <?php
      $stmt = $connection->query("SELECT * FROM quizzes");
      $quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>

      <!-- Display the quizzes -->
      <div class="container">
        <h2>Quizzes</h2>
        <ul>
          <?php foreach ($quizzes as $quiz): ?>
            <li>
              <h3>
                <?= htmlspecialchars($quiz['title']) ?>
              </h3>
              <p>
                <?= htmlspecialchars($quiz['description']) ?>
              </p>
              <a href="view-quiz.php?id=<?= $quiz['id'] ?>">View Quiz</a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </header>
  <script src="../../Addition/js/bootstrap.bundle.min.js"></script>
  <script src="../../Addition/js/all.min.js"></script>
</body>

</html>