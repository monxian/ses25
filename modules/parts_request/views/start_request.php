 <section class="main-sec">
     <div class="container cont-sm">
         <div class="container-header pb8 flex align-center justify-between">
             <div>
                 <h2><?= $heading ?></h2>
                 <p class="sm-text"><?= $subheading ?></p>
             </div>
             <div>
                 <a href="parts_request/delete_request/<?= $request_code ?>" class="text-danger">
                     <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                         <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m19.5 5.5l-.62 10.025c-.158 2.561-.237 3.842-.88 4.763a4 4 0 0 1-1.2 1.128c-.957.584-2.24.584-4.806.584c-2.57 0-3.855 0-4.814-.585a4 4 0 0 1-1.2-1.13c-.642-.922-.72-2.205-.874-4.77L4.5 5.5M3 5.5h18m-4.944 0l-.683-1.408c-.453-.936-.68-1.403-1.071-1.695a2 2 0 0 0-.275-.172C13.594 2 13.074 2 12.035 2c-1.066 0-1.599 0-2.04.234a2 2 0 0 0-.278.18c-.395.303-.616.788-1.058 1.757L8.053 5.5m1.447 11v-6m5 6v-6" color="currentColor" />
                     </svg>
                 </a>
             </div>
         </div>
         <div class="box-shadow-dk">
             <?php

                echo '<form  
                         action = "#"                                  
                         mx-post="parts_request/save_row/' . $request_code . '"
                         mx-target = "#parts-list"
                         mx-swap = "beforeend"                      
                      >';

                echo '<div class="form-wrap">';
                echo form_label('Qty', array('class' => 'accent'));
                $attributes['id'] = 'part-qty';
                $attributes['min'] = '1';
                echo form_number('part_qty', $part_qty, $attributes);

                echo form_label('Part Number', array('class' => 'accent'));
                $attributes['id'] = 'part-num';
                unset($attributes['min']);
                echo form_input('part_num', $part_num, $attributes);

                echo form_label('Part Name', array('class' => 'accent'));
                $attributes['id'] = 'part-name';
                echo form_input('part_name', $part_name, $attributes);
                echo '<div class="form-btns">';
                echo  '<button type="submit">Add Part</button>';
                echo '</div></div>';
                ?>

             <?php
                echo form_close();
                ?>
         </div>
         <div class="p16-block pi-8 bg-secondary m16-block round-sm box-shadow-dk">
             <h3 class="pb4">Parts List</h3>
             <div class="ptable" id="parts-list">
                 <div class="flex align-center justify-between bb-1 pb4">

                     <div class="ptable-cell"><i>Qty</i></div>
                     <div class="ptable-cell"><i>Name</i></div>
                     <div class="ptable-cell"><i>Number</i></div>
                     <div>&nbsp;</div>

                 </div>
                 <?php
                    if ($parts_list) {
                        foreach ($parts_list as $item) { ?>
                         <div class="flex align-center justify-between alertx" id="item-<?= $item->id ?>">
                             <div class="ptable-cell"><?= $item->part_qty ?></div>
                             <div class="ptable-cell"><?= $item->part_name ?></div>
                             <div class="ptable-cell"><?= $item->part_num ?></div>
                             <button
                                 onclick="removeRow('item-<?= $item->id ?>')"
                                 mx-post="parts_request/delete_row/<?= $item->id ?>"
                                 class="btn-danger btn-sm">×</button>
                         </div>
                 <?php
                        }
                    }
                    ?>
             </div>
         </div>
         <div class="save-parts flex align-center justify-between">
             <a href="parts_request/save_request/<?= $request_code ?>" class="button btn-primary">Save</a>
             <a href="parts_request" class="button btn-secondary">Cancel</a>
         </div>
     </div>
 </section>
 <style>
     /* Link to the test/assets/css/custom.css */
     @import url('parts_request_module/css/custom.css');

     .form-wrap {
         border: 1px solid var(--border);
         border-radius: 6px;
         padding: 0.5em;

     }

     .form-wrap input {
         width: 100%;
     }

     .box-shadow-dk {
         box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px;
     }

     .parts-rqs-table {
         width: 100%;
         min-height: 50px;
         border-collapse: collapse;

     }

     .parts-rqs-table thead tr th {
         border-bottom: 1px solid white;
     }

     .parts-rqs-table tr td {
         text-align: center;

     }

     .ptable-cell {
         display: block;
         padding: 1em 0;
     }

     .save-parts {      
         margin-top: 5em;
         padding-bottom: 1em;
     }
 </style>

 <script>
     function removeRow(row_id) {
         let item = document.getElementById(`${row_id}`);
         item.style.display = 'none';

     }
 </script>



 <!-- Link to the assets/js/custom.js 
 <script src="< ?= BASE_URL ?>parts_request/js/custom.js"></script>-->