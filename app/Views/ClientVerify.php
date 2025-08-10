<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Verification Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .emailmessage {
            background-color: #e0f7fa;
            color: #00796b;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 10px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 15px;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #00796b;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:disabled {
            background-color: #b2dfdb;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="emailmessage">
        We have sent a verification code to your email address.<br>
        Please enter the code below to verify your account.
    </div>

    <!-- Form to input verification code -->
    <form action="/client/register" method="POST">
        <input type="text" name="verification_code" placeholder="Enter your 6-digit code"  required>
        <br>
        <button type="submit">Verify</button>
    </form>
</div>

</body>
</html>


