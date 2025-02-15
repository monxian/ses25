 <section class="main-sec">
     <div class="container cont-sm">
         <div class="container-header pb8 flex align-center justify-between">
             <div>
                 <h2><?= $heading ?></h2>
                 <p class="small-text text-secondary">Search by Date or Name</p>
             </div>
         </div>
         <form id="myForm" mx-post="truck_inventories-requests/submit_search" mx-target="#result" class="mb-16">
             <div class="input-container">
                 <input type="text" name="query" id="query" placeholder="mm-dd-YYYY or Name">
                 <button type="submit">Search</button>
             </div>
         </form>
         <div id="result"></div>
     </div>
 </section>
 <style>
     /* Link to the truck_inventories/assets/css/custom.css */
     @import url('<?= BASE_URL ?>truck_inventories_module/css/custom.css');
 </style>