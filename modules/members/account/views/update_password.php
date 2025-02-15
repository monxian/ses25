<section class="main-sec">
    <div class="container cont-sm">
        <div class="container-header pb8 flex align-center justify-between">
            <div>
                <h2>Update Your Password</h2>
                <p>Your password must be at least five characters long with at least one one number</p>

            </div>
        </div>
        <div>
            <div>
                <?php
                echo validation_errors();
                $form_attr['class'] = 'narrow-form';
                echo form_open($form_location, $form_attr);
                echo form_label('New Password');
                echo form_password('password', '', array("placeholder" => "Enter Your New Password Here"));
                echo form_label('Repeat New Password');
                echo form_password('password_repeat', '', array("placeholder" => "Repeat Your New Password Here"));

                echo '<div class="form-btns">';
                echo form_submit('submit', 'Submit', array('class' => ''));
                echo anchor('members-account/your_account', 'Cancel', array('class' => 'button btn-secondary'));
                
                echo form_close();
                ?>
            </div>
        </div>
    </div>
</section>