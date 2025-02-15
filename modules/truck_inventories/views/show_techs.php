 <section class="main-sec">
     <div class="container cont-sm">
         <div class="container-header pb8">
             <h2>View by Tech</h2>
         </div>
         <div>
             <?php foreach ($tech_list as $tech) { ?>
                 <div class="flex align-center round-sm m8-block btn-tertiary justify-center">
                     <a href="truck_inventories/show_by_tech/<?= $tech->member_id ?>" class="anchor_custom p8 flex-w-1 text-center">
                         <?= ucfirst(out($tech->member_name)) ?>
                     </a>
                 </div>
             <?php } ?>
         </div>

     </div>
 </section>