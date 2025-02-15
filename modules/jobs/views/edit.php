  <section class="main-sec">
      <div class="container cont-sm">
          <div class="container-header pb8 flex align-center justify-between">
              <div>
                  <h2><?= $heading ?></h2>                 
              </div>
              <?php if ($non_job_entry) { ?>
                  <div class="text-primary" mx-get="jobs/holiday_modal/<?= $job_date ?>/<?= $job_code?>"
                      mx-build-modal='{
                        "id":"holiday-modal"                      
                     }'>
                      <svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
                          <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.513 16h4m-4-5h8m-4.5 11h1M7.51 22c-1.15-.025-1.924 0-2.923-.225c-1.05-.275-1.7-.925-1.924-2.225c-.225-.85-.153-4.626-.15-8.225c.002-2.793.02-5.326.25-5.85c.325-1.125 1.074-1.925 3.398-1.95m9.868 0c.8.075 2.89 0 3.298 2.3c.222 1.25.175 3.025.175 5.15M8.184 5.5c1.05.025 4.422 0 5.572 0c1.149 0 1.756-.946 1.749-1.825c-.008-.896-.8-1.595-1.575-1.675H8.16c-.925.05-1.55.8-1.65 1.55c-.1 1.025.65 1.9 1.674 1.95m10.094 8.875c-1.375 1.4-4.023 3.9-4.023 4.075c-.213.297-.4.9-.525 1.75c-.156.788-.344 1.475-.124 1.675s1.047.032 1.923-.15c.7-.075 1.35-.325 1.674-.575c.475-.42 3.698-3.675 4.073-4.1c.274-.375.3-1.075.06-1.5c-.135-.3-.985-1.1-1.26-1.325a1.52 1.52 0 0 0-1.799.15" color="currentColor" />
                      </svg>
                  </div>
              <?php
                }
                if ($deletable) { ?>
                  <div mx-get="jobs/delete_modal/<?= $job_code ?>"
                      mx-build-modal='{
                        "id":"delete-modal"                      
                     }'>
                      <svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
                          <path fill="none" stroke="#ed8d8d" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m19.5 5.5l-.62 10.025c-.158 2.561-.237 3.842-.88 4.763a4 4 0 0 1-1.2 1.128c-.957.584-2.24.584-4.806.584c-2.57 0-3.855 0-4.814-.585a4 4 0 0 1-1.2-1.13c-.642-.922-.72-2.205-.874-4.77L4.5 5.5M3 5.5h18m-4.944 0l-.683-1.408c-.453-.936-.68-1.403-1.071-1.695a2 2 0 0 0-.275-.172C13.594 2 13.074 2 12.035 2c-1.066 0-1.599 0-2.04.234a2 2 0 0 0-.278.18c-.395.303-.616.788-1.058 1.757L8.053 5.5m1.447 11v-6m5 6v-6" color="#ed8d8d" />
                      </svg>
                  </div>
              <?php } ?>
          </div>
          <?php
            if ($non_job_entry) { ?>
                <div><h4><?= $job_name ?></h4></div>
          <?php
            } else {

                echo validation_errors();
                echo form_open($loc);

                echo form_label('Date', array('class' => 'accent'));
                echo '<input type="date" name="job_date" value="' . out($job_date) . '" required>';

                echo form_label('Job Name', array('class' => 'accent'));
                $attributes['required'] = 'required';
                echo form_input('job_name', html_entity_decode($job_name, ENT_QUOTES, 'UTF-8'), $attributes);

                echo form_label('Time In', array('class' => 'accent'));
                echo '<input type="time" name="time_in" value="' . out($time_in) . '" required>';

                echo form_label('Time Out', array('class' => 'accent'));
                echo '<input type="time" name="time_out" value="' . out($time_out) . '" required>';

                echo $codes;

                echo $projects;

                echo '<div class="form-btns">';
                echo form_submit('submit', 'Submit', array('class' => ''));
                echo '<a class="button btn-secondary" href="' . $cancel . '">Cancel</a>';
                echo '</div>';
                echo form_close();
            }
            ?>
      </div>
  </section>
  <style>
      /* Link to the test/assets/css/custom.css */
      @import url('<?= BASE_URL ?>test_module/css/custom.css');
  </style>

  <!-- Link to the assets/js/custom.js -->
  <script src="<?= BASE_URL ?>test_module/js/custom.js"></script>