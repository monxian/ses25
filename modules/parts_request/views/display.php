 <section class="main-sec">
     <div class="container cont-sm">
         <div class="container-header pb8 flex align-center justify-between">
             <div>
                 <h2><?= $heading ?></h2>
                 <p class="small-text text-secondary">Latest Request Forms</p>
             </div>
             <div>
                 <a href="parts_request/start" class="button btn-primary btn-sm flex align-center">
                     <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                         <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v8m4-4H8m14 0c0-5.523-4.477-10-10-10S2 6.477 2 12s4.477 10 10 10s10-4.477 10-10" color="currentColor" />
                     </svg>
                     <span class="show-mobile">&nbsp;New Request</span>
                 </a>
             </div>
         </div>
         <div>
             <?php
                foreach ($requests as $item) {
                    $request_date = date('M d,Y', $item->request_date);
                ?>
                 <div class="bg-secondary m8-block p16 round-sm flex align-center justify-between ">
                     <div>
                         <p class=" small-text text-primary-85"><?= out($item->request_name) ?></p>
                         <span class="small-text"> Requested On &nbsp; </span><?= $request_date  ?>
                     </div>
                     <div>
                         <?php
                            if ($item->sent == 1 && $item->fulfilled == 0) {
                                echo '<p class="alert-info round-xs p4 flex align-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor"><path stroke="currentColor" d="m2 4.5l6.913 3.917c2.549 1.444 3.625 1.444 6.174 0L22 4.5m-7 13s.5 0 1 1c0 0 1.588-2.5 3-3"/><path stroke="currentColor" d="M22 17a5 5 0 1 1-10 0a5 5 0 0 1 10 0"/><path fill="currentColor" d="m9.102 2.037l.02.75zM2.016 9.04l.75.015zm12.892-7.003l.019-.75zm7.086 7.003l.75-.016zM9.084 19.75a.75.75 0 0 0 .037-1.5zm-7.068-7.753l.75-.016zm19.229-1.489a.75.75 0 1 0 1.5.02zM9.12 2.786c1.93-.048 3.839-.048 5.768 0l.038-1.5c-1.954-.048-3.89-.048-5.843 0zM1.266 9.024a70 70 0 0 0 0 2.99l1.5-.033a68 68 0 0 1 0-2.926zm7.818-7.737c-1.553.039-2.8.068-3.796.242c-1.03.18-1.867.525-2.574 1.236l1.063 1.057c.425-.427.941-.67 1.769-.815c.862-.15 1.978-.18 3.575-.22zM2.766 9.055c.033-1.558.058-2.644.204-3.486c.14-.806.38-1.317.807-1.747L2.714 2.765c-.704.707-1.046 1.533-1.222 2.548c-.17.979-.194 2.197-.226 3.71zm12.123-6.269c1.598.04 2.714.07 3.575.22c.828.145 1.344.39 1.769.816l1.064-1.057c-.708-.711-1.545-1.056-2.575-1.236c-.996-.174-2.243-.203-3.795-.242zm7.855 6.238c-.032-1.514-.056-2.732-.226-3.711c-.175-1.015-.518-1.84-1.221-2.548l-1.064 1.057c.428.43.668.941.808 1.747c.145.842.17 1.928.204 3.487zM9.121 18.25c-1.597-.04-2.713-.07-3.575-.22c-.828-.145-1.344-.389-1.769-.816l-1.063 1.058c.707.711 1.544 1.056 2.574 1.235c.997.174 2.243.204 3.796.243zm-7.855-6.237c.032 1.513.056 2.732.226 3.71c.176 1.015.518 1.841 1.222 2.55l1.063-1.059c-.427-.43-.667-.94-.807-1.747c-.146-.841-.171-1.927-.204-3.486zm20.728-1.495l.75.01v-.01l.001-.03l.001-.112a64 64 0 0 0-.002-1.352l-1.5.032a39 39 0 0 1 .002 1.305v.108l-.001.03v.009z"/></g>
                                    </svg>&nbsp;Pending</p>';
                            } elseif ($item->sent == 1 && $item->fulfilled == 1) {
                                echo '<p class="alert-success round-xs p4 flex align-center">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                            <path d="M13.5 20s1 0 2 2c0 0 3.177-5 6-6M7 16h4m-4-5h8M6.5 3.5c-1.556.047-2.483.22-3.125.862c-.879.88-.879 2.295-.879 5.126v6.506c0 2.832 0 4.247.879 5.127C4.253 22 5.668 22 8.496 22h2.5m4.496-18.5c1.556.047 2.484.22 3.125.862c.88.88.88 2.295.88 5.126V13.5" />
                                            <path d="M6.496 3.75c0-.966.784-1.75 1.75-1.75h5.5a1.75 1.75 0 1 1 0 3.5h-5.5a1.75 1.75 0 0 1-1.75-1.75" />
                                        </g>
                                    </svg>&nbsp;Complete</p>';
                            } else { ?>
                             <a href="parts_request/start/<?= out($item->request_code) ?>" class="flex-inline pr16 no-decoration text-primary">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
                                     <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                         <path d="m16.214 4.982l1.402-1.401a1.982 1.982 0 0 1 2.803 2.803l-1.401 1.402m-2.804-2.804l-5.234 5.234c-1.045 1.046-1.568 1.568-1.924 2.205S8.342 14.561 8 16c1.438-.342 2.942-.7 3.579-1.056s1.16-.879 2.205-1.924l5.234-5.234m-2.804-2.804l2.804 2.804" />
                                         <path d="M21 12c0 4.243 0 6.364-1.318 7.682S16.242 21 12 21s-6.364 0-7.682-1.318S3 16.242 3 12s0-6.364 1.318-7.682S7.758 3 12 3" />
                                     </g>
                                 </svg>
                             </a>
                             <a href="parts_request/send/<?= out($item->request_code) ?>" class="flex-inline pr8 no-decoration text-primary">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                                     <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                         <path d="M22 12.5c0-.491-.005-1.483-.016-1.976c-.065-3.065-.098-4.598-1.229-5.733c-1.131-1.136-2.705-1.175-5.854-1.254a115 115 0 0 0-5.802 0c-3.149.079-4.723.118-5.854 1.254c-1.131 1.135-1.164 2.668-1.23 5.733a69 69 0 0 0 0 2.952c.066 3.065.099 4.598 1.23 5.733c1.131 1.136 2.705 1.175 5.854 1.254q1.204.03 2.401.036" />
                                         <path d="m7 8.5l2.942 1.74c1.715 1.014 2.4 1.014 4.116 0L17 8.5m5 9h-8m8 0c0-.7-1.994-2.008-2.5-2.5m2.5 2.5c0 .7-1.994 2.009-2.5 2.5" />
                                     </g>
                                 </svg>
                             </a>


                         <?php
                            }
                            ?>

                     </div>

                 </div>
             <?php
                }
                ?>
         </div>
     </div>
 </section>

 <style>
     /* Link to the parts_request/assets/css/custom.css */
     @import url('<?= BASE_URL ?>parts_request_module/css/custom.css');
 </style>

 <!-- Link to the assets/js/custom.js -->
 <script src="<?= BASE_URL ?>parts_request_module/js/custom.js"></script>