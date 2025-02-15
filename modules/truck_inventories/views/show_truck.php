<section class="main-sec">
    <div class="container cont-sm">
        <div>
            <?= flashdata(); ?>
        </div>
        <div class="container-header pb8 flex align-center justify-between">
            <div>
                <h2>Showing Inventory</h2>
                <p class="small-text text-secondary">Adjust Qty by clicking on a part.</p>
            </div>
            <?php
            if (!$from_close) { ?>
                <div class="slide-radio">
                    <input type="radio" id="option1" name="slider" value="Option 1" checked
                        mx-post="truck_inventories/show_inven/<?= $truck_id ?>/actual"
                        mx-trigger="change"
                        mx-target="#inventory-results" />
                    <label for="option1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 6h10m-10 6h10m-10 6h10M3 7.393S4 8.045 4.5 9C4.5 9 6 5.25 8 4M3 18.393S4 19.045 4.5 20c0 0 1.5-3.75 3.5-5" color="currentColor" />
                        </svg>
                    </label>
                    <input type="radio" id="option2" name="slider" value="Option 2"
                        mx-post="truck_inventories/show_inven/<?= $truck_id ?>/all"
                        mx-trigger="change"
                        mx-target="#inventory-results" />
                    <label for="option2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 5h12M4 5h.009M4 12h.009M4 19h.009M8 12h12M8 19h12" color="currentColor" />
                        </svg>
                    </label>

                    <span class="slider"></span>
                </div>

            <?php  } else {
                echo '<a class="button btn-secondary" href="jobs/day_view">Next >></a>';
            } ?>

        </div>
        <div id="inventory-results">          
            <?php
            if(!$from_close){
                 echo '<p class="text-primary pt4">What\'s actually on your truck.</p>';
            } else {
                echo '<p class="text-primary pt4">Did you use any parts from your truck?</p>';
            }
            foreach ($organizedData as $makerName => $products) {
                echo '<br><div><h3>' . $makerName . '</h3></div>';
                foreach ($products as $item) {
                    $alert = ($item->truck_qty <= $item->low_level) ? '' : 'hide';

            ?>
                    <div class="bg-secondary round-sm p8 m8-block"
                        mx-post="truck_inventories/show_modal/<?= out($item->truck_inv_id) ?>"
                        mx-build-modal='{
                        "id":"show-element-<?= out($item->id) ?>"
                    }'>
                        <div class="small-text text-secondary"> <?= out($item->product_name) ?></div>
                        <div> <?= out($item->part_number) ?></div>
                        <div class="small-text text-secondary"> <?= out($item->name) ?></div>
                        <div class="flex align-center justify-between">
                            <div class="small-text pt8 text-primary-85" id="show-truck-qty-<?= $item->id ?>">Truck Qty: <?= out($item->truck_qty) ?></div>

                            <div class="flex align-center small-text text-danger <?= $alert ?>" id="low-level-<?= $item->id ?>" data-ll="<?= $item->truck_level ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                        <path d="M5.322 9.683c2.413-4.271 3.62-6.406 5.276-6.956a4.45 4.45 0 0 1 2.804 0c1.656.55 2.863 2.685 5.276 6.956c2.414 4.27 3.62 6.406 3.259 8.146c-.2.958-.69 1.826-1.402 2.48C19.241 21.5 16.827 21.5 12 21.5s-7.241 0-8.535-1.19a4.66 4.66 0 0 1-1.402-2.48c-.362-1.74.845-3.876 3.259-8.147" />
                                        <path d="M12.242 17v-4c0-.471 0-.707-.146-.854c-.147-.146-.382-.146-.854-.146m.75-3h.009" />
                                    </g>
                                </svg>&nbsp; qty low
                            </div>

                        </div>
                    </div>

                <?php } ?>
            <?php } ?>
        </div>
    </div>



</section>
<style>
    /* Link to the truck_inventories/assets/css/custom.css */
    @import url('<?= BASE_URL ?>truck_inventories_module/css/custom.css');

    /* Basic Styles */
    .slide-radio {
        position: relative;
        display: flex;
        width: 100px;
        height: 30px;
        background-color: #f0f0f0;
        border-radius: 20px;
        overflow: hidden;
        justify-content: space-between;
        align-items: center;
    }

    /* Hide Radio Buttons */
    .slide-radio input[type="radio"] {
        display: none;
    }

    /* Labels */
    .slide-radio label {
        flex: 1;
        text-align: center;
        z-index: 2;
        font-size: 16px;
        cursor: pointer;
        color: #333;
        padding: 10px;
    }

    /* Slider */
    .slide-radio .slider {
        position: absolute;
        top: 0;
        left: 0;
        width: 50%;
        height: 100%;
        background-color: var(--color-primary-45);
        border-radius: 20px;
        transition: 0.3s ease;
        z-index: 1;
    }

    .slide-radio input[type="radio"]:checked:nth-of-type(1)~.slider {
        transform: translateX(0%);
    }

    .slide-radio input[type="radio"]:checked:nth-of-type(2)~.slider {
        transform: translateX(100%);
    }
</style>
<script src="<?= BASE_URL ?>truck_inventories_module/js/custom.js"></script>