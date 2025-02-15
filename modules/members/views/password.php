<h1><?= $headline ?></h1>
<?= validation_errors() ?>
<div class="card">
    <div class="card-heading">
        <?= $name ?>
    </div>
    <div class="card-body">
        <?php
        echo form_open($form_location);  
        echo validation_errors();  
        echo form_label('Password');
        echo form_password('password', $password, array("placeholder" => "Min length 5 characters"));
      
        echo form_submit('submit', 'Submit');
        echo anchor($cancel_url, 'Cancel', array('class' => 'button alt'));
        echo form_close();
        ?>
    </div>
</div>