  <section class="main-sec">
      <div class="container cont-sm">
          <div class="container-header pb8">
              <div>
                  <h2>Add Comment For</h2>
                  <h2 class="text-primary"><?= $job_name ?></h2>
              </div>
              <div class=" alert-success round-sm p8 mt8 med-text max-content" id="flash-msg"> Please leave a comment.</div>
              </div>
              <?php
                echo validation_errors();
                echo form_open($loc);

                echo form_label('Summary (for easy searches)', array('class' => 'accent'));
                echo '<input type="text" name="summary" value="' . $summary . '" required>';

                echo form_label('Comment', array('class' => 'accent'));
                $attributes['required'] = 'required';
                echo form_textarea('comment', '', $attributes);

                echo form_hidden('sent_from', 'close');

                echo '<div class="form-btns">';
                echo form_submit('submit', 'Submit', array('class' => ''));
                echo '<a class="button btn-secondary" href="truck_inventories/show/close">Skip</a>';
                
                echo '</div>';
                echo form_close();
                ?>
          </div>
  </section>