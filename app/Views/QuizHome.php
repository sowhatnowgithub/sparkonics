
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Quizzes</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    :root {
      --background: rgb(1, 6, 15);
      --foreground: rgb(144, 252, 253);
      --primary: rgb(246, 231, 82);
      --muted-foreground: rgba(246, 231, 82, 0.6);
      --card-background: rgba(144, 252, 253, 0.05);
      --border-color: rgba(144, 252, 253, 0.2);
      --shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: linear-gradient(135deg, var(--background) 0%, rgba(1, 6, 15, 0.95) 100%);
      color: var(--foreground);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      padding: 20px;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
    }

    .header {
      text-align: center;
      margin-bottom: 40px;
      padding: 20px 0;
    }

    .header h1 {
      color: var(--primary);
      font-size: 2.5rem;
      font-weight: 300;
      letter-spacing: -0.02em;
      margin-bottom: 10px;
      text-shadow: 0 2px 4px rgba(246, 231, 82, 0.3);
    }

    .header p {
      color: var(--muted-foreground);
      font-size: 1.1rem;
    }

    .stats-bar {
      display: flex;
      justify-content: center;
      gap: 30px;
      margin-bottom: 30px;
      flex-wrap: wrap;
    }

    .stat-item {
      background: var(--card-background);
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 20px;
      text-align: center;
      backdrop-filter: blur(10px);
      box-shadow: var(--shadow);
      min-width: 120px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-item:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 40px rgba(246, 231, 82, 0.2);
    }

    .stat-number {
      font-size: 2rem;
      font-weight: bold;
      color: var(--primary);
      display: block;
    }

    .stat-label {
      font-size: 0.9rem;
      color: var(--muted-foreground);
      margin-top: 5px;
    }

    .search-filter {
      margin-bottom: 30px;
      display: flex;
      gap: 15px;
      align-items: center;
      flex-wrap: wrap;
      justify-content: center;
    }

    .search-input {
      background: var(--card-background);
      border: 2px solid var(--border-color);
      border-radius: 25px;
      padding: 12px 20px;
      color: var(--foreground);
      font-size: 1rem;
      width: 300px;
      max-width: 100%;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .search-input:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(246, 231, 82, 0.2);
    }

    .search-input::placeholder {
      color: var(--muted-foreground);
    }

    .filter-select {
      background: var(--card-background);
      border: 2px solid var(--border-color);
      border-radius: 8px;
      padding: 10px 15px;
      color: var(--foreground);
      font-size: 1rem;
      min-width: 150px;
    }

    .filter-select:focus {
      outline: none;
      border-color: var(--primary);
    }

    .quiz-grid {
      display: none; /* Hidden by default, will show on mobile */
    }

    .quiz-table-container {
      background: var(--card-background);
      border: 1px solid var(--border-color);
      border-radius: 16px;
      overflow: hidden;
      box-shadow: var(--shadow);
      backdrop-filter: blur(10px);
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 16px 20px;
      text-align: left;
      border-bottom: 1px solid var(--border-color);
    }

    th {
      background: rgba(246, 231, 82, 0.1);
      color: var(--primary);
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      font-size: 0.85rem;
      position: sticky;
      top: 0;
      z-index: 10;
    }

    tbody tr {
      transition: all 0.3s ease;
    }

    tbody tr:hover {
      background: rgba(246, 231, 82, 0.08);
      transform: translateX(2px);
    }

    .quiz-card {
      background: var(--card-background);
      border: 1px solid var(--border-color);
      border-radius: 16px;
      padding: 24px;
      margin-bottom: 20px;
      backdrop-filter: blur(10px);
      box-shadow: var(--shadow);
      transition: all 0.3s ease;
    }

    .quiz-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 16px 48px rgba(246, 231, 82, 0.15);
      border-color: var(--primary);
    }

    .quiz-card-header {
      display: flex;
      justify-content: space-between;
      align-items: start;
      margin-bottom: 16px;
      flex-wrap: wrap;
      gap: 10px;
    }

    .quiz-title {
      color: var(--primary);
      font-size: 1.4rem;
      font-weight: 600;
      margin-bottom: 8px;
    }

    .quiz-description {
      color: var(--muted-foreground);
      line-height: 1.5;
      margin-bottom: 16px;
    }

    .quiz-meta {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 12px;
      margin-bottom: 20px;
    }

    .meta-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 8px 12px;
      background: rgba(144, 252, 253, 0.05);
      border-radius: 8px;
      border: 1px solid var(--border-color);
    }

    .meta-label {
      font-size: 0.85rem;
      color: var(--muted-foreground);
      font-weight: 500;
    }

    .meta-value {
      color: var(--foreground);
      font-weight: 600;
    }

    .quiz-stats {
      display: flex;
      gap: 20px;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }

    .stat-badge {
      background: rgba(246, 231, 82, 0.15);
      color: var(--primary);
      padding: 8px 16px;
      border-radius: 20px;
      font-size: 0.9rem;
      font-weight: 600;
      border: 1px solid rgba(246, 231, 82, 0.3);
    }

    .action-button {
      background: linear-gradient(135deg, var(--primary) 0%, rgba(246, 231, 82, 0.8) 100%);
      color: var(--background);
      border: none;
      padding: 12px 24px;
      border-radius: 25px;
      font-weight: 600;
      font-size: 1rem;
      cursor: pointer;
      transition: all 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      box-shadow: 0 4px 16px rgba(246, 231, 82, 0.3);
      width: 100%;
    }

    .action-button:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(246, 231, 82, 0.4);
      background: var(--primary);
    }

    .action-button:active {
      transform: translateY(0);
    }

    .table-action-button {
      background: var(--primary);
      color: var(--background);
      border: none;
      padding: 8px 16px;
      border-radius: 20px;
      font-weight: 600;
      font-size: 0.9rem;
      cursor: pointer;
      transition: all 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .table-action-button:hover {
      background: var(--muted-foreground);
      transform: scale(1.05);
    }

    .loading {
      text-align: center;
      padding: 60px 20px;
      color: var(--muted-foreground);
      font-size: 1.1rem;
    }

    .loading::after {
      content: '';
      display: inline-block;
      width: 20px;
      height: 20px;
      border: 2px solid var(--muted-foreground);
      border-radius: 50%;
      border-top-color: var(--primary);
      animation: spin 1s linear infinite;
      margin-left: 10px;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }

    .no-results {
      text-align: center;
      padding: 60px 20px;
      color: var(--muted-foreground);
      font-size: 1.1rem;
    }

    @media (max-width: 768px) {
      .header h1 {
        font-size: 2rem;
      }

      .stats-bar {
        gap: 15px;
      }

      .stat-item {
        min-width: 100px;
        padding: 15px;
      }

      .quiz-table-container {
        display: none;
      }

      .quiz-grid {
        display: block;
      }

      .search-filter {
        flex-direction: column;
        align-items: stretch;
      }

      .search-input {
        width: 100%;
      }

      .quiz-meta {
        grid-template-columns: 1fr;
      }

      .quiz-stats {
        flex-direction: column;
        gap: 10px;
      }

      .stat-badge {
        text-align: center;
      }
    }

    @media (max-width: 480px) {
      body {
        padding: 15px;
      }

      .header {
        margin-bottom: 30px;
      }

      .header h1 {
        font-size: 1.8rem;
      }

      .quiz-card {
        padding: 20px;
      }

      th, td {
        padding: 12px 15px;
        font-size: 0.9rem;
      }
    }
  </style>
</head>
<body>
<script src="/app/Views/Navbar.js"></script>
  <div class="container">
    <div class="header">
      <h1>Available Quizzes</h1>
      <p>Challenge yourself and test your knowledge</p>
    </div>

    <div class="stats-bar">
      <div class="stat-item">
        <span class="stat-number" id="total-quizzes">-</span>
        <div class="stat-label">Total Quizzes</div>
      </div>
      <div class="stat-item">
        <span class="stat-number" id="active-quizzes">-</span>
        <div class="stat-label">Active</div>
      </div>
      <div class="stat-item">
        <span class="stat-number" id="avg-score">-</span>
        <div class="stat-label">Avg Score</div>
      </div>
    </div>

    <div class="search-filter">
      <input 
        type="text" 
        class="search-input" 
        placeholder="🔍 Search quizzes..." 
        id="search-input"
      >
      <select class="filter-select" id="domain-filter">
        <option value="">All Domains</option>
      </select>
    </div>

    <div class="quiz-table-container">
      <table id="quiz-table">
        <thead>
          <tr>
            <th>Quiz Name</th>
            <th>Description</th>
            <th>Timeline</th>
            <th>Domain</th>
            <th>High Score</th>
            <th>Top Scorer</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="table-body">
          <tr>
            <td colspan="7" class="loading">Loading quizzes...</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="quiz-grid" id="quiz-grid">
      <div class="loading">Loading quizzes...</div>
    </div>
  </div>

  <script>
    let allQuizzes = [];

    async function fetchQuizzes() {
      try {
        const res = await fetch('https://sparkonics.iitp.ac.in/quiz/getquizzes');
        let quizzes = await res.json();
	quizzes = quizzes.reverse();
	
        allQuizzes = quizzes;
        
        updateStats(quizzes);
        populateDomainFilter(quizzes);
        displayQuizzes(quizzes);
        
      } catch (err) {
        console.error('Error loading quizzes:', err);
        document.getElementById('table-body').innerHTML = 
          '<tr><td colspan="7" class="no-results">Failed to load quizzes. Please try again later.</td></tr>';
        document.getElementById('quiz-grid').innerHTML = 
          '<div class="no-results">Failed to load quizzes. Please try again later.</div>';
      }
    }

    function updateStats(quizzes) {
      const totalQuizzes = quizzes.length;
      const currentTime = new Date();
      const activeQuizzes = quizzes.filter(q => {
        const startTime = new Date(q.QuizStarts);
        const endTime = new Date(q.QuizEnds);
        return currentTime >= startTime && currentTime <= endTime;
      }).length;
      
      const avgScore = quizzes.length > 0 ? 
        Math.round(quizzes.reduce((sum, q) => sum + (parseInt(q.QuizHighScore) || 0), 0) / quizzes.length) : 0;

      document.getElementById('total-quizzes').textContent = totalQuizzes;
      document.getElementById('active-quizzes').textContent = activeQuizzes;
      document.getElementById('avg-score').textContent = avgScore;
    }

    function populateDomainFilter(quizzes) {
      const domains = [...new Set(quizzes.map(q => q.QuizDomain))];
      const filterSelect = document.getElementById('domain-filter');
      
      domains.forEach(domain => {
        if (domain) {
          const option = document.createElement('option');
          option.value = domain;
          option.textContent = domain;
          filterSelect.appendChild(option);
        }
      });
    }

    function displayQuizzes(quizzes) {
      displayTableView(quizzes);
      displayGridView(quizzes);
    }

    function displayTableView(quizzes) {
      const tbody = document.getElementById('table-body');
      
      if (quizzes.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="no-results">No quizzes found matching your criteria.</td></tr>';
        return;
      }

      tbody.innerHTML = '';
      quizzes.forEach(q => {
        const tr = document.createElement('tr');
        const startDate = new Date(q.QuizStarts).toLocaleDateString();
        const endDate = new Date(q.QuizEnds).toLocaleDateString();
        
        tr.innerHTML = `
          <td><strong>${q.QuizName}</strong></td>
          <td>${q.QuizDesc || 'No description available'}</td>
          <td>${startDate} - ${endDate}</td>
          <td><span class="stat-badge">${q.QuizDomain || 'General'}</span></td>
          <td><strong>${q.QuizHighScore || '0'}</strong></td>
          <td>${q.QuizTopScorer || 'No attempts yet'}</td>
          <td>
            <form method="POST" action="/quiz/getquiz" style="display: inline;">
              <input type="hidden" name="QuizId" value="${q.QuizId}">
              <button type="submit" class="table-action-button">Take Quiz</button>
            </form>
          </td>
        `;
        tbody.appendChild(tr);
      });
    }

    function displayGridView(quizzes) {
      const grid = document.getElementById('quiz-grid');
      
      if (quizzes.length === 0) {
        grid.innerHTML = '<div class="no-results">No quizzes found matching your criteria.</div>';
        return;
      }

      grid.innerHTML = '';
      quizzes.forEach(q => {
        const card = document.createElement('div');
        card.className = 'quiz-card';
        
        const startDate = new Date(q.QuizStarts).toLocaleDateString();
        const endDate = new Date(q.QuizEnds).toLocaleDateString();
        const startTime = new Date(q.QuizStarts).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        const endTime = new Date(q.QuizEnds).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        
        card.innerHTML = `
          <div class="quiz-card-header">
            <div>
              <h3 class="quiz-title">${q.QuizName}</h3>
              <p class="quiz-description">${q.QuizDesc || 'No description available'}</p>
            </div>
          </div>
          
          <div class="quiz-meta">
            <div class="meta-item">
              <span class="meta-label">Start Date</span>
              <span class="meta-value">${startDate}</span>
            </div>
            <div class="meta-item">
              <span class="meta-label">End Date</span>
              <span class="meta-value">${endDate}</span>
            </div>
            <div class="meta-item">
              <span class="meta-label">Start Time</span>
              <span class="meta-value">${startTime}</span>
            </div>
            <div class="meta-item">
              <span class="meta-label">End Time</span>
              <span class="meta-value">${endTime}</span>
            </div>
          </div>
          
          <div class="quiz-stats">
            <div class="stat-badge">Domain: ${q.QuizDomain || 'General'}</div>
            <div class="stat-badge">High Score: ${q.QuizHighScore || '0'}</div>
            ${q.QuizTopScorer ? `<div class="stat-badge">Top: ${q.QuizTopScorer}</div>` : ''}
          </div>
          
          <form method="POST" action="/quiz/getquiz">
            <input type="hidden" name="QuizId" value="${q.QuizId}">
            <button type="submit" class="action-button">Take Quiz</button>
          </form>
        `;
        grid.appendChild(card);
      });
    }

    function filterQuizzes() {
      const searchTerm = document.getElementById('search-input').value.toLowerCase();
      const selectedDomain = document.getElementById('domain-filter').value;
      
      const filtered = allQuizzes.filter(quiz => {
        const matchesSearch = quiz.QuizName.toLowerCase().includes(searchTerm) ||
                            (quiz.QuizDesc && quiz.QuizDesc.toLowerCase().includes(searchTerm));
        const matchesDomain = !selectedDomain || quiz.QuizDomain === selectedDomain;
        
        return matchesSearch && matchesDomain;
      });
      
      displayQuizzes(filtered);
    }

    // Event listeners
    document.getElementById('search-input').addEventListener('input', filterQuizzes);
    document.getElementById('domain-filter').addEventListener('change', filterQuizzes);

    // Initialize
    fetchQuizzes();
  </script>
</body>
</html>
