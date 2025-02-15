  <p class="text-primary pt4"><?= $notice ?></p>
  <?php
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