 <section class="main-sec">
     <div class="container cont-sm">
         <div class="container-header pb8 flex align-center justify-between">
             <div>
                 <h2><?= $heading ?></h2>
                 <p class="small-text text-secondary"><?= out($request->request_name) ?>&nbsp;&nbsp;<?= date('M d,Y', out($request->request_date)) ?></p>
             </div>
             <div>
                 <a href="truck_inventories-requests/show/<?= $request->id ?>" class="button btn-secondary btn-sm" id="list-items">
                     <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                         <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                             <path d="M8 16h7.263c4.488 0 5.17-2.82 5.998-6.93c.239-1.187.358-1.78.071-2.175s-.837-.395-1.938-.395H6" />
                             <path d="M8 16L5.379 3.515A2 2 0 0 0 3.439 2H2.5m6.38 14h-.411C7.105 16 6 17.151 6 18.571a.42.42 0 0 0 .411.429H17.5" />
                             <circle cx="10.5" cy="20.5" r="1.5" />
                             <circle cx="17.5" cy="20.5" r="1.5" />
                         </g>
                     </svg>
                     <span id="list-num"><?= $list_sum ?></span>
                  </a>
             </div>
             <!-- <div>
                 <a href="truck_inventories-requests/" class="button btn-secondary">Done</a>
             </div>-->
         </div>

         <form id="myForm"
             mx-post="truck_inventories-requests/search_request_mx/<?= $request->id ?>"
             mx-target="#result"
             mx-close-on-success="true"
             mx-after-swap="myfunc"
             class="mb-16">
             <div class="input-container">
                 <input type="text" name="query" id="query" placeholder="Search by Part Number">
                 <button type="submit">Search</button>
             </div>
         </form>
         <div id="result"></div>
     </div>
 </section>
 <style>
     /* Link to the truck_inventories/assets/css/custom.css */
     @import url('<?= BASE_URL ?>truck_inventories_module/css/custom.css');

     .request-add {
         color: var(--color-primary-45);
         cursor: pointer;
     }

     .request-add:hover {
         color: var(--color-primary-35);
     }

     #list-items {
         display: block;
         position: relative;
     }

     #list-num {
         position: absolute;
         top: -5px;
         right: -5px;
         background-color: white;
         color: var(--color-surface-20);
         padding: 2px 4px;
         border-radius: 50%;
         font-size: .75rem;
         font-weight: bold;
     }
 </style>
 <!-- Link to the assets/js/custom.js -->

 <script src="<?= BASE_URL ?>truck_inventories-requests_module/js/custom.js"></script>