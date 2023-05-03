
var questionType = document.getElementById("question");
var likertScale = document.getElementById("likert_scale");
var yesNo = document.getElementById("yes_no");
var shortAnswer = document.getElementById("short_answer");
var mcq = document.getElementById("mcq");
likertScale.style.display = "none";
yesNo.style.display = "none";
shortAnswer.style.display = "none";
mcq.style.display = "none";


questionType.addEventListener("change", function () {
  if (questionType.value == "likert") {
    likertScale.style.display = "block";
    yesNo.style.display = "none";
    shortAnswer.style.display = "none";
    mcq.style.display = "none";
  } else if (questionType.value == "yesno") {
    likertScale.style.display = "none";
    yesNo.style.display = "block";
    shortAnswer.style.display = "none";
    mcq.style.display = "none";
  } else if (questionType.value == "shortanswer") {
    likertScale.style.display = "none";
    yesNo.style.display = "none";
    shortAnswer.style.display = "block";
    mcq.style.display = "none";
  } else if (questionType.value == "mcq") {
    likertScale.style.display = "none";
    yesNo.style.display = "none";
    shortAnswer.style.display = "none";
    mcq.style.display = "block";
  }
});
// Get the add question button element
var addQuestionBtn = document.getElementById("addquestion");

// Add click event listener to the add question button
addQuestionBtn.addEventListener("click", function () {
  // Create a new form element
  var newForm = document.createElement("form");

  // Set innerHTML for the new form element
  newForm.innerHTML = `
<label for="question">Question Type:</label>
<select id="question" name="question">
<option value="likert">Likert Scale</option>
<option value="yesno">Yes or No</option>
<option value="shortanswer">Short Answer</option>
<option value="mcq">Multiple Choice</option>
</select><br><br>

<label for="question_text">Question Text:</label>
<input type="text" id="question_text" name="question_text"><br><br>

<div id="likert_scale">
<label for="option1">Strongly Disagree</label>
<input type="radio" id="option1" name="likert" value="1">
<label for="option2">Disagree</label>
<input type="radio" id="option2" name="likert" value="2">
<label for="option3">Neutral</label>
<input type="radio" id="option3" name="likert" value="3">
<label for="option4">Agree</label>
<input type="radio" id="option4" name="likert" value="4">
<label for="option5">Strongly Agree</label>
<input type="radio" id="option5" name="likert" value="5">
</div>

<div id="yes_no">
<label for="yes_no_text">Yes or No Options:</label><br>
<input type="radio" id="yes_no_text" name="yes_no_text" value="yes">Yes<br>
<input type="radio" id="yes_no_text" name="yes_no_text" value="no">No<br><br>
</div>

<div id="short_answer">
<label for="short_answer_text">Short Answer:</label>
<input type="text" id="short_answer_text" name="short_answer_text"><br><br>
</div>

<div id="mcq">
<label for="mcq_text">MCQ Options:</label><br>
<input type="radio" id="mcq_text" name="mcq_text" value="option1">Option 1<br>
<input type="radio" id="mcq_text" name="mcq_text" value="option2">Option 2<br>
<input type="radio" id="mcq_text" name="mcq_text" value="option3">Option 3<br><br>
</div>
`;

  // Append the new form element to the DOM
  document.body.appendChild(newForm);

  // Set the default display style for the added form
  var questionType = newForm.querySelector("#question");
  var likertScale = newForm.querySelector("#likert_scale");
  var yesNo = newForm.querySelector("#yes_no");
  var shortAnswer = newForm.querySelector("#short_answer");
  var mcq = newForm.querySelector("#mcq");
  likertScale.style.display = "none";
  yesNo.style.display = "none";
  shortAnswer.style.display = "none";
  mcq.style.display = "none";

  // Add event listener to question type select element to show/hide corresponding options
  questionType.addEventListener("change", function () {
    var selectedOption = questionType.value;
    // Show/hide options based on selected question type
    if (selectedOption === "likert") {
      likertScale.style.display = "block";
      yesNo.style.display = "none";
      shortAnswer.style.display = "none";
      mcq.style.display = "none";
    } else if (selectedOption === "yesno") {
      likertScale.style.display = "none";
      yesNo.style.display = "block";
      shortAnswer.style.display = "none";
      mcq.style.display = "none";
    } else if (selectedOption === "shortanswer") {
      likertScale.style.display = "none";
      yesNo.style.display = "none";
      shortAnswer.style.display = "block";
      mcq.style.display = "none";
    } else if (selectedOption === "mcq") {
      likertScale.style.display = "none";
      yesNo.style.display = "none";
      shortAnswer.style.display = "none";
      mcq.style.display = "block";
    }
  });
});