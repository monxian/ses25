<?php
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="<?= BASE_URL ?>">
    <title>SesPortal</title>
    <style>
        body {
            font-size: 2em;
            background: #ff0000;
            color: #ddd;
            text-align: center;
            font-family: "Lucida Console", Monaco, monospace;
        }

        h1 {
            margin-top: 2em;
        }

        h1, h2 {
            text-transform: uppercase;
        }

        a {
            color: white;
        }
    </style>
</head>
<body>
    <h1>404 Error : Page Not Found</h1>   
</body>
</html>