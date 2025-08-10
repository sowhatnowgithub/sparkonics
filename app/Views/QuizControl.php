
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Quiz Manager</title>

  <?php echo "<style>" . Sowhatnow\App\Views\NavBar::$STYLE . "</style>"; ?>
  <style>

    h1 {
      text-align: center;
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
    }

    th, td {
      border: 1px solid #999;
      padding: 10px;
      text-align: left;
    }

    th {
      background-color: #003366;
      color: #fff;
    }

    tr:nth-child(even) {
      background-color: #f5faff;
    }

    button {
      padding: 6px 12px;
      margin: 2px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .delete-btn {
      background-color: #ff4c4c;
      color: white;
    }

    .edit-btn {
      background-color: #ffa500;
      color: white;
    }

    .form-section {
      max-width: 800px;
      margin: 0 auto;
    }

    .form-section form {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      background: #eef;
      padding: 20px;
      border-radius: 8px;
    }

    .form-section label {
      flex: 1 1 100%;
      margin-bottom: 4px;
    }

    .form-section input,
    .form-section textarea {
      flex: 1 1 100%;
      padding: 8px;
      font-size: 14px;
    }

    .form-section button {
      background-color: #003366;
      color: white;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <?php echo Sowhatnow\App\Views\NavBar::$NAVBAR; ?>
  <h1>Quiz Manager</h1>

  <!-- Quiz List Table -->
  <table id="quizTable">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Starts</th>
        <th>Ends</th>
        <th>Domain</th>
        <th>Score/Q</th>
        <th>High Score</th>
        <th>Top Scorer</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <!-- Populated by JS -->
    </tbody>
  </table>

  <!-- Form to Add / Modify -->
  <div class="form-section">
    <form id="quizForm">
      <input type="hidden" id="QuizId" name="QuizId" />
      <label for="QuizName">Quiz Name</label>
      <input type="text" id="QuizName" name="QuizName" required />

      <label for="QuizDesc">Description</label>
      <textarea id="QuizDesc" name="QuizDesc" required></textarea>

      <label for="QuizStarts">Starts</label>
      <input type="datetime-local" id="QuizStarts" name="QuizStarts" required />

      <label for="QuizEnds">Ends</label>
      <input type="datetime-local" id="QuizEnds" name="QuizEnds" required />

      <label for="QuizDomain">Domain</label>
      <input type="text" id="QuizDomain" name="QuizDomain" required />

      <label for="QuizQuestionScore">Question Score</label>
      <input type="number" id="QuizQuestionScore" name="QuizQuestionScore" required />

      <label for="QuizHighScore">High Score</label>
      <input type="text" id="QuizHighScore" name="QuizHighScore" required />

      <label for="QuizTopScorer">Top Scorer</label>
      <input type="text" id="QuizTopScorer" name="QuizTopScorer" required />

      <button type="submit">Submit</button>
    </form>
  </div>

  <script>
    const apiBase = 'https://sparkonics.iitp.ac.in/quiz';

    document.addEventListener('DOMContentLoaded', fetchQuizzes);

    async function fetchQuizzes() {
      try {
        const res = await fetch(`${apiBase}/getquizzes`);
        const quizzes = await res.json();
        populateTable(quizzes);
      } catch (err) {
        alert('Failed to fetch quizzes.');
      }
    }

    function populateTable(quizzes) {
      const tbody = document.querySelector('#quizTable tbody');
      tbody.innerHTML = '';

      quizzes.forEach(q => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${q.QuizId}</td>
          <td>${q.QuizName}</td>
          <td>${q.QuizDesc}</td>
          <td>${q.QuizStarts}</td>
          <td>${q.QuizEnds}</td>
          <td>${q.QuizDomain}</td>
          <td>${q.QuizQuestionScore}</td>
          <td>${q.QuizHighScore}</td>
          <td>${q.QuizTopScorer}</td>
          <td>
            <button class="edit-btn" onclick='editQuiz(${JSON.stringify(q)})'>Edit</button>
            <button class="delete-btn" onclick="deleteQuiz(${q.QuizId})">Delete</button>
          </td>
        `;
        tbody.appendChild(tr);
      });
    }

    function editQuiz(quiz) {
      for (let key in quiz) {
        if (document.getElementById(key)) {
          document.getElementById(key).value = quiz[key];
        }
      }
    }

    async function deleteQuiz(id) {
      if (!confirm(`Delete Quiz ID ${id}?`)) return;

      try {
        const res = await fetch(`${apiBase}/delete`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: `QuizId=${encodeURIComponent(id)}`
        });

        if (!res.ok) throw new Error('Delete failed');
        alert('Quiz deleted');
        fetchQuizzes();
      } catch (err) {
        alert('Error deleting quiz.');
      }
    }

    document.getElementById('quizForm').addEventListener('submit', async (e) => {
      e.preventDefault();
      const form = e.target;
      const formData = new FormData(form);
      const data = new URLSearchParams(formData).toString();

      const isEdit = form.QuizId.value;
      const endpoint = isEdit ? '/modify' : '/add';

      try {
        const res = await fetch(`${apiBase}${endpoint}`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: data
        });

        if (!res.ok) throw new Error('Submission failed');
        alert(`Quiz ${isEdit ? 'updated' : 'added'} successfully!`);
        form.reset();
        fetchQuizzes();
      } catch (err) {
        alert('Error submitting quiz.');
      }
    });
  </script>
</body>
</html>

