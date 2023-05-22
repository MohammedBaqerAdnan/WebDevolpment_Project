<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>add-quiz</title>
  <link rel="stylesheet" href="../../Addition/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../Addition/css/all.min.css" />
  <link rel="stylesheet" href="../Css/add.css" />
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="admin-index.php">Homepage</a>
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
    <form method="post" id="quiz_form">
      <div class="form-group">
        <label for="quiz_title">Quiz Title:</label>
        <input type="text" id="quiz_title" name="quiz_title" class="form-control" />
      </div>
      <div class="form-group">
        <label for="quiz_description">Quiz Description:</label>
        <textarea id="quiz_description" name="quiz_description" rows="3" class="form-control"></textarea>
      </div>
      <div id="question_container">
        <!-- Questions will be added here -->
      </div>
      <button type="button" class="btn btn-secondary btn-spacing" id="addquestion">
        Add Question
      </button>
      <button type="submit" class="btn btn-primary btn-spacing" id="submit" style="display: none">
        Submit
      </button>
    </form>
  </div>

  <script src="../js/add.js"></script>
  <script src="../../js/bootstrap.bundle.min.js"></script>
  <script src="../../js/all.min.js"></script>

</body>

</html>

// Path: WebDevolpment_Project\Work\PHP\add-quiz.php