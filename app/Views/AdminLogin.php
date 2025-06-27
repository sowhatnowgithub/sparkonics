<!-- view/AdminLogin -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AdminLogin</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
      <form method="POST" action="admin/auth">
          <input type="text" name="username"/>
          <input type="text" name="password"/>
          <input type="submit">
      </form>
  </body>
</html>
