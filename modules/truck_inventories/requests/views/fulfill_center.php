 <section class="main-sec">
     <div class="container cont-sm">
         <div class="container-header pb8 flex align-center justify-between mb8">
             <div>
                 <h2><?= $heading ?></h2>
                 <p class="small-text text-secondary">Unfulfilled Requests</p>
             </div>
             <div class="">
                 <a href="truck_inventories-requests/search" class="button btn-primary flex align-center">
                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                         <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.5 17.5L22 22m-2-11a9 9 0 1 0-18 0a9 9 0 0 0 18 0" color="currentColor" />
                     </svg>&nbsp;Search
                 </a>
             </div>
         </div>
         <div class="">
             <?php
                foreach ($pending_fulfill as $item) {
                    echo '<div class="p8 m8-block round-sm bg-secondary flex align-center justify-between">';
                    echo '<div>';
                    $show_name = $item->request_name ? $item->request_name : 'Request Made';
                    echo '<p>'.$show_name.'</p>';
                    echo '<p class="xsmall-text">'.date('m-n-Y', $item->request_date). ' by ' . $item->first_name . '</p>';                 
                    echo '</div><div class="flex">';
                    echo anchor(
                        'truck_inventories-requests/fulfill_request/' . $item->id,
                        '<svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor"><path d="M20.46 17.515c.36.416.54.624.54.985s-.18.57-.54.985C19.56 20.52 17.937 22 16 22s-3.561-1.48-4.46-2.515c-.36-.416-.54-.623-.54-.985c0-.361.18-.57.54-.985C12.44 16.48 14.063 15 16 15s3.561 1.48 4.46 2.515"/><path d="M20 13.003V7.82c0-1.694 0-2.54-.268-3.217c-.43-1.087-1.342-1.945-2.497-2.35C16.517 2 15.617 2 13.818 2c-3.148 0-4.722 0-5.98.441c-2.02.71-3.615 2.211-4.37 4.114C3 7.74 3 9.221 3 12.185v2.546c0 3.07 0 4.605.848 5.672c.243.305.53.576.855.805c.912.643 2.147.768 4.297.792"/><path d="M3 12a3.333 3.333 0 0 1 3.333-3.333c.666 0 1.451.116 2.098-.057A1.67 1.67 0 0 0 9.61 7.43c.173-.647.057-1.432.057-2.098A3.333 3.333 0 0 1 13 2m2.992 16.5h.01"/></g></svg>',
                        array('class' => 'alert-info p4 round-sm')
                    );
                    echo '</div></div>';
                }
                ?>
         </div>
     </div>
 </section>
 <style>
     /* Link to the truck_inventories/assets/css/custom.css */
     @import url('<?= BASE_URL ?>truck_inventories-requests_module/css/custom.css');
 </style>

 <!-- Link to the assets/js/custom.js -->

 <script src="<?= BASE_URL ?>truck_inventories-requests_module/js/custom.js"></script>