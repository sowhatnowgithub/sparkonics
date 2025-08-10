<?php
// Ensure $data is available and properly formatted
if (!isset($data) || !is_array($data) || !isset($data['quiz']) || !isset($data['questions'])) {
    die('Quiz data not available. Please contact administrator.');
}

$quiz = $data['quiz'][0] ?? null;
$questions = $data['questions'] ?? [];

if (!$quiz || empty($questions)) {
    die('Invalid quiz data. Please contact administrator.');
}

// Calculate quiz duration and validate timing
$startTime = new DateTime($quiz['QuizStarts']);
$endTime = new DateTime($quiz['QuizEnds']);
$currentTime = new DateTime();

$quizStarted = $currentTime >= $startTime;
$quizEnded = $currentTime >= $endTime;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($quiz['QuizName']) ?> - Sparkonics</title>
  <style>
    :root {
      --background: rgb(1, 6, 15);
      --foreground: rgb(144, 252, 253);
      --primary: rgb(246, 231, 82);
      --success: #10b981;
      --danger: #ef4444;
      --warning: #f59e0b;
      --card-bg: rgba(144, 252, 253, 0.05);
      --border: rgba(144, 252, 253, 0.2);
      --shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
      --gradient: linear-gradient(135deg, var(--background) 0%, rgba(1, 6, 15, 0.95) 100%);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: var(--gradient);
      color: var(--foreground);
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* Error/Warning Messages */
    .alert {
      background: var(--card-bg);
      border: 2px solid var(--border);
      border-radius: 15px;
      padding: 20px;
      margin: 20px;
      text-align: center;
      backdrop-filter: blur(20px);
    }

    .alert.danger {
      border-color: var(--danger);
      background: rgba(239, 68, 68, 0.1);
    }

    .alert.warning {
      border-color: var(--warning);
      background: rgba(245, 158, 11, 0.1);
    }

    .alert h3 {
      color: var(--primary);
      margin-bottom: 10px;
      font-size: 1.5rem;
    }

    .alert p {
      font-size: 1.1rem;
      line-height: 1.6;
    }

    /* Rules Modal */
    .modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.8);
      backdrop-filter: blur(10px);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1000;
      padding: 20px;
    }

    .modal-content {
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 30px;
      max-width: 500px;
      width: 100%;
      backdrop-filter: blur(20px);
      box-shadow: var(--shadow);
      text-align: center;
    }

    .modal-title {
      color: var(--primary);
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 20px;
    }

    .rules-list {
      text-align: left;
      margin: 20px 0;
      padding: 0;
      list-style: none;
    }

    .rules-list li {
      padding: 12px 0;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: flex-start;
      gap: 10px;
    }

    .rules-list li:last-child {
      border-bottom: none;
    }

    .rule-icon {
      color: var(--primary);
      font-weight: bold;
      margin-top: 2px;
    }

    .agree-btn {
      background: linear-gradient(135deg, var(--primary) 0%, rgba(246, 231, 82, 0.8) 100%);
      color: var(--background);
      border: none;
      padding: 15px 40px;
      border-radius: 25px;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 20px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .agree-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 30px rgba(246, 231, 82, 0.4);
    }

    /* Quiz Container */
    .quiz-container {
      display: none;
      padding: 20px;
      max-width: 600px;
      margin: 0 auto;
      min-height: 100vh;
    }

    /* Header */
    .quiz-header {
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 20px;
      margin-bottom: 20px;
      backdrop-filter: blur(20px);
      box-shadow: var(--shadow);
      text-align: center;
    }

    .quiz-title {
      color: var(--primary);
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 8px;
    }

    .quiz-description {
      color: var(--foreground);
      opacity: 0.8;
      margin-bottom: 15px;
    }

    .time-info {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
      gap: 15px;
      margin-top: 15px;
    }

    .time-card {
      background: rgba(246, 231, 82, 0.1);
      border: 1px solid rgba(246, 231, 82, 0.3);
      border-radius: 12px;
      padding: 12px;
      text-align: center;
    }

    .time-label {
      font-size: 0.8rem;
      color: var(--primary);
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .time-value {
      font-size: 1.1rem;
      font-weight: 700;
      color: var(--foreground);
      margin-top: 4px;
    }

    .remaining-time {
      background: rgba(239, 68, 68, 0.1);
      border-color: rgba(239, 68, 68, 0.3);
    }

    .remaining-time .time-label {
      color: var(--danger);
    }

    /* Progress Bar */
    .progress-container {
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: 15px;
      padding: 15px;
      margin-bottom: 20px;
      backdrop-filter: blur(20px);
    }

    .progress-info {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }

    .progress-text {
      font-size: 0.9rem;
      font-weight: 600;
    }

    .progress-bar {
      width: 100%;
      height: 8px;
      background: rgba(144, 252, 253, 0.1);
      border-radius: 4px;
      overflow: hidden;
    }

    .progress-fill {
      height: 100%;
      background: linear-gradient(90deg, var(--primary), rgba(246, 231, 82, 0.8));
      border-radius: 4px;
      transition: width 0.3s ease;
      width: 0%;
    }

    /* Question Card */
    .question-card {
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 25px;
      margin-bottom: 20px;
      backdrop-filter: blur(20px);
      box-shadow: var(--shadow);
    }

    .question-number {
      color: var(--primary);
      font-size: 0.9rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 15px;
    }

    .question-text {
      font-size: 1.2rem;
      line-height: 1.6;
      margin-bottom: 20px;
      font-weight: 500;
    }

    .question-image {
      width: 100%;
      max-width: 400px;
      height: auto;
      border-radius: 12px;
      margin: 20px 0;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
      display: block;
      margin-left: auto;
      margin-right: auto;
    }

    /* Options */
    .options-container {
      margin-bottom: 25px;
    }

    .option {
      background: rgba(144, 252, 253, 0.03);
      border: 2px solid var(--border);
      border-radius: 15px;
      padding: 15px 20px;
      margin-bottom: 12px;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 15px;
      position: relative;
      overflow: hidden;
    }

    .option::before {
      content: '';
      position: absolute;
      left: -100%;
      top: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(246, 231, 82, 0.1), transparent);
      transition: left 0.5s ease;
    }

    .option:hover::before {
      left: 100%;
    }

    .option:hover {
      border-color: var(--primary);
      background: rgba(246, 231, 82, 0.08);
      transform: translateX(5px);
    }

    .option.selected {
      border-color: var(--primary);
      background: rgba(246, 231, 82, 0.15);
      box-shadow: 0 4px 15px rgba(246, 231, 82, 0.2);
    }

    .option.disabled {
      opacity: 0.6;
      cursor: not-allowed;
    }

    .option-radio {
      width: 20px;
      height: 20px;
      border: 2px solid var(--border);
      border-radius: 50%;
      position: relative;
      flex-shrink: 0;
      transition: all 0.3s ease;
    }

    .option.selected .option-radio {
      border-color: var(--primary);
      background: var(--primary);
    }

    .option.selected .option-radio::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 8px;
      height: 8px;
      background: var(--background);
      border-radius: 50%;
    }

    .option-text {
      flex: 1;
      font-size: 1rem;
      line-height: 1.4;
    }

    .option-letter {
      background: var(--primary);
      color: var(--background);
      width: 28px;
      height: 28px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 0.9rem;
      flex-shrink: 0;
    }

    /* Navigation Buttons */
    .nav-buttons {
      display: flex;
      gap: 15px;
      justify-content: center;
    }

    .nav-btn {
      padding: 15px 30px;
      border: none;
      border-radius: 25px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .btn-prev {
      background: var(--card-bg);
      color: var(--foreground);
      border: 2px solid var(--border);
    }

    .btn-prev:hover {
      border-color: var(--primary);
      background: rgba(246, 231, 82, 0.1);
    }

    .btn-next {
      background: linear-gradient(135deg, var(--primary) 0%, rgba(246, 231, 82, 0.8) 100%);
      color: var(--background);
    }

    .btn-next:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(246, 231, 82, 0.4);
    }

    .btn-submit {
      background: linear-gradient(135deg, var(--success) 0%, rgba(16, 185, 129, 0.8) 100%);
      color: white;
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
    }

    .nav-btn:disabled {
      opacity: 0.5;
      cursor: not-allowed;
      transform: none !important;
    }

    /* Completion Screen */
    .completion-screen {
      display: none;
      text-align: center;
      padding: 40px 20px;
    }

    .completion-icon {
      font-size: 4rem;
      color: var(--success);
      margin-bottom: 20px;
    }

    .completion-title {
      color: var(--primary);
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 15px;
    }

    .completion-message {
      font-size: 1.1rem;
      line-height: 1.6;
      opacity: 0.9;
    }

    /* Loading States */
    .loading {
      display: none;
      text-align: center;
      padding: 30px;
    }

    .spinner {
      width: 40px;
      height: 40px;
      border: 3px solid var(--border);
      border-top: 3px solid var(--primary);
      border-radius: 50%;
      animation: spin 1s linear infinite;
      margin: 0 auto 15px;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    /* Mobile Optimizations */
    @media (max-width: 480px) {
      .quiz-container {
        padding: 15px;
      }

      .modal-content {
        padding: 20px;
        margin: 15px;
      }

      .modal-title {
        font-size: 1.5rem;
      }

      .quiz-title {
        font-size: 1.3rem;
      }

      .question-text {
        font-size: 1.1rem;
      }

      .time-info {
        grid-template-columns: 1fr 1fr;
        gap: 10px;
      }

      .nav-buttons {
        flex-direction: column;
        gap: 10px;
      }

      .nav-btn {
        padding: 12px 25px;
        font-size: 0.9rem;
      }

      .option {
        padding: 12px 15px;
      }
    }

    /* Animations */
    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .question-card {
      animation: slideIn 0.5s ease-out;
    }
  </style>
</head>
<body>
  <?php if ($quizEnded): ?>
    <!-- Quiz Ended -->
    <div class="alert danger">
      <h3>Quiz Has Ended</h3>
      <p>This quiz ended on <?= $endTime->format('F j, Y \a\t g:i A') ?>. You can no longer take this quiz.</p>
    </div>
  <?php elseif (!$quizStarted): ?>
    <!-- Quiz Not Started -->
    <div class="alert warning">
      <h3>Quiz Not Started Yet</h3>
      <p>This quiz will start on <?= $startTime->format('F j, Y \a\t g:i A') ?>. Please come back at the scheduled time.</p>
      <p><strong>Time remaining until start:</strong> <span id="timeUntilStart"></span></p>
    </div>
    <script>
      // Countdown to quiz start
      const startTime = new Date('<?= $startTime->format('c') ?>');
      
      function updateCountdown() {
        const now = new Date();
        const timeLeft = startTime - now;
        
        if (timeLeft <= 0) {
          location.reload();
          return;
        }
        
        const hours = Math.floor(timeLeft / (1000 * 60 * 60));
        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
        
        document.getElementById('timeUntilStart').textContent = 
          `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
      }
      
      setInterval(updateCountdown, 1000);
      updateCountdown();
    </script>
  <?php else: ?>
    <!-- Rules Modal -->
    <div class="modal" id="rulesModal">
      <div class="modal-content">
        <h2 class="modal-title">📋 Quiz Rules</h2>
        <ul class="rules-list">
          <li>
            <span class="rule-icon">⏰</span>
            <span>Complete the quiz within the given time limit</span>
          </li>
          <li>
            <span class="rule-icon">❓</span>
            <span>You can navigate between questions but can only answer each question once</span>
          </li>
          <li>
            <span class="rule-icon">✅</span>
            <span>Select your answer and click "Submit Answer" for each question</span>
          </li>
          <li>
            <span class="rule-icon">🚫</span>
            <span>Once submitted, you cannot change your answer</span>
          </li>
          <li>
            <span class="rule-icon">📱</span>
            <span>Do not refresh the page or go back during the quiz</span>
          </li>
          <li>
            <span class="rule-icon">🎯</span>
            <span>Answer all questions to complete the quiz successfully</span>
          </li>
        </ul>
        <button class="agree-btn" onclick="startQuiz()">I Understand & Agree</button>
      </div>
    </div>

    <!-- Quiz Container -->
    <div class="quiz-container" id="quizContainer">
      <!-- Header -->
      <div class="quiz-header">
        <h1 class="quiz-title"><?= htmlspecialchars($quiz['QuizName']) ?></h1>
        <p class="quiz-description"><?= htmlspecialchars($quiz['QuizDesc']) ?></p>
        
        <div class="time-info">
          <div class="time-card">
            <div class="time-label">Current Time</div>
            <div class="time-value" id="currentTime">--:--</div>
          </div>
          <div class="time-card">
            <div class="time-label">Quiz Ends</div>
            <div class="time-value"><?= $endTime->format('g:i A') ?></div>
          </div>
          <div class="time-card remaining-time">
            <div class="time-label">Time Left</div>
            <div class="time-value" id="timeLeft">--:--</div>
          </div>
        </div>
      </div>

      <!-- Progress -->
      <div class="progress-container">
        <div class="progress-info">
          <span class="progress-text" id="progressText">Question 1 of <?= count($questions) ?></span>
          <span class="progress-text" id="answeredCount">Answered: 0</span>
        </div>
        <div class="progress-bar">
          <div class="progress-fill" id="progressFill"></div>
        </div>
      </div>

      <!-- Question -->
      <div class="question-card" id="questionCard">
        <div class="loading" id="questionLoading">
          <div class="spinner"></div>
          <p>Loading question...</p>
        </div>
        
        <div id="questionContent" style="display: none;">
          <div class="question-number" id="questionNumber">Question 1</div>
          <div class="question-text" id="questionText">Loading question...</div>
          <img class="question-image" id="questionImage" style="display: none;" alt="Question Image">
          
          <div class="options-container" id="optionsContainer">
            <!-- Options will be populated by JavaScript -->
          </div>
        </div>
      </div>

      <!-- Navigation -->
      <div class="nav-buttons">
        <button class="nav-btn btn-prev" id="prevBtn" onclick="previousQuestion()" disabled>
          ← Previous
        </button>
        <button class="nav-btn btn-next" id="nextBtn" onclick="nextQuestion()">
          Next →
        </button>
        <button class="nav-btn btn-submit" id="submitBtn" onclick="submitAnswer()" style="display: none;">
          Submit Answer
        </button>
      </div>

      <!-- Completion Screen -->
      <div class="completion-screen" id="completionScreen">
        <div class="completion-icon">🎉</div>
        <h2 class="completion-title">Quiz Completed!</h2>
        <p class="completion-message">
          Thank you for taking the quiz. Your answers have been submitted successfully.
          <br><br>
          <a href="/client/dashboard" style="color: var(--primary); text-decoration: none;">← Return to Dashboard</a>
        </p>
      </div>
    </div>

    <script>
      // PHP data passed to JavaScript
      const quizData = <?= json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
      
      let currentQuestionIndex = 0;
      let userAnswers = {};
      let timeInterval;
      let quizEndTime;

      function startQuiz() {
        document.getElementById('rulesModal').style.display = 'none';
        document.getElementById('quizContainer').style.display = 'block';
        
        loadQuizData();
        startTimer();
        displayQuestion();
      }

      function loadQuizData() {
        quizEndTime = new Date('<?= $endTime->format('c') ?>');
        updateProgress();
      }

      function startTimer() {
        timeInterval = setInterval(updateTime, 1000);
        updateTime();
      }

      function updateTime() {
        const now = new Date();
        document.getElementById('currentTime').textContent = now.toLocaleTimeString();
        
        const timeLeft = quizEndTime - now;
        if (timeLeft <= 0) {
          document.getElementById('timeLeft').textContent = "Time's Up!";
          endQuiz();
          return;
        }
        
        const hours = Math.floor(timeLeft / (1000 * 60 * 60));
        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
        
        document.getElementById('timeLeft').textContent = 
          `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
      }

      function displayQuestion() {
        const question = quizData.questions[currentQuestionIndex];
        if (!question) return;

        // Show loading
        document.getElementById('questionLoading').style.display = 'block';
        document.getElementById('questionContent').style.display = 'none';

        setTimeout(() => {
          // Hide loading and show content
          document.getElementById('questionLoading').style.display = 'none';
          document.getElementById('questionContent').style.display = 'block';

          // Update question content
          document.getElementById('questionNumber').textContent = `Question ${currentQuestionIndex + 1}`;
          document.getElementById('questionText').textContent = question.QuizQuestion;

          // Handle image
          const imageElement = document.getElementById('questionImage');
          if (question.QuizQuestionImage && question.QuizQuestionImage.trim() !== "") {
            imageElement.src = question.QuizQuestionImage;
            imageElement.style.display = 'block';
            imageElement.onerror = function() {
              this.style.display = 'none';
            };
          } else {
            imageElement.style.display = 'none';
          }

          // Display options
          displayOptions(question);
          updateNavigation();
          updateProgress();
        }, 500);
      }

      function displayOptions(question) {
        const container = document.getElementById('optionsContainer');
        container.innerHTML = '';

        let options;
        try {
          options = JSON.parse(question.QuizOptions);
        } catch (e) {
          console.error('Error parsing options:', e);
          options = ['Error loading options'];
        }

        // Ensure options is an array
        if (!Array.isArray(options)) {
          options = ['Invalid option format'];
        }

        options.forEach((option, index) => {
          const optionElement = document.createElement('div');
          optionElement.className = 'option';
          
          const isAnswered = userAnswers[question.QuizQuestionId] !== undefined;
          const isSelected = userAnswers[question.QuizQuestionId] === index;
          
          if (isAnswered) {
            optionElement.classList.add('disabled');
          }
          
          if (isSelected) {
            optionElement.classList.add('selected');
          }
          
          if (!isAnswered) {
            optionElement.onclick = () => selectOption(index);
          }

          optionElement.innerHTML = `
            <div class="option-radio"></div>
            <div class="option-letter">${String.fromCharCode(65 + index)}</div>
            <div class="option-text">${escapeHtml(option)}</div>
          `;

          container.appendChild(optionElement);
        });
      }

      function selectOption(optionIndex) {
        const question = quizData.questions[currentQuestionIndex];
        
        // Don't allow selection if already submitted
        if (userAnswers[question.QuizQuestionId] !== undefined) {
          return;
        }

        // Update visual selection
        const options = document.querySelectorAll('.option');
        options.forEach(opt => opt.classList.remove('selected'));
        options[optionIndex].classList.add('selected');

        // Store selection temporarily (not submitted yet)
        window.tempSelection = optionIndex;
        
        // Show submit button
        document.getElementById('submitBtn').style.display = 'inline-block';
        document.getElementById('nextBtn').style.display = 'none';
      }

      async function submitAnswer() {
        const question = quizData.questions[currentQuestionIndex];
        
        if (window.tempSelection === undefined) return;
        
        // Show loading
        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Submitting...';
        submitBtn.disabled = true;

        try {
          const response = await fetch('/client/quiz/score', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `QuizId=${question.QuizId}&QuizQuestionId=${question.QuizQuestionId}&selectedOption=${window.tempSelection}`

          });

          if (response.ok) {
            // Store the answer
            userAnswers[question.QuizQuestionId] = window.tempSelection;
	    console.log(response.json());
            
            // Update display
            displayOptions(question); // Refresh to show disabled state
            
            // Hide submit button, show next
            document.getElementById('submitBtn').style.display = 'none';
            document.getElementById('nextBtn').style.display = 'inline-block';
            
            // Clear temp selection
            window.tempSelection = undefined;
            
            // Update progress
            updateProgress();
            
            // Auto-advance after 1 second if not last question
            setTimeout(() => {
              if (currentQuestionIndex < quizData.questions.length - 1) {
                nextQuestion();
              } else {
                // Check if all questions answered
                const totalAnswered = Object.keys(userAnswers).length;
                if (totalAnswered === quizData.questions.length) {
                  endQuiz();
                }
              }
            }, 1000);
            
          } else {
            throw new Error('Server error');
          }
        } catch (error) {
          console.error('Error submitting answer:', error);
          alert('Failed to submit answer. Please check your connection and try again.');
        } finally {
          // Restore button
          submitBtn.textContent = originalText;
          submitBtn.disabled = false;
        }
      }

      function previousQuestion() {
        if (currentQuestionIndex > 0) {
          currentQuestionIndex--;
          displayQuestion();
        }
      }

      function nextQuestion() {
        if (currentQuestionIndex < quizData.questions.length - 1) {
          currentQuestionIndex++;
          displayQuestion();
        } else {
          // Last question, check if all answered
          const totalAnswered = Object.keys(userAnswers).length;
          if (totalAnswered === quizData.questions.length) {
            endQuiz();
          }
        }
      }

      function updateNavigation() {
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');

        prevBtn.disabled = currentQuestionIndex === 0;
        
        const question = quizData.questions[currentQuestionIndex];
        const isAnswered = userAnswers[question.QuizQuestionId] !== undefined;
        
        if (isAnswered) {
          submitBtn.style.display = 'none';
          nextBtn.style.display = 'inline-block';
          
          if (currentQuestionIndex === quizData.questions.length - 1) {
            const totalAnswered = Object.keys(userAnswers).length;
            if (totalAnswered === quizData.questions.length) {
              nextBtn.textContent = 'Finish Quiz';
              nextBtn.onclick = endQuiz;
            } else {
              nextBtn.textContent = 'Review Unanswered';
              nextBtn.onclick = goToNextUnanswered;
            }
          } else {
            nextBtn.textContent = 'Next →';
            nextBtn.onclick = nextQuestion;
          }
        } else {
          submitBtn.style.display = window.tempSelection !== undefined ? 'inline-block' : 'none';
          nextBtn.style.display = window.tempSelection !== undefined ? 'none' : 'inline-block';
          nextBtn.textContent = 'Skip →';
          nextBtn.onclick = nextQuestion;
        }
      }

      function goToNextUnanswered() {
        // Find next unanswered question
        for (let i = 0; i < quizData.questions.length; i++) {
          const q = quizData.questions[i];
          if (userAnswers[q.QuizQuestionId] === undefined) {
            currentQuestionIndex = i;
            displayQuestion();
            return;
          }
        }
        
        // All answered, finish quiz
        endQuiz();
      }

      function updateProgress() {
        const totalQuestions = quizData.questions.length;
        const answeredCount = Object.keys(userAnswers).length;
        
        document.getElementById('progressText').textContent = `Question ${currentQuestionIndex + 1} of ${totalQuestions}`;
        document.getElementById('answeredCount').textContent = `Answered: ${answeredCount}`;
        
        const progressPercentage = (answeredCount / totalQuestions) * 100;
        document.getElementById('progressFill').style.width = `${progressPercentage}%`;
      }

      function endQuiz() {
        clearInterval(timeInterval);
        
        // Hide quiz elements
        document.getElementById('questionCard').style.display = 'none';
        document.querySelector('.nav-buttons').style.display = 'none';
        document.querySelector('.progress-container').style.display = 'none';
        
        // Show completion screen
        document.getElementById('completionScreen').style.display = 'block';
        
        // Optional: Submit final completion status to server
        submitQuizCompletion();
      }

      async function submitQuizCompletion() {
        try {
          const response = await fetch('/client/quiz/complete', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `QuizId=${quizData.quiz[0].QuizId}`
          });
          
          if (!response.ok) {
            console.warn('Failed to submit quiz completion status');
          }
        } catch (error) {
          console.error('Error submitting quiz completion:', error);
        }
      }

      function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
      }

      // Prevent page refresh/back during quiz
      window.addEventListener('beforeunload', function(e) {
        if (document.getElementById('quizContainer').style.display !== 'none') {
          e.preventDefault();
          e.returnValue = 'You will lose your quiz progress if you leave this page.';
          return 'You will lose your quiz progress if you leave this page.';
        }
      });

      // Initialize when page loads
      document.addEventListener('DOMContentLoaded', function() {
        // Auto-start timer for countdown if quiz hasn't started
        <?php if (!$quizStarted): ?>
          // Timer already handled in PHP section above
        <?php endif; ?>
        
        // Check if quiz data is valid
        if (!quizData || !quizData.quiz || !quizData.questions || quizData.questions.length === 0) {
          alert('Quiz data is invalid. Please contact administrator.');
          return;
        }
        
        console.log('Quiz loaded:', quizData.quiz[0].QuizName);
        console.log('Total questions:', quizData.questions.length);
      });
    </script>
  <?php endif; ?>
</body>
</html>
