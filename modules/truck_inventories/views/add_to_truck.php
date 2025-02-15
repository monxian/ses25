 <section class="main-sec">
     <div class="container cont-sm">
         <div class="container-header pb8 flex align-center justify-between">
             <div>
                 <h2>Add To Truck</h2>
                 <p class="small-text text-secondary">Look up by name or part number.</p>
                 <p class="small-text text-secondary">If looking by maker, name only.</p>
             </div>
         </div>
         <form id="myForm" mx-post="truck_inventories/search_mx" mx-target="#result" class="mb-16">
             <div class="input-container">
                 <input type="text" name="query" id="query">
                 <button type="submit">Look Up</button>


                 <div class="modal-form-group ">
                     <?php
                        echo form_label('Look up by Maker', array("for" => "by-maker"));
                        echo form_checkbox('by_maker', '1');
                        ?>
                 </div>
             </div>
         </form>
         <div id="result"></div>
     </div>
 </section>
 <style>
     /* Link to the truck_inventories/assets/css/custom.css */
     @import url('<?= BASE_URL ?>truck_inventories_module/css/custom.css');

     #myForm {

         background-color: hsl(210, 100%, 60%, .1);
         padding: 12px;
         border-radius: 5px;
     }
 </style>