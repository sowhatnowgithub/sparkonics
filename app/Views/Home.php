<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Website Control</title>
<?php echo "<style>" . Sowhatnow\App\Views\NavBar::$STYLE . "</style>"; ?>
</head>
<body>

    <?php echo Sowhatnow\App\Views\NavBar::$NAVBAR; ?>
    <!-- Content Area (Placeholder for now) -->
     <div class="content" id="content-area">
       <h2>Welcome to the Website Control Portal!</h2>
       <p>Select a section from the navbar above to navigate.</p>
     </div>

</body>
</html>
