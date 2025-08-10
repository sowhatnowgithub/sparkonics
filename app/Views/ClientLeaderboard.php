<?php
session_start();
$pdo = new PDO("sqlite:$dbPath");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$clientId = $_SESSION['client_id'];

// Fetch all quizzes
$quizList = $pdo->query("SELECT QuizId, QuizName FROM Quizes ORDER BY QuizName")->fetchAll(PDO::FETCH_ASSOC);

// Fetch ALL quiz client data at once
$stmt = $pdo->query("
    SELECT 
        c.ClientId, 
        c.ClientName, 
        qc.QuizTotalScore, 
        qc.QuizQuestionOptions,
        q.QuizId,
        q.QuizName
    FROM QuizClient qc
    JOIN Clients c ON qc.ClientId = c.ClientId
    JOIN Quizes q ON q.QuizId = qc.QuizId
    ORDER BY q.QuizName, qc.QuizTotalScore DESC, c.ClientName ASC
");
$allLeaderboardData = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard - Sparkonics</title>
    <style>
        :root {
            --background: rgb(1, 6, 15);
            --foreground: rgb(144, 252, 253);
            --primary: rgb(246, 231, 82);
            --muted-foreground: rgba(246, 231, 82, 0.6);
            --card-bg: rgba(15, 23, 42, 0.8);
            --border-color: rgba(246, 231, 82, 0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--background);
            background: url("/images/logo.png") no-repeat center center fixed;
            background-size: cover;
            backdrop-filter: blur(5px);
            color: var(--foreground);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: var(--primary);
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .quiz-selector {
            background: var(--card-bg);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            backdrop-filter: blur(10px);
        }

        .quiz-selector h2 {
            color: var(--primary);
            margin-bottom: 15px;
            font-size: 1.3rem;
        }

        select {
            background: var(--background);
            border: 2px solid var(--border-color);
            border-radius: 8px;
            color: var(--foreground);
            padding: 12px 15px;
            font-size: 1rem;
            width: 100%;
            max-width: 400px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(246, 231, 82, 0.2);
        }

        select option {
            background: var(--background);
            color: var(--foreground);
        }

        .leaderboard-card {
            background: var(--card-bg);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .leaderboard-header {
            background: linear-gradient(135deg, var(--primary), #f9d71c);
            color: var(--background);
            padding: 20px;
            text-align: center;
        }

        .leaderboard-header h2 {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        th {
            background: rgba(246, 231, 82, 0.1);
            color: var(--primary);
            padding: 15px 12px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        td {
            padding: 15px 12px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: top;
        }

        .rank-cell {
            font-weight: bold;
            color: var(--primary);
            text-align: center;
            min-width: 80px;
        }

        .rank-1 { color: #ffd700; font-size: 1.2rem; }
        .rank-2 { color: #c0c0c0; font-size: 1.1rem; }
        .rank-3 { color: #cd7f32; font-size: 1.1rem; }

        .username-cell {
            font-weight: 500;
            min-width: 150px;
        }

        .score-cell {
            font-weight: bold;
            color: var(--primary);
            text-align: center;
            min-width: 80px;
            font-size: 1.1rem;
        }

        .answers-cell {
            min-width: 250px;
        }

        .answer-item {
            display: inline-block;
            margin: 2px;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            white-space: nowrap;
        }

        .answer-correct {
            background: rgba(34, 197, 94, 0.2);
            border: 1px solid rgba(34, 197, 94, 0.5);
            color: #22c55e;
        }

        .answer-wrong {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.5);
            color: #ef4444;
        }

        .highlight-user {
            background: rgba(246, 231, 82, 0.15);
            border-left: 4px solid var(--primary);
        }

        .highlight-user td {
            font-weight: 600;
        }

        .user-status {
            background: var(--card-bg);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .user-rank {
            font-size: 1.2rem;
            color: var(--primary);
            font-weight: bold;
        }

        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: var(--muted-foreground);
            font-size: 1.1rem;
        }



        .hidden {
            display: none;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .header h1 {
                font-size: 2rem;
            }

            table {
                min-width: 500px;
            }

            th, td {
                padding: 10px 8px;
                font-size: 0.9rem;
            }

            .answer-item {
                font-size: 0.75rem;
                padding: 3px 6px;
                margin: 1px;
            }

            .rank-cell, .score-cell {
                min-width: 60px;
            }

            .username-cell {
                min-width: 100px;
            }

            .answers-cell {
                min-width: 180px;
            }
        }

        @media (max-width: 480px) {
            .header h1 {
                font-size: 1.5rem;
            }

            .quiz-selector {
                padding: 15px;
            }

            table {
                min-width: 450px;
            }

            th, td {
                padding: 8px 6px;
                font-size: 0.85rem;
            }

            .answer-item {
                font-size: 0.7rem;
                padding: 2px 4px;
            }
        }

        /* Loading animation */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <script src="/app/Views/Navbar.js"></script>
    
    <div class="container">
        <div class="header">
            <h1>🏆 Leaderboard</h1>
        </div>



        <div class="quiz-selector fade-in">
            <h2>Select Quiz</h2>
            <select id="quizSelector" onchange="switchQuiz()">
                <option value="">Choose a quiz...</option>
                <?php foreach ($quizList as $quiz): ?>
                    <option value="<?= htmlspecialchars($quiz['QuizId']) ?>">
                        <?= htmlspecialchars($quiz['QuizName']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div id="leaderboardContainer">
            <!-- Leaderboard will be populated by JavaScript -->
        </div>
    </div>

    <script>
        // Store all data in JavaScript
        const quizData = <?= json_encode($quizList) ?>;
        const leaderboardData = <?= json_encode($allLeaderboardData) ?>;
        const currentUserId = <?= json_encode($clientId) ?>;



        function parseAnswerOptions(optionsString) {
            const answers = [];
            
            if (optionsString && optionsString.trim()) {
                // Remove leading comma and split
                const cleanString = optionsString.startsWith(',') ? optionsString.substring(1) : optionsString;
                const optionPairs = cleanString.split(',');
                
                optionPairs.forEach((pair, index) => {
                    const trimmedPair = pair.trim();
                    if (trimmedPair) { // Skip empty pairs
                        const parts = trimmedPair.split('&');
                        
                        if (parts.length >= 3) {
                            answers.push({
                                questionId: parts[0],
                                chosenOption: parts[1],
                                isCorrect: parts[2] === '1'
                            });
                        }
                    }
                });
            }
            
            return answers;
        }

        function switchQuiz() {
            const selectedQuizId = document.getElementById('quizSelector').value;
            const container = document.getElementById('leaderboardContainer');
            
            if (!selectedQuizId) {
                container.innerHTML = '';
                return;
            }

            // Filter data for selected quiz - ensure both are treated as strings for comparison
            const quizLeaders = leaderboardData.filter(item => {
                return item.QuizId.toString() === selectedQuizId.toString();
            });
            
            if (quizLeaders.length === 0) {
                container.innerHTML = `
                    <div class="leaderboard-card fade-in">
                        <div class="no-data">
                            <p>No participants found for this quiz.</p>
                            <p style="margin-top: 10px; color: var(--muted-foreground);">Be the first to take the challenge!</p>
                        </div>
                    </div>
                `;
                return;
            }

            const selectedQuizName = quizLeaders[0].QuizName;
            let userRank = null;
            
            // Find user rank
            quizLeaders.forEach((leader, index) => {
                if (leader.ClientId.toString() === currentUserId.toString()) {
                    userRank = index + 1;
                }
            });

            // Generate leaderboard HTML
            let tableRows = '';
            quizLeaders.forEach((leader, index) => {
                const rank = index + 1;
                const isCurrentUser = leader.ClientId.toString() === currentUserId.toString();
                const answers = parseAnswerOptions(leader.QuizQuestionOptions);
                
                let rankDisplay;
                if (rank === 1) rankDisplay = "🥇 #" + rank;
                else if (rank === 2) rankDisplay = "🥈 #" + rank;
                else if (rank === 3) rankDisplay = "🥉 #" + rank;
                else rankDisplay = "#" + rank;

                let answerItems = '';
                if (answers.length > 0) {
                    answers.forEach(answer => {
                        const cssClass = answer.isCorrect ? 'answer-correct' : 'answer-wrong';
                        const symbol = answer.isCorrect ? '✓' : '✗';
                        answerItems += `<span class="answer-item ${cssClass}">Q${answer.questionId}: ${answer.chosenOption} ${symbol}</span>`;
                    });
                } else {
                    answerItems = '<span style="color: var(--muted-foreground);">No answer data available</span>';
                }

                const rowClass = isCurrentUser ? 'highlight-user' : '';
                const rankClass = `rank-${Math.min(rank, 3)}`;
                const userIndicator = isCurrentUser ? ' <span style="color: var(--primary);">(You)</span>' : '';

                tableRows += `
                    <tr class="${rowClass}">
                        <td class="rank-cell ${rankClass}">${rankDisplay}</td>
                        <td class="username-cell">${leader.ClientName}${userIndicator}</td>
                        <td class="score-cell">${leader.QuizTotalScore}</td>
                        <td class="answers-cell">${answerItems}</td>
                    </tr>
                `;
            });

            const userStatusHtml = userRank 
                ? `<p class="user-rank">Your Rank: #${userRank} out of ${quizLeaders.length} participants</p>`
                : `<p style="color: var(--muted-foreground);">You haven't attempted this quiz yet.</p>`;

            container.innerHTML = `
                <div class="leaderboard-card fade-in">
                    <div class="leaderboard-header">
                        <h2>${selectedQuizName}</h2>
                    </div>
                    
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Username</th>
                                    <th>Score</th>
                                    <th>Answer Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${tableRows}
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="user-status fade-in">
                    ${userStatusHtml}
                </div>
            `;
        }

        // Initialize with first quiz if available
        document.addEventListener('DOMContentLoaded', function() {
            if (quizData.length > 0) {
                document.getElementById('quizSelector').value = quizData[0].QuizId;
                switchQuiz();
            } else {
                document.getElementById('leaderboardContainer').innerHTML = `
                    <div class="leaderboard-card fade-in">
                        <div class="no-data">
                            <p>No quizzes available.</p>
                        </div>
                    </div>
                `;
            }
        });
    </script>
</body>
</html>
