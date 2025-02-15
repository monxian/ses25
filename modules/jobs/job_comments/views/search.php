 <section class="main-sec">
     <div class="container cont-sm">
         <div class="container-header pb8 flex align-center justify-between">
             <div>
                 <h2>Search Comments</h2>
             </div>
         </div>
         <form id="myForm" mx-post="jobs-job_comments/search_result" mx-target="#result" class="mb-16">
             <div class="input-container">
                 <input type="text" name="query" id="query" required>
                 <button type="submit">Search</button>
             </div>
         </form>
         <div id="result">
             <p>Latest Comments</p>
             <?php foreach ($last_comments as $item) {
                    $conv_date = date("M d, Y", strtotime($item->comment_date));

                ?>
                 <div class="comment-container bg-secondary p8 m8-block round-sm pos-rel">
                     <div>
                         <h3 class="text-primary"><b><?= html_entity_decode(out($item->job_name), ENT_QUOTES, 'UTF-8') ?></b></h3>
                         <div>
                             <p class="small-text text-secondary"><i>Author: <?= ucfirst($item->first_name) ?></i></p>
                             <p class="small-text"><span>Last Update: &nbsp;<?= $conv_date ?> </span></p>

                         </div>

                     </div>
                     <div class="pt8">
                         <p class="small-text pt8 pb8 text-secondary">Comment:</p>
                         <p><?= html_entity_decode(out($item->comment), ENT_QUOTES, 'UTF-8') ?></p>
                     </div>
                 </div>
             <?php } ?>
         </div>
     </div>
 </section>


 <style>
     /* Link to the test/assets/css/custom.css */
     @import url('<?= BASE_URL ?>jobs-job_comments_module/css/custom.css');
 </style>