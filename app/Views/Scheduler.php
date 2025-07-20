<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Log Reader - Latest Entries</title>
  <?php echo "<style>" . Sowhatnow\App\Views\NavBar::$STYLE . "</style>"; ?>

  <style>
    body {
      font-family: monospace;
      background-color: #282c34;
      color: #f8f8f2;
      padding: 20px;
    }
    pre {
      background-color: #1e1e1e;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      overflow: auto;
      white-space: pre-wrap;
      word-wrap: break-word;
      max-height: 600px;
      max-width: 100%;
    }
    h1 {
      color: #61dafb;
    }
  </style>

</head>
<body>
  <?php echo Sowhatnow\App\Views\NavBar::$NAVBAR; ?>

  <h1>Scheduler </h1>
</body>
</html>
