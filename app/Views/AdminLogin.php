<!-- view/AdminLogin -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AdminLogin</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        padding: 20px;
        background-color: #f5f5f5;
      }
      form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        max-width: 500px;
        margin: auto;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }
      label {
        display: block;
        margin: 15px 0 5px;
        font-weight: bold;
      }
      input[type="text"],
      input[type="datetime-local"],
      input[type="url"],
      textarea {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
      }
      input[type="submit"] {
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
      }
    </style>
  </head>
  <body>
      <form method="POST" action="/admin/auth">
          <input type="text" name="username" placeholder="sowhatnow@iitp.ac.in"/>
          <input type="text" name="password" placeholder="password"/>
          <input type="submit">
      </form>
  </body>
</html>
