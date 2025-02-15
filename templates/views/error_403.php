<?php
http_response_code(403);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesportal</title>
</head>

<body>
    <div class="content">
        <h1>403 Forbidden</h1>
        <div>
            <a href="<?= BASE_URL ?>" class="btn">< &nbsp;Home</a>
        </div>
    </div>
    <style>
        body {
            width: 100svw;
            height: 100svh;
            background: url('<?= BASE_URL ?>imgs/coming_soon_opz.jpg') center no-repeat;
            background-size: cover;
            color: white;
        }

        .content {
            width: 100%;
            padding-top: 3em;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .btn {
            background: hsl(0, 0%, 50%, .5);
            color: white;
            padding: .5em 1em;
            border-radius: .5em;
            text-decoration: none;
        }
    </style>
</body>

</html>