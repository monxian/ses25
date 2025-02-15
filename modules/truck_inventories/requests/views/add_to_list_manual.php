  <section class="main-sec">
      <div class="container cont-sm">
          <div class="container-header pb8 flex align-center justify-between">
              <div>
                  <h2>Add Item</h2>
                  <p class="sm-text">Here you can request an item not found in the database.</p>
              </div>
             
          </div>
          <?php
            echo validation_errors();
            echo form_open($loc);         

            echo form_label('Part Name', array('class' => 'accent'));
            $attributes['required'] = 'required';
            echo form_input('part_name', $part_name, $attributes);

            echo form_label('Part Number (optional)', array('class' => 'accent'));
            $attributes['required'] = 'required';
            echo form_input('part_num', $part_num, $attributes);

            echo form_label('Qty', array('class' => 'accent',));
            echo '<input type="number" name="part_qty" value="' . $part_qty . '" min="1" required>';

            echo '<div class="form-btns">';
            echo form_submit('submit', 'Submit', array('class' => ''));
            echo '<a class="button btn-secondary" href="' . $cancel . '">Cancel</a>';
            echo '</div>';
            echo form_close();
            ?>
      </div>
  </section>