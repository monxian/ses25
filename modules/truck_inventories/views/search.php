 <section class="main-sec">
     <div class="container cont-sm">
         <div class="container-header pb8 flex align-center justify-between">
             <div>
                 <h2><?= $heading ?></h2>
                 <p class="small-text text-secondary">You can search by partial words too.</p>
             </div>
         </div>
         <form id="myForm" mx-post="truck_inventories/search_mx/<?= $mx_path ?>" mx-target="#result" class="mb-16">
             <div class="input-container">
                 <input type="text" name="query" id="query" placeholder="Name or Number">
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