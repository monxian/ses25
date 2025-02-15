 <section class="main-sec">
     <div class="container cont-sm">
         <div class="container-header pb8 flex align-center justify-between">
             <div>
                 <h3>Tech Support </h3>
                 <div class="small-text">Names are clickable</div>
             </div>
         </div>
         <div>
             <?php
                foreach ($numbers as $item) { ?>
                 <div class="bg-secondary m8-block p16 round-sm flex align-center justify-between ">
                     <div>
                         <a href="tel:<?= str_replace("-", "", $item->number) ?>" class="text-primary"><?= $item->name ?></a>
                     </div>
                     <div>
                         <p class="small-text"><?= $item->number ?></p>
                         <p class="small-text"><?= $item->number_alt ?></p>
                         <p class="small-text"><?= $item->notes ?></p>
                     </div>
                 </div>


             <?php
                }
                ?>
         </div>
     </div>
 </section>
 <style>
     /* Link to the sup_numbers/assets/css/custom.css */
     @import url('<?= BASE_URL ?>sup_numbers_module/css/custom.css');
 </style>

 <!-- Link to the assets/js/custom.js -->
 <script src="<?= BASE_URL ?>sup_numbers_module/js/custom.js"></script>