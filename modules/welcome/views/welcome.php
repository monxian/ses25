<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SesPortal-Welcome</title>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <img src="<?= BASE_URL ?>imgs/ses-logo.svg" alt="company logo">
            <div>
                <h1>SesPortal</h1>
            </div>
        </div>
        <div>
            <?= flashdata() ?>
        </div>

        <div class="login-form">
            <?php
            echo form_open('members-account/submit_login');
            echo '<div class="form-body">';
            validation_errors();
            echo form_label('Username or Email Address');
            echo form_input('username', '', array('autocomplete' => 'off'));

            echo form_label('Password');
            echo form_password('password', '');

            echo '<div class="remember">';
            echo '<div>Remember me:</div>';
            echo form_checkbox('remember', 1, $remember);
            echo '</div>';

            echo form_submit('submit', 'Login');
            echo '</div>';
            ?>

        </div>
        <?php
        echo form_close();
        ?>
    </div>

    
    <style>
        @import url('welcome_module/css/custom.css');
    </style>
</body>

</html>