<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
        }
        .certificate {
            border: 10px solid #ddd;
            padding: 20px;
        }
        .name {
            font-size: 24px;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <h1>Certificate of Achievement</h1>
        <p>This certificate is awarded to:</p>
        <p class="name">{{ $name }}</p>
        <p>For outstanding performance and dedication.</p>
    </div>
</body>
</html>
        