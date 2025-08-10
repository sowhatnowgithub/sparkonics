<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['client_id'])) {
    header('Location: /login.php');
    exit();
}

$clientId = $_SESSION['client_id'];
$client = null;
$quizzes = [];
$totalQuizzes = 0;

try {
    // Assuming $dbPath is defined elsewhere or use your database path
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get client data
    $stmtClient = $pdo->prepare("SELECT ClientName, ClientWebMail, ClientMobile, ClientDegree, ClientRollNo FROM Clients WHERE ClientId = ?");
    $stmtClient->execute([$clientId]);
    $client = $stmtClient->fetch(PDO::FETCH_ASSOC);
    
    if (!$client) {
        throw new Exception("Client not found.");
    }
    
    // Get all quizzes attempted by this client from QuizClient table
    $stmtQuizClient = $pdo->prepare("
        SELECT DISTINCT qc.QuizId, qc.QuizQuestionOptions, qc.QuizTotalScore,
               q.QuizName, q.QuizDesc, q.QuizStarts, q.QuizQuestionScore
        FROM QuizClient qc
        JOIN Quizes q ON qc.QuizId = q.QuizId
        WHERE qc.ClientId = ?
        ORDER BY qc.QuizId DESC
    ");
    $stmtQuizClient->execute([$clientId]);
    $quizzes = $stmtQuizClient->fetchAll(PDO::FETCH_ASSOC);
    
    // For each quiz, get total questions count
    foreach ($quizzes as $quiz) {
        $stmtCount = $pdo->prepare("SELECT COUNT(*) FROM QuizQuestions WHERE QuizId = ?");
        $stmtCount->execute([$quiz['QuizId']]);
        $quiz['TotalQuestions'] = $stmtCount->fetchColumn();
        $quiz['MaxPossibleScore'] = $quiz['TotalQuestions'] * $quiz['QuizQuestionScore'];
    }
    
    $totalQuizzes = count($quizzes);
    
} catch (Exception $e) {
    $error = "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sparkonics</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --navbar-bg: rgb(1, 6, 15);
            --navbar-fg: rgb(144, 252, 253);
            --navbar-primary: rgb(246, 231, 82);
            
            --primary: rgb(246, 231, 82);
            --primary-dark: rgb(226, 211, 62);
            --secondary: rgb(144, 252, 253);
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --background: rgb(1, 6, 15);
            --surface: rgba(144, 252, 253, 0.05);
            --surface-light: rgba(144, 252, 253, 0.1);
            --text: rgb(144, 252, 253);
            --text-muted: rgba(144, 252, 253, 0.7);
            --border: rgba(144, 252, 253, 0.2);
            --shadow: rgba(0, 0, 0, 0.3);
            --gradient: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--background);
            color: var(--text);
            line-height: 1.6;
            min-height: 100vh;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            gap: 2rem;
            display: flex;
            flex-direction: column;
        }

        /* Header Section */
        .dashboard-header {
            background: var(--gradient);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 25px var(--shadow);
        }

        .dashboard-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--background);
        }

        .dashboard-header p {
            font-size: 1.1rem;
            opacity: 0.9;
            color: var(--background);
        }

        /* Profile Section */
        .profile-section {
            background: var(--surface);
            border-radius: 16px;
            border: 1px solid var(--border);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .profile-header {
            background: var(--gradient);
            padding: 1.5rem;
            color: var(--background);
        }

        .profile-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .profile-content {
            padding: 2rem;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .profile-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .profile-label {
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .profile-value {
            color: var(--text);
            font-size: 1.1rem;
            font-weight: 500;
            padding: 0.75rem 1rem;
            background: var(--surface-light);
            border-radius: 8px;
            border: 1px solid var(--border);
        }

        /* Quizzes Section */
        .quizzes-section {
            background: var(--surface);
            border-radius: 16px;
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .quizzes-header {
            background: var(--gradient);
            padding: 1.5rem;
            color: var(--background);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .quizzes-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .quiz-count {
            background: rgba(1, 6, 15, 0.2);
            color: var(--background);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .quizzes-content {
            padding: 2rem;
        }

        .quiz-card {
            background: var(--surface-light);
            border: 1px solid var(--border);
            border-radius: 12px;
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .quiz-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px var(--shadow);
        }

        .quiz-card-header {
            padding: 1.5rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
        }

        .quiz-info h3 {
            color: var(--text);
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .quiz-info p {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .quiz-meta {
            color: var(--text-muted);
            font-size: 0.85rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .quiz-meta span {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .quiz-score-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .score-display {
            text-align: right;
        }

        .score-points {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .score-max {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .expand-icon {
            color: var(--text-muted);
            transition: transform 0.3s ease;
            font-size: 1.2rem;
        }

        .expand-icon.expanded {
            transform: rotate(180deg);
        }

        .quiz-details {
            padding: 1.5rem;
            background: var(--background);
            border-top: 1px solid var(--border);
            display: none;
        }

        .quiz-details.show {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                max-height: 0;
            }
            to {
                opacity: 1;
                max-height: 500px;
            }
        }

        .question-list {
            list-style: none;
            padding: 0;
        }

        .question-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            background: var(--surface-light);
            border-radius: 8px;
            border-left: 4px solid transparent;
        }

        .question-item.correct {
            border-left-color: var(--success);
            background: rgba(16, 185, 129, 0.1);
        }

        .question-item.wrong {
            border-left-color: var(--danger);
            background: rgba(239, 68, 68, 0.1);
        }

        .question-text {
            font-weight: 500;
        }

        .question-status {
            font-size: 0.9rem;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
        }

        .question-status.correct {
            background: var(--success);
            color: white;
        }

        .question-status.wrong {
            background: var(--danger);
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            font-size: 1rem;
        }

        /* Error State */
        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid var(--danger);
            color: var(--danger);
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            text-align: center;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 1rem;
            }

            .dashboard-header {
                padding: 1.5rem;
            }

            .dashboard-header h1 {
                font-size: 2rem;
            }

            .profile-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .quiz-card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .quiz-score-section {
                align-self: flex-end;
            }

            .quizzes-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .quiz-meta {
                flex-direction: column;
                gap: 0.5rem;
            }
        }

        @media (max-width: 480px) {
            .profile-content,
            .quizzes-content {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <script src="/app/Views/Navbar.js"></script>
    
    <div class="dashboard-container">
        <?php if (isset($error)): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-triangle"></i>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php else: ?>
            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <h1>Welcome back, <?= htmlspecialchars($client['ClientName'] ?? 'Student') ?>!</h1>
                <p>View your quiz attempts and results</p>
            </div>

            <!-- Profile Section -->
            <div class="profile-section">
                <div class="profile-header">
                    <h2>
                        <i class="fas fa-user"></i>
                        Your Profile
                    </h2>
                </div>
                <div class="profile-content">
                    <div class="profile-grid">
                        <div class="profile-item">
                            <div class="profile-label">Full Name</div>
                            <div class="profile-value"><?= htmlspecialchars($client['ClientName'] ?? 'Not provided') ?></div>
                        </div>
                        <div class="profile-item">
                            <div class="profile-label">Email Address</div>
                            <div class="profile-value"><?= htmlspecialchars($client['ClientWebMail'] ?? 'Not provided') ?></div>
                        </div>
                        <div class="profile-item">
                            <div class="profile-label">Mobile Number</div>
                            <div class="profile-value"><?= htmlspecialchars($client['ClientMobile'] ?? 'Not provided') ?></div>
                        </div>
                        <div class="profile-item">
                            <div class="profile-label">Department</div>
                            <div class="profile-value"><?= htmlspecialchars($client['ClientDegree'] ?? 'Not provided') ?></div>
                        </div>
                        <div class="profile-item">
                            <div class="profile-label">Roll Number</div>
                            <div class="profile-value"><?= htmlspecialchars($client['ClientRollNo'] ?? 'Not provided') ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quizzes Section -->
            <div class="quizzes-section">
                <div class="quizzes-header">
                    <h2>
                        <i class="fas fa-list-alt"></i>
                        Your Quiz Attempts
                    </h2>
                    <?php if ($totalQuizzes > 0): ?>
                        <div class="quiz-count"><?= $totalQuizzes ?> Quiz<?= $totalQuizzes !== 1 ? 'es' : '' ?></div>
                    <?php endif; ?>
                </div>
                <div class="quizzes-content">
                    <?php if (empty($quizzes)): ?>
                        <div class="empty-state">
                            <i class="fas fa-clipboard-question"></i>
                            <h3>No Quizzes Attempted</h3>
                            <p>You haven't taken any quizzes yet. Start taking quizzes to see your results here!</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($quizzes as $index => $quiz): ?>
                            <div class="quiz-card">
                                <div class="quiz-card-header" onclick="toggleQuizDetails(<?= $index ?>)">
                                    <div class="quiz-info">
                                        <h3><?= htmlspecialchars($quiz['QuizName']) ?></h3>
                                        <p><?= htmlspecialchars($quiz['QuizDesc']) ?></p>
                                        <div class="quiz-meta">
                                            <span>
                                                <i class="fas fa-calendar"></i>
                                                <?= date('M d, Y', strtotime($quiz['QuizStarts'])) ?>
                                            </span>
                                            <span>
                                                <i class="fas fa-question-circle"></i>
                                                <?= $quiz['TotalQuestions'] ?> Questions
                                            </span>
                                            <span>
                                                <i class="fas fa-star"></i>
                                                <?= $quiz['QuizQuestionScore'] ?> pts each
                                            </span>
                                        </div>
                                    </div>
                                    <div class="quiz-score-section">
                                        <div class="score-display">
                                            <div class="score-points"><?= $quiz['QuizTotalScore'] ?></div>
                                            <div class="score-max">out of <?= $quiz['MaxPossibleScore'] ?> pts</div>
                                        </div>
                                        <i class="fas fa-chevron-down expand-icon" id="icon-<?= $index ?>"></i>
                                    </div>
                                </div>
                                <div class="quiz-details" id="details-<?= $index ?>">
                                    <h4 style="color: var(--text); margin-bottom: 1rem;">
                                        <i class="fas fa-list"></i>
                                        Question Results:
                                    </h4>
                                    <ul class="question-list">
                                        <?php
                                        if (!empty($quiz['QuizQuestionOptions'])) {
                                            $questionSet = explode(',', $quiz['QuizQuestionOptions']);
                                            
                                            foreach ($questionSet as $q) {
                                                $parts = explode('&', trim($q));
                                                if (count($parts) === 3) {
                                                    [$qNum, $selected, $isCorrect] = $parts;
                                                    $isCorrect = (bool)$isCorrect;
                                                    
                                                    echo "<li class='question-item " . ($isCorrect ? 'correct' : 'wrong') . "'>";
                                                    echo "<span class='question-text'>Question " . (intval($qNum) + 1) . ": Selected Option " . (intval($selected) + 1) . "</span>";
                                                    echo "<span class='question-status " . ($isCorrect ? 'correct' : 'wrong') . "'>";
                                                    echo "<i class='fas fa-" . ($isCorrect ? 'check' : 'times') . "'></i> ";
                                                    echo ($isCorrect ? 'Correct' : 'Wrong');
                                                    echo "</span>";
                                                    echo "</li>";
                                                }
                                            }
                                        } else {
                                            echo "<li class='question-item'><span class='question-text'>No detailed results available</span></li>";
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        let openQuizIndex = -1;
        
        function toggleQuizDetails(index) {
            const details = document.getElementById(`details-${index}`);
            const icon = document.getElementById(`icon-${index}`);
            
            // Close previously opened quiz
            if (openQuizIndex !== -1 && openQuizIndex !== index) {
                const oldDetails = document.getElementById(`details-${openQuizIndex}`);
                const oldIcon = document.getElementById(`icon-${openQuizIndex}`);
                if (oldDetails && oldIcon) {
                    oldDetails.classList.remove('show');
                    oldIcon.classList.remove('expanded');
                    setTimeout(() => {
                        oldDetails.style.display = 'none';
                    }, 300);
                }
            }
            
            if (details.classList.contains('show')) {
                details.classList.remove('show');
                icon.classList.remove('expanded');
                setTimeout(() => {
                    details.style.display = 'none';
                }, 300);
                openQuizIndex = -1;
            } else {
                details.style.display = 'block';
                setTimeout(() => {
                    details.classList.add('show');
                    icon.classList.add('expanded');
                }, 10);
                openQuizIndex = index;
            }
        }
    </script>
</body>
</html>
