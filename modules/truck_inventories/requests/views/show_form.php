 <section class="main-sec">
     <div class="container cont-sm">
         <div class="container-header pb8 flex align-center justify-between mb8">
             <div>
                 <h2><?= $heading ?></h2>
                 <p class="small-text text-secondary"><?= out($request_form->request_name) ?>&nbsp;&nbsp;<?= date('M d,Y', out($request_form->request_date)) ?></p>
             </div>
             <div mx-get="truck_inventories-requests/delete_modal/<?= $request_form->id ?>"
                 mx-build-modal='{
                        "id":"delete-modal"                      
                     }'>
                 <svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
                     <path fill="none" stroke="#ed8d8d" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m19.5 5.5l-.62 10.025c-.158 2.561-.237 3.842-.88 4.763a4 4 0 0 1-1.2 1.128c-.957.584-2.24.584-4.806.584c-2.57 0-3.855 0-4.814-.585a4 4 0 0 1-1.2-1.13c-.642-.922-.72-2.205-.874-4.77L4.5 5.5M3 5.5h18m-4.944 0l-.683-1.408c-.453-.936-.68-1.403-1.071-1.695a2 2 0 0 0-.275-.172C13.594 2 13.074 2 12.035 2c-1.066 0-1.599 0-2.04.234a2 2 0 0 0-.278.18c-.395.303-.616.788-1.058 1.757L8.053 5.5m1.447 11v-6m5 6v-6" color="#ed8d8d" />
                 </svg>
             </div>

         </div>
         <div class="tech-request-wrapper">
             <table class="request-table tech-request-table pt8">
                 <tr>
                     <th class="text-center">Action</th>
                     <th class="text-center">Qty</th>
                     <th class="text-center">Part Name & Num</th>
                 </tr>
                 <?php                   
                    foreach ($products as $row) { ?>
                     <tr>
                         <td class="print-hide">
                             <a href="truck_inventories-requests/delete/<?= $row->id ?>/<?= $request_form->id ?>">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                     <path fill="none" stroke="#df2020" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 12H8m-5.5 0c0-4.478 0-6.718 1.391-8.109S7.521 2.5 12 2.5c4.478 0 6.718 0 8.109 1.391S21.5 7.521 21.5 12c0 4.478 0 6.718-1.391 8.109S16.479 21.5 12 21.5c-4.478 0-6.718 0-8.109-1.391S2.5 16.479 2.5 12" color="#df2020" />
                                 </svg>
                             </a>
                         </td>
                         <td><?= out($row->qty) ?></td>
                         <td>
                            <?php 
                                if($row->name){
                                    echo out($row->name);
                                } else {
                                    echo out($row->custom_name);
                                }

                            ?>
                          
                             <?= out($row->part_number) ?>
                         </td>
                     </tr>

                 <?php
                    }
                    ?>
                 <tr>
                     <td>
                         <a href="truck_inventories-requests/add_to_list/<?= $request_form->id ?>" class="text-primary">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                 <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                     <path d="M12 8v8m4-4H8" />
                                     <circle cx="12" cy="12" r="10" />
                                 </g>
                             </svg>
                         </a>
                     </td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>

                 </tr>
             </table>
         </div>
         <section class="flex align-center justify-between mt16">
             <div>
                 <a href="truck_inventories-requests/email_request/<?= $request_form->id ?>" class="button btn-primary-45 flex align-center"><svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24">
                         <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                             <path d="M22 12.5c0-.491-.005-1.483-.016-1.976c-.065-3.065-.098-4.598-1.229-5.733c-1.131-1.136-2.705-1.175-5.854-1.254a115 115 0 0 0-5.802 0c-3.149.079-4.723.118-5.854 1.254c-1.131 1.135-1.164 2.668-1.23 5.733a69 69 0 0 0 0 2.952c.066 3.065.099 4.598 1.23 5.733c1.131 1.136 2.705 1.175 5.854 1.254q1.204.03 2.401.036" />
                             <path d="m7 8.5l2.942 1.74c1.715 1.014 2.4 1.014 4.116 0L17 8.5m5 9h-8m8 0c0-.7-1.994-2.008-2.5-2.5m2.5 2.5c0 .7-1.994 2.009-2.5 2.5" />
                         </g>
                     </svg>&nbsp;Send</a>
             </div>
             <div>
                 <a href="truck_inventories-requests" class="button btn-secondary">Back</a>
             </div>
         </section>

     </div>
 </section>
 <style>
     /* Link to the truck_inventories/assets/css/custom.css */
     @import url('<?= BASE_URL ?>truck_inventories-requests_module/css/custom.css');

     .tech-request-wrapper {
         overflow: auto;
     }

     .tech-request-table {
         min-width: 320px;
     }

     .request-add {
         color: var(--color-primary-45);
         cursor: pointer;
     }

     .request-add:hover {
         color: var(--color-primary-35);
     }
 </style>

 <!-- Link to the assets/js/custom.js -->

 <script src="<?= BASE_URL ?>truck_inventories-requests_module/js/custom.js"></script>