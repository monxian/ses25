  <section class="main-sec">
      <div class="container cont-sm">
          <div class="container-header pb8 flex align-center justify-between">
              <div>
                  <h2>Adding a Job</h2>                      
              </div>
              <div class="text-primary" mx-get="jobs/holiday_modal/<?= $job_date ?>"
                  mx-build-modal='{
                        "id":"holiday-modal"                      
                     }'>
                  <svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
                      <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                          <path d="m17.777 13.65l.792 1.597a.98.98 0 0 0 .64.476l1.435.24c.918.155 1.134.826.472 1.489L20 18.577a.99.99 0 0 0-.234.82l.32 1.394c.252 1.102-.329 1.529-1.296.952l-1.345-.803c-.244-.145-.644-.145-.891 0l-1.346.803c-.963.577-1.548.146-1.296-.952l.32-1.393a.99.99 0 0 0-.234-.821l-1.116-1.125c-.657-.663-.445-1.334.472-1.488l1.436-.24a.98.98 0 0 0 .634-.477l.792-1.597c.432-.867 1.134-.867 1.561 0M18 2v2M6 2v2" />
                          <path d="M21.5 11.5c-.004-3.866-.073-5.872-1.252-7.146C18.996 3 16.98 3 12.95 3h-1.9C7.02 3 5.004 3 3.752 4.354C2.5 5.707 2.5 7.886 2.5 12.244v.513c0 4.357 0 6.536 1.252 7.89c1.194 1.29 3.081 1.35 6.748 1.353M3 8h18" />
                      </g>
                  </svg>
              </div>
          </div>
          <?php
            echo validation_errors();
            echo form_open($loc);

            echo form_label('Date', array('class' => 'accent'));
            echo '<input type="date" name="job_date" value="' . $job_date . '" required>';

            echo form_label('Job Name', array('class' => 'accent'));
            $attributes['required'] = 'required';
            echo form_input('job_name', $job_name, $attributes);

            echo form_label('Time In', array('class' => 'accent'));           
            echo '<input type="time" name="time_in" value="' . $time_in . '" required>';

            echo $codes;        

            echo '<div class="form-btns">';
            echo form_submit('submit', 'Submit', array('class' => ''));
            echo '<a class="button btn-secondary" href="' . $cancel . '">Cancel</a>';
            echo '</div>';
            echo form_close();
            ?>
      </div>
  </section>