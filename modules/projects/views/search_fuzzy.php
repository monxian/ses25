<section class="main-sec flex align-start gap-1">
    <div class="container cont-sm">
        <div class="container-header pb8 flex align-center justify-between js-flex">
            <div>
                <h2><?= $heading ?></h2>
                <p class="small-text text-secondary">See hours on the job, search by job name.</p>
                <p><?= flashdata()?> </p>
            </div>
        </div>
        <?php
        echo validation_errors(); ?>
        <form id="myForm" mx-post="projects/submit_search" mx-target="#result" class="mb-16">
            <?php

            echo form_label('Job Name', array('class' => 'accent'));
            $attributes['required'] = 'required';
            echo form_input('job_name', $job_name, $attributes);

            echo form_label('Starting Date', array('class' => 'accent'));
            echo '<input type="date" name="start_date" value="' . $start_date . '" required>';

            echo form_label('Ending Date', array('class' => 'accent'));
            echo '<input type="date" name="end_date" value="' . $end_date . '" required>';        

            echo '<div class="form-btns">';
            echo form_submit('submit', 'Search', array('class' => ''));
            echo '</div>';
            echo form_close();
            ?>
         
    </div>
    <div class="container flex flex-col w-500 ja-flex">
      
    <div id="result"></div>
        <div id="job-analysis">

        </div>
    </div>
 

</section>
<style>
    .js-flex{
        flex: 0 1;
    }
    .input-container {
        position: relative;
    }

    .input-container input[type="text"] {
        width: 100%;
        padding-right: 50px;
        box-sizing: border-box;
        height: 46px;
    }

    .input-container button {
        position: absolute;
        right: 2px;
        top: 2px;
        bottom: 0;
        border: none;
        background: var(--color-primary-45);
        color: white;
        padding: 0 10px;
        cursor: pointer;
        border-radius: 0 .5em .5em 0;
        height: 42px;
        /* Match input border radius */
    }

    .input-container button:hover {
        background: var(--color-primary-35);
    }
</style>


<script>
    function closeBtn(){
        const fixNameDiv = document.querySelector('.fix-names-sec');
        fixNameDiv.style.display = "none";
    }  
    function openBtn(){
        const fixNameDiv = document.querySelector('.fix-names-sec');
        fixNameDiv.style.display = "block";
    }
</script>