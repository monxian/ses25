<h1><?= $headline ?></h1>
<?= validation_errors() ?>
<div class="card">
    <div class="card-heading">
        Maker Details
    </div>
    <div class="card-body">
        <?php
        echo form_open($form_location);
        echo form_label('maker name');
        echo form_input('maker_name', $maker_name, array("placeholder" => "Enter maker name"));
        echo form_label('support number <span>(optional)</span>');
        echo form_input('support_number', $support_number, array("placeholder" => "Enter support number"));
        echo form_label('notes <span>(optional)</span>');
        echo form_textarea('notes', $notes, array("placeholder" => "Enter notes"));
        echo form_submit('submit', 'Submit');
        echo anchor($cancel_url, 'Cancel', array('class' => 'button alt'));
        echo form_close();
        ?>
    </div>
</div>