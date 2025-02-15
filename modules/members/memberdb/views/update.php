<section class="main-sec">
    <div class="container cont-sm">
        <div class="container-header pb8 flex align-center justify-between">
            <div>
                <h2>Update Member Details</h2>
            </div>
        </div>
        <div>
            <div>
                <?php
                validation_errors();
                $form_attr['class'] = 'narrow-form';
                echo form_open($loc, $form_attr);

                echo form_label('Username');
                $attr['placeholder'] = 'Enter your username or email address here';
                echo form_input('username', $username, $attr);

                echo form_label('First Name');
                $attr['placeholder'] = 'Enter your first name here';
                echo form_input('first_name', $first_name, $attr);

                echo form_label('Last Name');
                $attr['placeholder'] = 'Enter your last name here';
                echo form_input('last_name', $last_name, $attr);

                echo form_label('Email Address');
                $attr['placeholder'] = 'Enter your email address here';
                echo form_email('email_address', $email_address, $attr);

                $current_status = $confirmed == 1 ? '<span class="text-success">currently Active</span>' : '<span class="text-danger">currently Disabled</span>';
                echo form_label('Activate or Disable: '.$current_status);
                $name = 'confirmed';
                $selected_key = $confirmed;
                                      
                $options = ['1'=> 'Activate', '0' => 'Disable'];
                echo form_dropdown($name, $options, $selected_key);

                echo '<div class="form-btns">';
                echo form_submit('submit', 'Submit', array('class' => ''));
                echo anchor('members-memberdb', 'Cancel', array('class' => 'button btn-secondary'));

                echo '</div>';

                echo form_close();
                ?>
            </div>
        </div>
    </div>
</section>