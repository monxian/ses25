<?php
if (count($rows) <= 0) {
    echo '<div class="flex align-center justify-center  pt16">' . $search_msg . '<svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
	<g fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="white">
		<circle cx="12" cy="12" r="10" />
		<path d="M11 17.784c2.618.777 4.94-.634 6-2.784M7 9.01s1.41-.127 2.196.498m0 0l-.263.835c-.104.329.167.657.543.657c.396 0 .657-.357.453-.665a3.6 3.6 0 0 0-.733-.827M14 9.011s1.41-.128 2.196.497m0 0l-.263.835c-.104.329.167.657.543.657c.396 0 .657-.357.453-.665a3.6 3.6 0 0 0-.733-.827" />
	</g>
</svg>
            </div>';
} else {  
    $total_qty = 0;
    foreach ($found_items as $key => $items) { ?>

        <div class="bg-secondary m8-block p8 round-sm">
            <div>
                <div>
                    <h3><?= out($items[0]['name']) ?></h3>
                    <p class="text-secondary"><i><?= out($items[0]['part_number']) ?></i></p>
                    <div class="pt8">
                        <?php
                        foreach ($items as $item) {
                            $total_qty += $item['qty'];
                        ?>
                            <div>
                                <?= ucfirst(out($item['first_name'])) ?>
                                <span class="pl8"> <?= out($item['qty']) ?></span>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <p class="small-text p4 text-secondary"><i>Qty on techs trucks: <?= $total_qty ?></i></p>
            </div>
        </div>
<?php }
}
?>
<style>
    /* Link to the truck_inventories/assets/css/custom.css */
    @import url('<?= BASE_URL ?>truck_inventories_module/css/custom.css');
</style>