<section class="main-sec">
    <div class="container max-content">
        <div class="container-header pb8">
            <div class="flex align-center justify-between">
                <div>
                    <h2>Truck Assigments</h2>
                    <p>Edit Trucks, assign and un-assign</p>
                </div>
                <div class="flex align-center">

                    <div class="ml8">
                        <a href="trucks/edit" class="button btn-primary-45 flex align-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" color="currentColor">
                                    <path d="m16.214 4.982l1.402-1.401a1.982 1.982 0 0 1 2.803 2.803l-1.401 1.402m-2.804-2.804l-5.234 5.234c-1.045 1.046-1.568 1.568-1.924 2.205S8.342 14.561 8 16c1.438-.342 2.942-.7 3.579-1.056s1.16-.879 2.205-1.924l5.234-5.234m-2.804-2.804l2.804 2.804" />
                                    <path d="M21 12c0 4.243 0 6.364-1.318 7.682S16.242 21 12 21s-6.364 0-7.682-1.318S3 16.242 3 12s0-6.364 1.318-7.682S7.758 3 12 3" />
                                </g>
                            </svg>&nbsp;Trucks
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <div>
            <?php
            foreach ($techs as $tech) { ?>
                <div class="bg-secondary w-320 m8 p8 round-sm">
                    <div>
                        <h3><?= ucfirst($tech->first_name) ?></h3>
                    </div>

                <?php
                echo '<div><div class="p4">';
                if ($tech->assigned) {
                    echo '<div><span class="small-text text-secondary">Make: </span>&nbsp;' . $tech->make . '</div>';
                    echo '<div><span class="small-text text-secondary">plate: </span>&nbsp;' . $tech->plate_number . '</div>';
                    echo '<div><span class="small-text text-secondary">VIN: </span>&nbsp;' . $tech->vin . '</div>';
                    $attributes['class'] = 'button btn-danger';
                    echo '<div class="mt16 mb8">';
                    echo anchor('trucks/truck_un_assign/' . $tech->truck_id, 'Un-Assign Truck', $attributes);
                    echo '</div>';
                } else {
                    echo '<div class="mt16 mb8">';
                    $attributes['class'] = 'button btn-primary-45';
                    echo anchor('trucks/assign/' . $tech->tech_id, 'Assign Truck', $attributes);
                    echo '</div>';
                }
                echo '</div></div></div>';
            }
                ?>

                </div>
        </div>
</section>
