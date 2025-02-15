<section class="main-sec">
    <div class="container cont-sm">
        <div class="container-header pb8 flex align-center justify-between">
            <div>
                <p><?= flashdata() ?></p>
                <h2><?= $heading ?></h2>
                <p>Password must be at least five characters long with at least one one number</p>
            </div>
        </div>
        <div>
            <div>
                <?php
                echo validation_errors();
                echo form_open($loc);

                echo form_label('New Password');
                echo form_password('password', '');


                echo '<div class="form-btns">';
                echo form_submit('submit', 'Submit');
                echo anchor('members-memberdb', 'Cancel', array('class' => 'button btn-secondary'));

                echo form_close();
                ?>
            </div>
        </div>
    </div>
</section>