<?php if (empty($projects)) {
    $not_found = true;
    var_dump($row_count);
} ?>
<div>
    <?php if ($not_found) {  ?>
        <div class="text-secondary pt8"><i>* No projects found with that name.</div></i>
        <?php } else {
        foreach ($projects as $item) { ?>
             <div class="btn-tertiary round-sm m8-block">
                 <a class="flex align-center justify-between p8 anchor_custom" href="projects/show_project/<?= $item->id ?>">
                     <?= $item->project_name ?>
                     <svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
                         <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M22 15.5h-8m8 3h-8m4 3h-4m-7-15h9.75c2.107 0 3.16 0 3.917.506a3 3 0 0 1 .827.827C22 8.59 22 9.893 22 12M12 6.5l-.633-1.267c-.525-1.05-1.005-2.106-2.168-2.542C8.69 2.5 8.108 2.5 6.944 2.5c-1.816 0-2.724 0-3.406.38A3 3 0 0 0 2.38 4.038C2 4.72 2 5.628 2 7.444V10.5c0 4.714 0 7.071 1.464 8.535c1.3 1.3 3.304 1.447 7.036 1.463" color="currentColor" />
                     </svg>
                 </a>
             </div>   
             
        <?php
           
        }
    } ?>
</div>