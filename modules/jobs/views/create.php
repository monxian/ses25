<h1><?= $headline ?></h1>
<?= validation_errors() ?>
<div class="card">
    <div class="card-heading">
        Job Details
    </div>
    <div class="card-body">
        <?php
        echo form_open($form_location);
        echo form_label('job date');
        echo form_input('job_date', $job_date, array("placeholder" => "Enter job date"));
        echo form_label('job name');
        echo form_input('job_name', $job_name, array("placeholder" => "Enter job name"));
        echo form_label('time in');
        echo form_input('time_in', $time_in, array("placeholder" => "Enter time in"));
        echo form_label('time out <span>(optional)</span>');
        echo form_input('time_out', $time_out, array("placeholder" => "Enter time out"));
        echo form_label('job hours <span>(optional)</span>');
        echo form_input('job_hours', $job_hours, array("placeholder" => "Enter job hours"));
        echo form_label('Member ID');
        echo form_number('member_id', $member_id, array("placeholder" => "Enter Member ID"));
        echo form_label('cost code');
        echo form_number('cost_code', $cost_code, array("placeholder" => "Enter cost code"));
        echo form_label('job code <span>(optional)</span>');
        echo form_input('job_code', $job_code, array("placeholder" => "Enter job code"));
        echo form_label('project id <span>(optional)</span>');
        echo form_number('project_id', $project_id, array("placeholder" => "Enter project id"));
        echo form_submit('submit', 'Submit');
        echo anchor($cancel_url, 'Cancel', array('class' => 'button alt'));
        echo form_close();
        ?>
    </div>
</div>