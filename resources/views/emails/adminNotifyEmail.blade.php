<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New User Registration - Paradise</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: rgb(25, 0, 255);
        }

        .email-body {
            margin-top: 20px;
            font-size: 16px;
            color: #333;
        }

        .email-footer {
            margin-top: 30px;
            font-size: 14px;
            color: #888;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .highlight {
            font-weight: bold;
            color: rgb(4, 0, 255);
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">New User Registration</div>

        <div class="email-body">
            <p>Hello Admin <span class="highlight">{{ $data['name'] }}</span>,</p>
            <p>A new user has just registered. Here are the details:</p>
            <p><strong>Reference Number:</strong> {{ $data['reference'] }}</p>
        </div>

        <div class="email-footer">
            <p>Thank you for managing Paradise.</p>
            <p>Need assistance? <a href="mailto:support@paradise.com">Contact Support</a></p>
        </div>
    </div>
</body>

</html>