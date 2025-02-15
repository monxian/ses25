<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .header {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">Hi Natalie,</div>
        <p>
            A parts request has been submitted by <?= $target_name ?>.
        </p>
        <p>
            Please visit <a href="https://sesportal.us" target="_blank">SesPortal</a> and click on
            the "Parts Request" link to view details.
        </p>
        <div class="footer">
            <p>
                This email was auto-generated in response to a request made by <?= $target_name ?>.
            </p>
            <p>Thank you.</p>
        </div>
    </div>

</body>

</html>