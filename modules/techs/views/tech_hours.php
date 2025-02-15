 <section class="main-sec">
     <div class="container cont-sm">
         <div class="container-header pb8">
             <div class="flex align-center">
                 <h2>Tech Hours</h2>
             </div>
         </div>
         <div>
             <?php foreach ($tech_list as $tech) { ?>
               
                     <a href="techs/hours_per_tech/<?= $tech->tech_id ?>" class="flex align-center round-sm m8-block btn-tertiary p16 no-decoration">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                             <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                 <circle cx="12" cy="12" r="10" />
                                 <path d="M9.5 9.5L13 13m3-5l-5 5" />
                             </g>
                         </svg>
                         <div class="pl8"><?= ucfirst(out($tech->username)) ?></div>
                     </a>

                 
             <?php } ?>
         </div>
 </section>

 <style>
     /* Link to the techs/assets/css/custom.css */
     @import url('<?= BASE_URL ?>techs_module/css/custom.css');
 </style>

 <!-- Link to the assets/js/custom.js -->
 <script src="<?= BASE_URL ?>techs_module/js/custom.js"></script>

 <!--<div class="flex align-center round-sm m8-block btn-tertiary p8"
                     mx-get="techs/hours_modal/< ? = $tech->tech_id ?>"
                     mx-build-modal='{
                        "id":"hours-modal"                      
                    }'> -->