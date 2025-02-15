  <section class="main-sec">
      <div class="container cont-sm">
          <div class="container-header pb8 flex align-center justify-between">
              <div>
                  <h2><?= $headline ?></h2>
              </div>
              <?php
                if ($deletable) { ?>
                  <div>
                      <a href="products/delete/<?= $id ?>" class="text-danger">
                          <svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
                              <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m19.5 5.5l-.62 10.025c-.158 2.561-.237 3.842-.88 4.763a4 4 0 0 1-1.2 1.128c-.957.584-2.24.584-4.806.584c-2.57 0-3.855 0-4.814-.585a4 4 0 0 1-1.2-1.13c-.642-.922-.72-2.205-.874-4.77L4.5 5.5M3 5.5h18m-4.944 0l-.683-1.408c-.453-.936-.68-1.403-1.071-1.695a2 2 0 0 0-.275-.172C13.594 2 13.074 2 12.035 2c-1.066 0-1.599 0-2.04.234a2 2 0 0 0-.278.18c-.395.303-.616.788-1.058 1.757L8.053 5.5m1.447 11v-6m5 6v-6" color="currentColor" />
                          </svg>
                      </a>
                  </div>
              <?php } ?>
          </div>
          <?php
            echo validation_errors();
            echo form_open($loc);

            echo form_label('Name', array('class' => 'accent'));
            $attributes['required'] = 'required';
            echo form_input('name', $name, $attributes);

            echo form_label('Part Number', array('class' => 'accent'));
            $attributes['required'] = 'required';
            echo form_input('part_number', $part_number, $attributes);

            echo form_label('Description <span class="text-success">(optional)</span>');
            echo form_textarea('description', $description, array("placeholder" => "Enter Description or Notes", "rows" => "10"));

            echo '<div class="flex flex-inline align-center">';
            echo form_label('Truck Stock', array('class' => 'accent'));
            echo form_checkbox('truck_stock', 1 , $truck_stock , array('class' => 'flex ml16 mt16'));
            echo '</div>';
            echo '<p class="xsmall-text text-secondary">(should this be on tech\'s trucks)</p>';


            echo form_label('Qty', array('class' => 'accent'));
            $attributes['required'] = 'required';
            echo form_input('qty', $qty, $attributes);

            echo form_label('Price <span class="text-success">(optional)</span>', array('class' => 'accent'));
            echo form_input('price', $price);

            echo $categories;
            echo $makers;


            echo form_label('shelf location <span class="text-success">(optional)</span>', array('class' => 'accent'));
            echo form_input('shelf_location', $shelf_location);

            echo '<div class="form-btns">';
            echo form_submit('submit', 'Submit', array('class' => ''));
            echo '<a class="button btn-secondary" href="' . $cancel_url . '">Cancel</a>';
            echo '</div>';
            echo form_close();
            ?>
      </div>
  </section>