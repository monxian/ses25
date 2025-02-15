<section class="main-sec">
    <div class="container max-content min-50p">
        <div class="container-header pb8">
            <div class="flex align-center justify-between">
                <div>
                    <h2>Trucks</h2>
                    <p>Add, delete or edit trucks</p>
                </div>
                <div>
                    <a href="trucks/edit_truck" class="text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v8m4-4H8m14 0c0-5.523-4.477-10-10-10S2 6.477 2 12s4.477 10 10 10s10-4.477 10-10" color="currentColor" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div>
            <?php
            foreach ($trucks as $item) {
                $assigned = $item->assigned == 1 ? true : false;
            ?>
                <div class="border border-secondary p8 round-sm bg-secondary p8-block flex align-center justify-between">
                    <div class="truck-info">
                        <div><?= $item->make ?></div>
                        <div><span class="small-text text-secondary">Plate: </span><?= $item->plate_number ?></div>
                        <div><span class="small-text text-secondary">VIN: </span><?= $item->vin ?></div>
                    </div>
                    <div class="flex align-center justify-between truck-edit">
                        <div>
                            <a href="trucks/edit_truck/<?= $item->id ?>" class="button btn-primary-45">Edit</a>
                        </div>
                        <div>
                            <?php if ($assigned) { ?>
                                <div class="text-center">
                                    <p><span class="small-text text-secondary">Assigned to </span></p>
                                    <p><?= ucfirst($item->member_name) ?></p>
                                </div>
                            <?php
                            } else { ?>
                                <div mx-delete="trucks/delete_modal/<?= $item->id ?>"
                                    mx-build-modal='{
                                        "id":"delete-modal"                      
                                    }' class="pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
                                        <path fill="none" stroke="#ed8d8d" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m19.5 5.5l-.62 10.025c-.158 2.561-.237 3.842-.88 4.763a4 4 0 0 1-1.2 1.128c-.957.584-2.24.584-4.806.584c-2.57 0-3.855 0-4.814-.585a4 4 0 0 1-1.2-1.13c-.642-.922-.72-2.205-.874-4.77L4.5 5.5M3 5.5h18m-4.944 0l-.683-1.408c-.453-.936-.68-1.403-1.071-1.695a2 2 0 0 0-.275-.172C13.594 2 13.074 2 12.035 2c-1.066 0-1.599 0-2.04.234a2 2 0 0 0-.278.18c-.395.303-.616.788-1.058 1.757L8.053 5.5m1.447 11v-6m5 6v-6" color="#ed8d8d" />
                                    </svg>
                                </div>
                            <?php    }
                            ?>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>

        </div>
    </div>
    <style>
        .min-50p {
            min-width: 60%;
        }

        .truck-edit {
            flex: 1 1 30%
        }

        .truck-info {
            flex: 3 1 70%
        }
    </style>
</section>