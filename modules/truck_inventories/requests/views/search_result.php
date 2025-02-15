<?php
if (count($rows) <= 0) {
    
    echo '<div class="flex align-center justify-center  pt16">           
            <a href="truck_inventories-requests/add_manual/'. $request_code .'" class="text-primary">Nothing found you can add the item manually.</a>            
          </div>';
} else {
    foreach ($rows as $item) {
        if (count($rows) == 1 && $item->part_number == NULL) {
            echo "Nothing found";
            continue;
        } else if ($item->part_number == NULL) {
            continue;
        }
?>
      
        <div class="bg-secondary m8-block p8 round-sm" id="item-<?= out($item->id) ?>">
            <div class="flex align-center justify-between">
                <div>
                    <p class="small-text text-secondary">#<?= out($item->part_number) ?></p>
                    <p><?= out($item->name) ?></p>
                </div>
                <div>
                    <div class="request-add"
                        mx-post="truck_inventories-requests/add_request_mx/<?= out($item->id) ?>/<?= $request_code?>"
                        mx-build-modal='{"id":"add-request-modal-<?= out($item->id) ?>" }'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v8m4-4H8m14 0c0-5.523-4.477-10-10-10S2 6.477 2 12s4.477 10 10 10s10-4.477 10-10" color="currentColor" />
                        </svg>
                    </div>
                </div>
            </div>         
        </div>
        <div mx-get="jobs-job_comments/delete_comment_modal/<?= out($item->id) ?>"
            mx-build-modal='{"id":"delete-comment-modal-<?= out($item->id) ?>" }'>

    <?php
    }
}

    ?>

    <style>
        .dd-menu {
            display: none;
        }
    </style>