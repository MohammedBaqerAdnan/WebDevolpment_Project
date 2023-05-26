
const questionContainer = document.getElementById("question_container");
const addQuestionBtn = document.getElementById("addquestion");
const submitBtn = document.getElementById("submit");

function createOptionContainer(questionType, index) {
  const optionContainer = document.createElement("div");
  optionContainer.classList.add("option-container");
  switch (questionType) {
    case "likert":
      optionContainer.innerHTML = `
        <label>Likert Scale Options:</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="likert${index}" id="option1" value="1">
          <label class="form-check-label" for="option1">Strongly Disagree</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="likert${index}" id="option2" value="2">
          <label class="form-check-label" for="option2">Disagree</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="likert${index}" id="option3" value="3">
          <label class="form-check-label" for="option3">Neutral</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="likert${index}" id="option4" value="4">
          <label class="form-check-label" for="option4">Agree</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="likert${index}" id="option5" value="5">
          <label class="form-check-label" for="option5">Strongly Agree</label>
        </div>`;
      break;
      case "yesno":
        optionContainer.innerHTML = `
          <label>Yes or No Options:</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="yesno${index}" id="yes" value="yes">
            <label class="form-check-label" for="yes">Yes</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="yesno${index}" id="no" value="no">
            <label class="form-check-label" for="no">No</label>
          </div>`;
        break;
    case "shortanswer":
      optionContainer.innerHTML = `
        <label for="short_answer_text">Short Answer:</label>
        <input type="text" id="short_answer_text" name="short_answer_text" class="form-control">
      `;
      break;
    case "mcq":
      optionContainer.innerHTML = `
        <label>MCQ Options:</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="mcq${index}" id="mcq_option1" value="option1">
          <input type="text" class="form-control" placeholder="Option 1" name="mcq_option1_text">
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="mcq${index}" id="mcq_option2" value="option2">
          <input type="text" class="form-control" placeholder="Option 2" name="mcq_option2_text">
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="mcq${index}" id="mcq_option3" value="option3">
          <input type="text" class="form-control" placeholder="Option 3" name="mcq_option3_text">
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="mcq${index}" id="mcq_option4" value="option4">
          <input type="text" class="form-control" placeholder="Option 4" name="mcq_option4_text">
        </div>`;
      break;
  }
  return optionContainer;
}

function updateOptionContainer(selectElement) {
  const questionType = selectElement.value;
  const optionContainer = selectElement.parentElement.nextElementSibling;
  const index =
    Array.from(
      selectElement.parentElement.parentElement.parentElement.children
    ).indexOf(selectElement.parentElement.parentElement) + 1;
  const newOptionContainer = createOptionContainer(questionType, index);
  optionContainer.replaceWith(newOptionContainer);
}

function addQuestion() {
  const questionCount = questionContainer.childElementCount + 1;
  const question = document.createElement("div");
  question.classList.add("question");
  question.innerHTML = `
    <h3>Question ${questionCount}</h3>
    <div class="form-group">
      <label for="question_text">Question Text:</label>
      <textarea id="question_text" name="question_text" rows="3" class="form-control"></textarea>
    </div>
    <div class="form-group">
      <label for="question_type_select">Question Type:</label>
      <select class="form-control" id="question_type_select_${questionCount}" name="question_type">
        <option value="likert">Likert Scale</option>
        <option value="yesno">Yes or No</option>
        <option value="shortanswer">Short Answer</option>
        <option value="mcq">Multiple Choice</option>
      </select>
    </div>
  `;
  const initialOptionContainer = createOptionContainer(
    "likert",
    questionCount
  );
  question.appendChild(initialOptionContainer);

  // Add event listener to update option container when question type is changed
  const selectElement = question.querySelector(
    `#question_type_select_${questionCount}`
  );
  selectElement.addEventListener("change", () =>
    updateOptionContainer(selectElement)
  );

  // Add a remove question button
  const removeQuestionBtn = document.createElement("button");
  removeQuestionBtn.classList.add("btn", "btn-danger", "remove-question");
  removeQuestionBtn.innerHTML = "Remove Question";
  removeQuestionBtn.addEventListener("click", () =>
    removeQuestion(question)
  );
  question.appendChild(removeQuestionBtn);

  questionContainer.appendChild(question);
  submitBtn.style.display = "block";
}

function renumberQuestions() {
  const questions = questionContainer.querySelectorAll(".question");
  questions.forEach((question, index) => {
    const header = question.querySelector("h3");
    header.textContent = `Question ${index + 1}`;
  });
}

function removeQuestion(question) {
  questionContainer.removeChild(question);
  renumberQuestions();
  if (questionContainer.childElementCount === 0) {
    submitBtn.style.display = "none";
  }
}

// Event listeners
addQuestionBtn.addEventListener("click", addQuestion);
// ...

// Renumber questions when a question is removed
function renumberQuestions() {
  const questions = questionContainer.querySelectorAll(".question");
  questions.forEach((question, index) => {
    const header = question.querySelector("h3");
    header.textContent = `Question ${index + 1}`;
  });
}

// Initialize event listeners for existing questions
function initializeQuestionListeners() {
  const questions = questionContainer.querySelectorAll(".question");
  questions.forEach((question, index) => {
    const selectElement = question.querySelector("select.form-control");
    selectElement.addEventListener("change", () =>
      updateOptionContainer(selectElement)
    );
    const removeQuestionBtn = question.querySelector(".remove-question");
    removeQuestionBtn.addEventListener("click", () =>
      removeQuestion(question)
    );
  });
}

initializeQuestionListeners();

// ...

function collectQuizData() {
  const quizData = {
    title: document.getElementById("quiz_title").value,
    description: document.getElementById("quiz_description").value,
    questions: [],
  };
  
  const questions = document.querySelectorAll(".question");
  questions.forEach((question) => {
    const question_text_element = question.querySelector("textarea[name='question_text']");
    const question_type_element = question.querySelector("select[name='question_type']");
    
    const questionData = {
      question_text: question_text_element ? question_text_element.value : "",
      question_type: question_type_element ? question_type_element.value : "",
      options: [],
      correct_answer: ""
    };
    
    if (questionData.question_type === "mcq") {
      const mcqOptions = question.querySelectorAll("input[type='text']");
      const mcqRadios = question.querySelectorAll("input[type='radio']");
    
      mcqOptions.forEach((option, i) => {
        if (mcqRadios[i].checked) {
          questionData.correct_answer = option.value;
        }
        questionData.options.push(option.value);
      });
    } else if (questionData.question_type === "shortanswer") {
      const shortAnswerInput = question.querySelector("input[type='text']");
      questionData.correct_answer = shortAnswerInput.value;
    } else if (questionData.question_type === "yesno") {
      const yesRadio = question.querySelector("input[value='yes']");
      const noRadio = question.querySelector("input[value='no']");
      if (yesRadio.checked) {
        questionData.correct_answer = "yes";    
    } else if (noRadio.checked) {
        questionData.correct_answer = "no";
    }
    }
    quizData.questions.push(questionData);
  });
  
  return quizData;  
}

function submitForm(event) {
  event.preventDefault(); // Prevent the default form submission behavior

  // Rest of the code for collecting and processing quiz data
  const quizData = collectQuizData();

  // Send the quiz data using the fetch function
  fetch("process-form.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(quizData),
  })
    .then((response) => response.text())
    .then((data) => {
      console.log(data);
      // Redirect to the admin page
      window.location.href = "admin-index.php";
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}


const quizForm = document.getElementById("quiz_form");
quizForm.addEventListener("submit", submitForm);