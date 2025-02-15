  <section class="main-sec">
      <div class="container cont-sm">
          <div class="container-header pb8 flex align-center justify-between">
              <div>
                  <h2>New <?= ucfirst($heading) ?></h2>
              </div>

          </div>
          <?php
            echo validation_errors();
            echo form_open($loc);

            if ($heading != 'makers') {
                echo form_label('Category Name', array('class' => 'accent'));
                $attributes['required'] = 'true';
                echo form_input('category_name', $category_name, $attributes);
            } else {
                echo form_label('Maker Name', array('class' => 'accent'));
                $attributes['required'] = '';
                echo form_input('maker_name', $maker_name, $attributes);

                echo form_label('Support Number (optional)', array('class' => 'accent'));              
                echo form_input('Support Number', $support_number);
            }

            echo '<div class="form-btns">';
            echo form_submit('submit', 'Submit', array('class' => ''));
            echo '<a class="button btn-secondary" href="' . $cancel . '">Cancel</a>';
            echo '</div>';
            echo form_close();
            ?>
      </div>
  </section>