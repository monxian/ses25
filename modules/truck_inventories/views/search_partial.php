<?php
if (!$found) {
    echo '<div class="flex align-center justify-center  pt16">' . $search_msg . '<svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
                <g fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="white">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M11 17.784c2.618.777 4.94-.634 6-2.784M7 9.01s1.41-.127 2.196.498m0 0l-.263.835c-.104.329.167.657.543.657c.396 0 .657-.357.453-.665a3.6 3.6 0 0 0-.733-.827M14 9.011s1.41-.128 2.196.497m0 0l-.263.835c-.104.329.167.657.543.657c.396 0 .657-.357.453-.665a3.6 3.6 0 0 0-.733-.827" />
                </g>
            </svg>
        </div>';
} else {
    foreach ($rows as $item) {        
    ?>
        <div class="bg-secondary m8-block p8 round-sm" id="item-<?= out($item->id) ?>">
            <div>
                <div>
                    <h3><?= out($item->name) ?></h3>
                    <p class="text-secondary"><i><?= out($item->part_number) ?></i></p>
                    <?php if ($search_truck == true) {
                        echo '<div class="small-text ptb8 text-primary-85">Truck Qty: ' . out($item->truck_qty) . '</div>';
                    }
                    ?>
                </div>
            </div>
            <?php
            if ($search_truck != true) { ?>
                <div class="pt8 flex">
                    <div mx-post="truck_inventories/add_item/<?= out($item->id) ?>"
                         mx-target="this">
                        <div class="truck-add flex align-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                <g fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="white">
                                    <path d="M12 8v8m4-4H8" />
                                    <circle cx="12" cy="12" r="10" />
                                </g>
                            </svg>
                            <p>&nbsp;Add to inventory</p>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
<?php 
    }
}
?>
<style>
    /* Link to the truck_inventories/assets/css/custom.css */
    @import url('<?= BASE_URL ?>truck_inventories_module/css/custom.css');
</style>
