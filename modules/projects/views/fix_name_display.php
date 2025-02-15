<section class="main-sec">
    <div class="container cont-sm">
        <div class="container-header pb8 flex align-center justify-between">
            <div>
                <h2><?= $heading ?></h2>
               
            </div>
        </div>
        <?php
        echo validation_errors(); ?>
        <form id="myForm" action="projects/submit_fix_name" method="post"  class="mb-16">
            <?php
            echo '<h4>Updating "'.$old_job_name.'"</h4>';

            echo form_hidden('old_job_name', $old_job_name);
            echo form_label('New Name', array('class' => 'accent'));
            $attributes['required'] = 'required';
            echo form_input('new_job_name', $new_job_name, $attributes);
         

            echo '<div class="form-btns">';
            echo form_submit('submit', 'Submit', array('class' => ''));
            echo '<a class="button btn-secondary" href="' . $cancel . '">Cancel</a>';
            echo '</div>';
            echo form_close();
            ?>
            <div id="result"></div>
    </div> 

</section>
