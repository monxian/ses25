 <section class="main-sec">
     <div class="container cont-sm">
         <div class="container-header pb8">
             <h2>Pick a Week </h2>
             <p class="small-text text-secondary"><i>This will take the preceding two weeks from date picked.</i></p>
         </div>
         <div>
             <?php
                echo validation_errors();
                echo form_open($loc);

                echo form_label('Date');
                echo '<input type="date" name="picked_date" value="' . $picked_date . '" required>';

                echo '<div class="form-btns">';
                echo form_submit('submit', 'Submit', array('class' => ''));
                echo '<a class="button btn-secondary" href="' . $cancel . '">Cancel</a>';
                echo '</div>';
            

                echo form_close();
                ?>
         </div>
     </div>
 </section>

 <style>
     /* Link to the products/assets/css/custom.css */
     @import url('<?= BASE_URL ?>products_module/css/custom.css');
 </style>