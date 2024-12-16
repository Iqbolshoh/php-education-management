<?php http_response_code(404) ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            background-color: #fff;
        }

        .error-message {
            background-color: #ff6b81;
            padding: 40px 60px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
            color: white;
        }

        .error-message h1 {
            font-size: 72px;
            margin: 0;
        }

        .error-message p {
            font-size: 24px;
            margin: 20px 0;
        }

        .error-message a {
            text-decoration: none;
            color: #fff;
            background-color: #6c5ce7;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .error-message a:hover {
            background-color: #5a4bb1;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="error-message">
            <h1>404</h1>
            <p>Oops! The page you're looking for cannot be found.</p>
            <a href="index.php">Back to Homepage</a>
        </div>
    </div>
</body>

</html>