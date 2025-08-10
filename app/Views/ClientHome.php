<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Home Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    :root {
      --background: rgb(1, 6, 15);
      --foreground: rgb(144, 252, 253);
      --primary: rgb(246, 231, 82);
      --muted-foreground: rgba(246, 231, 82, 0.6);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      background-color: black;
      color: var(--foreground);
      line-height: 1.6;
      background: url("/images/logo.png") no-repeat center center fixed;
      background-size: cover;
      backdrop-filter: blur(5px);
    }


    /* Banner */
    .banner {
      position: relative;
      padding: 80px 20px;
      text-align: center;
      background-size: cover;
      background-position: center;
    }

    .banner h1 {
      font-size: 3em;
      color: var(--primary);
    }

    /* Panel Section */
    .panel {
      padding: 40px 20px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .box {
      background-color: rgba(0, 0, 0,0.5);
      border: 1px solid var(--muted-foreground);
      padding: 20px;
      border-radius: 10px;
      transition: transform 0.2s ease;
    }

    .box:hover {
      transform: translateY(-5px);
    }

    .box h2 {
      color: var(--primary);
      margin-bottom: 10px;
    }

    .box p {
      color: var(--foreground);
      margin-bottom: 15px;
    }

    .box a {
      color: var(--foreground);
      text-decoration: underline;
    }

    .box a:hover {
      color: var(--primary);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {

      .banner h1 {
        font-size: 2em;
      }
    }

    @media (max-width: 480px) {
      .box {
        padding: 15px;
      }

      .banner {
        padding: 60px 15px;
      }

      .banner h1 {
        font-size: 1.7em;
      }
    }
  </style>
</head>
<body>

  <!-- Navbar -->

<script src="/app/Views/Navbar.js"></script>
  <!-- Banner Section -->
  <div class="banner">
    <h1>Welcome to the Home Page</h1>
  </div>

  <!-- Panel Section -->
  <section class="panel">
    <div class="box">
      <h2>Live Quizzes</h2>
      <p>This is the place where you can competitively solve questions and climb the leaderboard.</p>
      <a href="/quiz/home">Go to Link</a>
    </div>

    <div class="box">
      <h2>Thrds</h2>
      <p>A place where you can ask questions, doubts, and queries.</p>
      <a href="/thrds">Go to Link</a>
    </div>

    <!-- Add more boxes as needed -->
  </section>

</body>
</html>

