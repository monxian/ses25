<section class="main-sec">
    <div class="container cont-sm">
        <div class="container-header pb8">
            <div>
                <h2>Add New Member</h2>
            </div>
        </div>
        <?php
        validation_errors();      
        echo form_open($loc);

        echo form_label('Username');      
        echo form_input('username', $username);

        echo form_label('First Name');       
        echo form_input('first_name', $first_name);

        echo form_label('Last Name');       
        echo form_input('last_name', $last_name);

        echo form_label('Email Address');      
        echo form_email('email_address', $email_address);

        echo form_label('Activate or Disable');
        $name = 'confirmed';
        $options = ['1' => 'Activate', '0' => 'Disable',];
        echo form_dropdown($name, $options);

        echo '<div class="form-btns">';
        echo form_submit('submit', 'Submit', array('class' => ''));
        echo anchor('members-memberdb', 'Cancel', array('class' => 'button btn-secondary'));

        echo '</div>';

        echo form_close();
        ?>
    </div>
</section>