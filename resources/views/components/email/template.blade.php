<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['subject'] }}</title>
    <style>
        /* Reset styles */
        body, h1, p {
            margin: 0;
            padding: 0;
        }
        /* Set background color and font styles */
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        /* Container styles */
        .container {
            max-width: 600px;
            margin: 20px auto; /* Added margin for spacing */
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        /* Header styles */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #333333;
        }
        /* Content styles */
        .content {
            margin-bottom: 20px;
        }
        /* Footer styles */
        .footer {
            text-align: center;
            color: #666666;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>{{ $data['company_name'] }}</h1>
    </div>
    <div class="content">
        <p style="margin-bottom: 15px">Hello, {{ $data['user']->first_name }} {{ $data['user']->last_name }}!</p>
        <p style="margin-bottom: 15px">{!! $data['message'] !!}</p>
        <p style="margin-bottom: 15px">Regards,<br>{{ $data['company_name'] }}</p>
    </div>
    <div class="footer">
        <p>Copyright &copy; 2024 {{ $data['company_name'] }} All rights reserved.</p>
    </div>
</div>
</body>
</html>
