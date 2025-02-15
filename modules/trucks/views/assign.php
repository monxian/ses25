<section class="main-sec">
    <div class="container max-1034">
        <div class="container-header pb8">
            <div class="flex align-center justify-between">
                <div>
                  <?= $header ?>
                </div>
            </div>
            <div>
                <?php
                if($trucks){          
                    foreach ($trucks as $truck) { ?>
                        <div class="p8 bg-secondary w-320 round-sm m8 hover-secondary">
                            <a href="trucks/submit_assign/<?= $tech_id ?>/<?= $truck->id?>" class="no-decoration text-white ">
                                <div>Make: <?= $truck->make ?></div>
                                <div>Plate: <?= $truck->plate_number ?></div>
                                <div>VIN: <?= $truck->vin ?></div>
                            </a>
                        </div>

                    <?php
                    }
                } 
                ?>
            </div>
        </div>

</section>