 <section class="main-sec">
     <div class="container cont-sm">
         <div class="container-header pb8 flex align-center justify-between">
             <div>
                 <h2>Comments</h2>
                 <p><?= html_entity_decode(out($job->job_name), ENT_QUOTES, 'UTF-8') ?></p>
             </div>
             <div class="text-primary" mx-get="jobs-job_comments/add_comment_modal/<?= $job->job_code ?>" mx-build-modal='{
                        "id":"add-comment-modal"                      
                     }'>
                 <svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
                     <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v8m4-4H8m14 0c0-5.523-4.477-10-10-10S2 6.477 2 12s4.477 10 10 10s10-4.477 10-10" color="currentColor" />
                 </svg>
             </div>
         </div>
         <div class="comments-wrap">
             <?php foreach ($comments as $item) { ?>
                 <div class="comment-container bg-secondary p8 m8-block round-sm pos-rel">
                     <div>
                         <p class="small-text"><?= out($item->date) ?></p>
                         <p><b><?= html_entity_decode(out($item->summary), ENT_QUOTES, 'UTF-8') ?></b></p>
                     </div>
                     <div class="pt8">
                         <p><?= html_entity_decode(out($item->comment), ENT_QUOTES, 'UTF-8') ?></p>
                     </div>
                     <div class="pt8 flex align-center justify-between">
                         <?php if ($item->editable) { ?>
                             <div>
                                 <div mx-get="jobs-job_comments/delete_comment_modal/<?= out($item->id) ?>"
                                     mx-build-modal='{"id":"delete-comment-modal-<?= out($item->id) ?>" }'>
                                     <svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
                                         <path fill="none" stroke="#ed8d8d" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12.5 2.012A11 11 0 0 0 12 2C6.478 2 2 6.284 2 11.567c0 2.538 1.033 4.845 2.719 6.556c.371.377.619.892.519 1.422a5.3 5.3 0 0 1-1.087 2.348a6.5 6.5 0 0 0 4.224-.657c.454-.241.681-.362.842-.386s.39.018.848.104c.638.12 1.286.18 1.935.18c5.522 0 10-4.284 10-9.567q0-.286-.017-.567M16 2l3 3m0 0l3 3m-3-3l3-3m-3 3l-3 3m-4.004 4h.008m3.987 0H16m-8 0h.009" color="#ed8d8d" />
                                     </svg>
                                 </div>
                             </div>
                             <div>
                                 <div mx-get="jobs-job_comments/add_comment_modal/<?= out($item->id) ?>"
                                     mx-build-modal='{"id":"update-comment-modal-<?= out($item->id) ?>" }'>
                                     <svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
                                         <g fill="none" stroke="#cdb851" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="#cdb851">
                                             <path d="M21.917 10.5q.027.234.043.47c.053.83.053 1.69 0 2.52c-.274 4.243-3.606 7.623-7.79 7.9a33 33 0 0 1-4.34 0a4.9 4.9 0 0 1-1.486-.339c-.512-.21-.768-.316-.899-.3c-.13.016-.319.155-.696.434c-.666.49-1.505.844-2.75.813c-.629-.015-.943-.023-1.084-.263s.034-.572.385-1.237c.487-.922.795-1.978.328-2.823c-.805-1.208-1.488-2.639-1.588-4.184a20 20 0 0 1 0-2.52c.274-4.243 3.606-7.622 7.79-7.9a33 33 0 0 1 3.67-.037M8.5 15h7m-7-5H11" />
                                             <path d="m20.868 2.44l.693.692a1.5 1.5 0 0 1 0 2.121l-3.628 3.696a2 2 0 0 1-1.047.551l-2.248.489a.5.5 0 0 1-.595-.594l.479-2.235a2 2 0 0 1 .551-1.047l3.674-3.674a1.5 1.5 0 0 1 2.121 0" />
                                         </g>
                                     </svg>
                                 </div>
                             </div>
                         <?php } ?>
                     </div>

                 </div>
             <?php  } ?>
         </div>
     </div>
 </section>
 <style>
     /* Link to the job_comments/assets/css/custom.css */
     @import url('<?= BASE_URL ?>jobs-job_comments_module/css/custom.css');

     .comments-wrap {
         max-height: calc(100svh - 180px);
         overflow: auto;
     }
 </style>

 <!-- Link to the assets/js/custom.js -->
 <script src="<?= BASE_URL ?>jobs-job_comments_module/js/custom.js"></script>