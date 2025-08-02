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
      background-color: black;
      color: white;
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
      color: white;
    }
  </style>

</head>
<body>
  <?php echo Sowhatnow\App\Views\NavBar::$NAVBAR; ?>

  <h1>Latest Log Entries - user.log</h1>

  <?php
  $logFilePath = Sowhatnow\Env::BASE_PATH . "/app/Views/logs/user.log";

  $linesToShow = 20;

  if (file_exists($logFilePath)) {
      $file = new SplFileObject($logFilePath);
      $file->seek(PHP_INT_MAX); // Move to the end of the file
      $lines = [];

      // Read the latest lines from the end of the file
      for ($i = 0; $i < $linesToShow; $i++) {
          if ($file->key() === 0) {
              break;
          }
          $file->seek($file->key() - 1);
          $lines[] = $file->current();
      }

      // Reverse the lines to display from bottom to top
      $lines = array_reverse($lines);

      // Display the lines inside a preformatted text block (terminal-like)
      echo "<pre>" . htmlspecialchars(implode("\n", $lines)) . "</pre>";
  } else {
      echo "<p style='color: darkblue;'>Error: user.log file not found.</p>";
  }
  ?>

</body>
</html>
