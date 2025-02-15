<div>
    <div class="m8 prod-desc">
        <h2><?= $item->name ?></h2>
        <h3 class="text-secondary"><?= $item->part_number ?></h3>

    </div>

    <div class="image-section">
        <?php
        if ($item->picture) {
            echo '<img src="products_module/products_pics/' . $item->id . '/' . $item->picture . '">';
        } else {
            echo '<img src="imgs/placeholder.jpg">';
        }
        ?>
    </div>
    <div class="m4 p4">
        <p class="m8-block"><span class="text-secondary">Qty: </span> <?= $item->qty ?></p>
        <p class="m8-block"><span class="text-secondary">Price:</span> $ <?= $item->price ?></p>
        <?php
        $truck_stock = $item->truck_stock ? "Yes" : "No";
        ?>
        <p><span class="text-secondary">On Trucks:</span> <?= $truck_stock ?></p>
    </div>
    <div class="flex align-center justify-between">
        <div>
            <a class="button btn-primary-45 flex align-center" href="products/add/<?= $item->id ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                        <path d="m16.214 4.982l1.402-1.401a1.982 1.982 0 0 1 2.803 2.803l-1.401 1.402m-2.804-2.804l-5.234 5.234c-1.045 1.046-1.568 1.568-1.924 2.205S8.342 14.561 8 16c1.438-.342 2.942-.7 3.579-1.056s1.16-.879 2.205-1.924l5.234-5.234m-2.804-2.804l2.804 2.804" />
                        <path d="M21 12c0 4.243 0 6.364-1.318 7.682S16.242 21 12 21s-6.364 0-7.682-1.318S3 16.242 3 12s0-6.364 1.318-7.682S7.758 3 12 3" />
                    </g>
                </svg>
                <p class="pl4">Update Info</p>
            </a>
        </div>
        <div>
            <a class="button btn-primary-45 flex align-center" href="products-product_photos/display/<?= $item->id ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                        <path d="m16.214 4.982l1.402-1.401a1.982 1.982 0 0 1 2.803 2.803l-1.401 1.402m-2.804-2.804l-5.234 5.234c-1.045 1.046-1.568 1.568-1.924 2.205S8.342 14.561 8 16c1.438-.342 2.942-.7 3.579-1.056s1.16-.879 2.205-1.924l5.234-5.234m-2.804-2.804l2.804 2.804" />
                        <path d="M21 12c0 4.243 0 6.364-1.318 7.682S16.242 21 12 21s-6.364 0-7.682-1.318S3 16.242 3 12s0-6.364 1.318-7.682S7.758 3 12 3" />
                    </g>
                </svg>
                <p class="pl4">Update Photo</p>
            </a>
        </div>
    </div>
</div>