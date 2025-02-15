  <section class="main-sec">
      <div class="container cont-sm">
          <div class="container-header pb8 flex align-center justify-between">
              <h2>Closing Job</h2>
              <div mx-get="jobs/delete_modal/<?= $job_code ?>" mx-build-modal='{
                        "id":"delete-modal"                      
                    }'>
                  <svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
                      <path fill="none" stroke="#ed8d8d" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m19.5 5.5l-.62 10.025c-.158 2.561-.237 3.842-.88 4.763a4 4 0 0 1-1.2 1.128c-.957.584-2.24.584-4.806.584c-2.57 0-3.855 0-4.814-.585a4 4 0 0 1-1.2-1.13c-.642-.922-.72-2.205-.874-4.77L4.5 5.5M3 5.5h18m-4.944 0l-.683-1.408c-.453-.936-.68-1.403-1.071-1.695a2 2 0 0 0-.275-.172C13.594 2 13.074 2 12.035 2c-1.066 0-1.599 0-2.04.234a2 2 0 0 0-.278.18c-.395.303-.616.788-1.058 1.757L8.053 5.5m1.447 11v-6m5 6v-6" color="#ed8d8d" />
                  </svg>
              </div>
          </div>

          <?php
            echo validation_errors();
            echo form_open($loc);

            echo form_label('Time Out', array('class' => 'accent'));
            echo '<input type="time" name="time_out" value="' . $time_out . '" required>';

            echo '<div class="form-btns">';
            echo form_submit('submit', 'Submit', array('class' => 'btn-primary-45'));
            echo '<a class="button btn-secondary" href="' . $cancel . '">Cancel</a>';
            echo '</div>';
            echo form_close();
            ?>


          <div class="mt-2 text-lg">
              <a href="service_tickets/index/<?= $job_code ?>" class="text-primary flex p8 ">Create A Service Ticket?</a>
          </div>
          <div class="mt-2 text-lg">
              <a href="service_tickets/ticket_two/<?= $job_code ?>" class="text-primary flex p8 ">Create A Service Ticket? --V2</a>
          </div>
      </div>

  </section>