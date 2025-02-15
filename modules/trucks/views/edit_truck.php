<section class="main-sec">
    <div class="container w-320">
        <div class="container-header pb8">
            <div class="flex align-center justify-between">
                <div>
                    <h2><?= $heading ?></h2>
                </div>
            </div>
        </div>
        <div>
            <?php
            echo validation_errors();
            echo form_open($loc);

            echo form_label('Make', array('class' => 'accent'));
            echo '<input type="text" name="make" value="' . $make . '" required>';

            echo form_label('Plate Number', array('class' => 'accent'));
            echo '<input type="text" name="plate_number" value="' . $plate_number . '" required>';

            echo form_label('VIN', array('class' => 'accent'));
            echo '<input type="text" name="vin" value="' . $vin . '" required >';

            echo '<div class="form-btns">';
            echo form_submit('submit', 'Submit', array('class' => 'btn-primary-45'));
            echo '<a class="button btn-secondary" href="' . $cancel . '">Cancel</a>';
            echo '</div>';
            echo form_close();
            ?>
        </div>
    </div>  
</section>