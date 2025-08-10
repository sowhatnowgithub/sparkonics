
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quiz Question Manager</title>
  <?php echo "<style>" . Sowhatnow\App\Views\NavBar::$STYLE . "</style>"; ?>
  <style>
    * {
      box-sizing: border-box;
    }


    h1, h3 {
      text-align: center;
    }

    .form-wrapper {
      max-width: 900px;
      margin: 30px auto;
      background: #eef;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    label {
      display: block;
      margin-top: 10px;
      font-weight: bold;
    }

    input, textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
      resize: vertical;
    }

    button {
      padding: 10px 16px;
      margin-top: 15px;
      margin-right: 10px;
      border-radius: 4px;
      border: none;
      cursor: pointer;
      font-weight: bold;
    }

    .submit-btn {
      background-color: #003366;
      color: white;
    }

    .delete-btn {
      background-color: #e74c3c;
      color: white;
    }

    .edit-btn {
      background-color: #f39c12;
      color: white;
    }

    #questionTable {
      width: 100%;
      max-width: 100%;
      border-collapse: collapse;
      margin: 40px auto;
    }

    th, td {
      border: 1px solid #999;
      padding: 12px;
      text-align: left;
    }

    th {
      background-color: #003366;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f1f1f1;
    }

    @media screen and (max-width: 768px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }

      th {
        position: sticky;
        top: 0;
        background-color: #003366;
        z-index: 2;
      }

      td {
        margin-bottom: 10px;
        border: none;
        position: relative;
        padding-left: 50%;
      }

      td::before {
        position: absolute;
        left: 10px;
        top: 12px;
        white-space: nowrap;
        font-weight: bold;
        content: attr(data-label);
      }
    }
  </style>
</head>
<body>

<?php echo Sowhatnow\App\Views\NavBar::$NAVBAR; ?>

<h1>Quiz Question Manager</h1>

<div class="form-wrapper">
  <label for="selectQuiz">Select Quiz ID:</label>
  <input type="number" id="selectQuiz" placeholder="Enter Quiz ID" />
  <button class="submit-btn" onclick="loadQuestions()">Load Questions</button>
</div>

<!-- Questions Table -->
<table id="questionTable">
  <thead>
    <tr>
      <th>Question ID</th>
      <th>Question</th>
<th>Image</th>
      <th>Options</th>
      <th>Answer Index</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>

<!-- Question Form -->
<div class="form-wrapper">
  <h3 id="formTitle">Add / Edit Question</h3>
  <form id="questionForm">
    <label>Quiz ID</label>
    <input type="number" name="QuizId" id="QuizId" required />

    <label>Question ID</label>
    <input type="number" name="QuizQuestionId" id="QuizQuestionId" required />

    <label>Question</label>
    <textarea name="QuizQuestion" id="QuizQuestion" required></textarea>

    <label>Image</label>
    <input type="text" name="QuizQuestionImage" id="QuizQuestionImage" placeholder="/api/images/1"  />

    <label>Options (JSON Array e.g., ["opt1", "opt2", "opt3", "opt4"])</label>
    <textarea name="QuizOptions" id="QuizOptions" required></textarea>

    <label>Correct Answer Index (0-based)</label>
    <input type="number" name="QuizAnswer" id="QuizAnswer" required />

    <button type="submit" class="submit-btn" id="submitBtn">Add Question</button>
    <button type="button" class="delete-btn" id="cancelEditBtn" style="display:none;">Cancel Edit</button>
  </form>
</div>

<script>
  const api = 'https://sparkonics.iitp.ac.in/quiz';
  let isEditing = false;

  function setEditMode(isEdit) {
    isEditing = isEdit;
    document.getElementById('submitBtn').textContent = isEdit ? 'Modify Question' : 'Add Question';
    document.getElementById('cancelEditBtn').style.display = isEdit ? 'inline-block' : 'none';
    document.getElementById('formTitle').textContent = isEdit ? 'Modify Question' : 'Add / Edit Question';
  }

  document.getElementById('cancelEditBtn').addEventListener('click', () => {
    document.getElementById('questionForm').reset();
    setEditMode(false);
  });

  async function loadQuestions() {
    const quizId = document.getElementById('selectQuiz').value;
    if (!quizId) return alert('Please enter a Quiz ID');

    const res = await fetch(`${api}/getquizquestions`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `QuizId=${encodeURIComponent(quizId)}`
    });

    if (!res.ok) return alert('Failed to load quiz');

    const data = await res.json();
    const questions = data.questions || [];
    console.log(data);
    const tbody = document.querySelector('#questionTable tbody');
    tbody.innerHTML = '';

    if (questions.length === 0) {
      const tr = document.createElement('tr');
      tr.innerHTML = `<td colspan="5" style="text-align:center;">No questions found for Quiz ID ${quizId}</td>`;
      tbody.appendChild(tr);
      return;
    }

    questions.forEach(q => {
      let optionsDisplay;
      try {
        const opts = JSON.parse(q.QuizOptions);
        optionsDisplay = Array.isArray(opts) ? opts.join(', ') : q.QuizOptions;
      } catch {
        optionsDisplay = q.QuizOptions;
      }

      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td data-label="Question ID">${q.QuizQuestionId}</td>
        <td data-label="Question">${q.QuizQuestion}</td>
        <td data-label="Image">${q.QuizQuestionImage}</td>
        <td data-label="Options">${optionsDisplay}</td>
        <td data-label="Answer Index">${q.QuizAnswer}</td>
        <td data-label="Actions">
          <button class="edit-btn" onclick='editQuestion(${JSON.stringify(q)})'>Edit</button>
          <button class="delete-btn" onclick='deleteQuestion(${q.QuizId}, ${q.QuizQuestionId})'>Delete</button>
        </td>
      `;
      tbody.appendChild(tr);
    });
  }

  function editQuestion(q) {
    document.getElementById('QuizId').value = q.QuizId;
    document.getElementById('QuizQuestionId').value = q.QuizQuestionId;
    document.getElementById('QuizQuestionImage').value = q.QuizQuestionImage;
    document.getElementById('QuizQuestion').value = q.QuizQuestion;

    try {
      const opts = JSON.parse(q.QuizOptions);
      document.getElementById('QuizOptions').value = JSON.stringify(opts, null, 2);
    } catch {
      document.getElementById('QuizOptions').value = q.QuizOptions;
    }

    document.getElementById('QuizAnswer').value = q.QuizAnswer;
    setEditMode(true);
  }

  async function deleteQuestion(quizId, questionId) {
    if (!confirm(`Delete Question ID ${questionId} from Quiz ${quizId}?`)) return;

    const res = await fetch(`${api}/question/delete`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `QuizId=${quizId}&QuizQuestionId=${questionId}`
    });

    if (!res.ok) return alert('Delete failed');
    alert('Question deleted!');
    loadQuestions();
  }


  document.getElementById('questionForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.target;

    // Prepare form data
    const formData = new FormData(form);
    // Validate JSON in Options field
    try {
      JSON.parse(formData.get('QuizOptions'));
    } catch {
      return alert('QuizOptions must be a valid JSON array');
    }

    const params = new URLSearchParams(formData).toString();

    // Decide endpoint based on editing state
    const endpoint = isEditing ? '/question/modify' : '/question/add';

    const res = await fetch(`${api}${endpoint}`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: params
    });

    if (!res.ok) {
      alert(`Failed to ${isEditing ? 'modify' : 'add'} question`);
      return;
    }

    alert(`Question ${isEditing ? 'modified' : 'added'} successfully`);
    form.reset();
    setEditMode(false);
    loadQuestions();
  });
</script>

</body>
</html>

