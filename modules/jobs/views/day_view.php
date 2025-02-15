 <section class="main-sec">
     <div class="container cont-sm">
         <div class="container-header pb8 flex align-center justify-between">
             <div>
                 <h3><?= out($day) ?></h3>
                 <div class="small-text"><?= out($date) ?></div>
             </div>
             <div>
                 <a href="jobs/add/<?= out($date_pass) ?>" class="text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
                         <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v8m4-4H8m14 0c0-5.523-4.477-10-10-10S2 6.477 2 12s4.477 10 10 10s10-4.477 10-10" color="currentColor" />
                     </svg>
                 </a>              
             </div>
         </div>
         <div><?= flashdata('', '', true) ?></div>
         <div class="jobs-container mt16">
             <?php
                foreach ($jobs as $item) {
                    
                    $cc_array =['18'=>'Holiday', '20'=>'No Work', '21'=>'Sick Day', '22'=>'Vacation'];
                    if(array_key_exists($item->cost_code, $cc_array)){
                       
                        echo '<div class="bg-secondary p8 round-sm m16-block ' . $red_alert . '">
                                <div class="flex align-center justify-between">
                                <div class="flex-w-4"><h3>' . html_entity_decode(out($item->job_name), ENT_QUOTES, 'UTF-8') . '</h3></div>
                                <div><p class="small-text">' . out($item->job_hours) . ' hrs</p></div>
                             </div>
                             <div>'.$cc_array[$item->cost_code].'</div>
                             <div class="flex justify-end ptb8">
                              <a href="' . BASE_URL . 'jobs/edit/' . out($item->job_code) . '" class="text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.513 16h4m-4-5h8m-4.5 11h1M7.51 22c-1.15-.025-1.924 0-2.923-.225c-1.05-.275-1.7-.925-1.924-2.225c-.225-.85-.153-4.626-.15-8.225c.002-2.793.02-5.326.25-5.85c.325-1.125 1.074-1.925 3.398-1.95m9.868 0c.8.075 2.89 0 3.298 2.3c.222 1.25.175 3.025.175 5.15M8.184 5.5c1.05.025 4.422 0 5.572 0c1.149 0 1.756-.946 1.749-1.825c-.008-.896-.8-1.595-1.575-1.675H8.16c-.925.05-1.55.8-1.65 1.55c-.1 1.025.65 1.9 1.674 1.95m10.094 8.875c-1.375 1.4-4.023 3.9-4.023 4.075c-.213.297-.4.9-.525 1.75c-.156.788-.344 1.475-.124 1.675s1.047.032 1.923-.15c.7-.075 1.35-.325 1.674-.575c.475-.42 3.698-3.675 4.073-4.1c.274-.375.3-1.075.06-1.5c-.135-.3-.985-1.1-1.26-1.325a1.52 1.52 0 0 0-1.799.15" color="currentColor" />
                                </svg>
                              </a>
                             
                             </div>
                             </div>';

                        continue;
                    }


                    if ($item->time_out == 'x') {
                        $total_hours = '';
                        $red_alert = 'alert-border';
                        $text_color = 'text-danger';
                        $time_out = '<svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24">
                                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor"><circle cx="12" cy="12" r="10" /><path d="M9.5 9.5L13 13m3-5l-5 5" />
                                        </g>
                                      </svg>';
                    } else {
                        $time_out = out($item->time_out);
                        $total_hours = out($item->job_hours) . ' hrs';
                        $red_alert = '';
                        $text_color = 'text-primary';
                    }
                    echo '<div class="bg-secondary p8 round-sm m16-block ' . $red_alert . '">';
                    echo '<div class="flex align-center justify-between">
                            <div class="flex-w-4"><h3>' . html_entity_decode(out($item->job_name), ENT_QUOTES, 'UTF-8') . '</h3></div>
                             <div><p class="small-text">' . out($total_hours) . '</p></div>
                          </div>';
                    echo '<div class="flex flex-col">
                            <p class="small-text">Time In:&nbsp;<span class="' . $text_color . '"> ' . out($item->time_in) . '</span></p>
                            <p class="small-text flex align-center">Time Out:&nbsp;<span class="' . $text_color . '">' . $time_out . '</span></p>
                         </div>';
                    if ($item->time_out == 'x') {
                        $html = '<div class="flex align-center justify-between pt16">';
                        $html .= '<div mx-post="jobs\etc_modal\\' . out($item->job_code) . '"';
                        $options = '"id":"etc-modal-' . $item->id . '"';
                        $html .= 'mx-build-modal=\'{' . $options . ' }\' >';
                        $html .= '<svg xmlns="http://www.w3.org/2000/svg" width="36px" height="36px" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                        <circle cx="12" cy="12" r="7" />
                                        <path d="m16 6l-.272-1.09c-.335-1.338-.502-2.007-.978-2.42a2 2 0 0 0-.165-.129C14.07 2 13.38 2 12 2s-2.069 0-2.585.361q-.086.06-.165.129c-.476.413-.643 1.082-.978 2.42L8 6m0 12l.272 1.09c.335 1.338.502 2.007.978 2.42q.08.069.165.129C9.93 22 10.62 22 12 22s2.069 0 2.585-.361q.085-.06.165-.129c.476-.413.643-1.082.978-2.42L16 18m-4-8v2.005L13 13" />
                                    </g>
                                </svg>
                            ' . out($item->duration) . '                              
                             </div>
                             <div class="btn-wrap">
                              <a href="' . BASE_URL . 'service_tickets/index/' . out($item->job_code) . '" class="text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <g fill="none" stroke="#733130" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="#733130">
                                        <path d="M20.054 11V7.817c0-1.693 0-2.54-.268-3.216c-.433-1.088-1.347-1.945-2.506-2.35c-.72-.253-1.623-.253-3.428-.253c-3.159 0-4.738 0-6 .441c-2.027.71-3.627 2.21-4.383 4.114c-.47 1.183-.47 2.665-.47 5.629v2.545c-.001 3.07-.001 4.605.85 5.671c.243.306.532.577.858.805c1.048.737 2.522.794 5.314.798" />
                                        <path d="M3 11.979c0-1.84 1.58-3.314 3.421-3.314c.666 0 1.45.116 2.098-.057a1.67 1.67 0 0 0 1.179-1.179c.173-.647.056-1.432.056-2.098a3.333 3.333 0 0 1 3.334-3.333m6.789 12.485l.688.684a1.477 1.477 0 0 1 0 2.096l-3.603 3.651a2 2 0 0 1-1.04.546l-2.232.482a.495.495 0 0 1-.59-.586l.474-2.209c.074-.392.265-.752.548-1.034l3.648-3.63a1.495 1.495 0 0 1 2.107 0" />
                                    </g>
                                </svg>
                              </a>
                             </div>

                             <div class="btn-wrap"> 
                                <a href="' . BASE_URL . 'jobs/close/' . out($item->job_code) . '" class="text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                        <g fill="none" stroke="#733130" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="#733130">
                                            <path d="M5.672 13.91C10 15.932 14 7.842 21 11.887l-3-9.102C13.424-.3 8.563 6.856 3 4.625L8 22" />
                                            <path d="M19 7C13.5 3 9 12 4.5 9M8 4.905L10.823 13m2.354-10L16 10.619" />
                                        </g>
                                    </svg>
                                </a>
                              </div>
                          </div>';
                        echo $html;
                    } else {
                        echo '<div class="flex align-center justify-between pt16">                        
                             <a href="' . BASE_URL . 'jobs-job_comments/index/' . out($item->job_code) . '" class="text-white">
                             <svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.099 19q-1.949-.192-2.927-1.172C2 16.657 2 14.771 2 11v-.5c0-3.771 0-5.657 1.172-6.828S6.229 2.5 10 2.5h4c3.771 0 5.657 0 6.828 1.172S22 6.729 22 10.5v.5c0 3.771 0 5.657-1.172 6.828S17.771 19 14 19c-.56.012-1.007.055-1.445.155c-1.199.276-2.309.89-3.405 1.424c-1.563.762-2.344 1.143-2.834.786c-.938-.698-.021-2.863.184-3.865" color="currentColor" />
                             </svg>
                             </a>

                              <a href="' . BASE_URL . 'jobs/edit/' . out($item->job_code) . '" class="text-white">
                              <svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.513 16h4m-4-5h8m-4.5 11h1M7.51 22c-1.15-.025-1.924 0-2.923-.225c-1.05-.275-1.7-.925-1.924-2.225c-.225-.85-.153-4.626-.15-8.225c.002-2.793.02-5.326.25-5.85c.325-1.125 1.074-1.925 3.398-1.95m9.868 0c.8.075 2.89 0 3.298 2.3c.222 1.25.175 3.025.175 5.15M8.184 5.5c1.05.025 4.422 0 5.572 0c1.149 0 1.756-.946 1.749-1.825c-.008-.896-.8-1.595-1.575-1.675H8.16c-.925.05-1.55.8-1.65 1.55c-.1 1.025.65 1.9 1.674 1.95m10.094 8.875c-1.375 1.4-4.023 3.9-4.023 4.075c-.213.297-.4.9-.525 1.75c-.156.788-.344 1.475-.124 1.675s1.047.032 1.923-.15c.7-.075 1.35-.325 1.674-.575c.475-.42 3.698-3.675 4.073-4.1c.274-.375.3-1.075.06-1.5c-.135-.3-.985-1.1-1.26-1.325a1.52 1.52 0 0 0-1.799.15" color="currentColor" />
                              </svg>
                              </a>
                          </div>';
                    }
                    echo '</div>';
                }
                ?>
             <div class="job-item">

             </div>
         </div>
     </div>  
 </section>
 <script>
     function clearFlash() {
         var msg = document.getElementById("flash-msg");
         if (msg) {
             msg.remove();
         }
     }

     // Set a timeout to clear the div after 5 seconds
     setTimeout(clearFlash, 10000);
 </script>