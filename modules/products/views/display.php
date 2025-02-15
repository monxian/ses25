<section class="main-sec flex">
    <div class="container cont-sm">
        <div class="flex justify-center ">
            <?= flashdata() ?>
        </div>
        <div class="container-header pb8 flex align-center justify-between">
            <div>
                <h2><?= $heading ?></h2>
                <p class="small-text text-secondary">Add, Delete and Edit products here</p>
            </div>
            <div class="round-sm bg-primary anchor-hover color-white p8 flex align-center pointer"
                mx-post="products/gen_excel"
                mx-build-modal='{
                        "id":"excel-modal",
                        "padding":"1em"                                           
                         }'>

                <svg xmlns=" http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                        <path d="M15 2.5V4c0 1.414 0 2.121.44 2.56C15.878 7 16.585 7 18 7h1.5" />
                        <path d="M4 16V8c0-2.828 0-4.243.879-5.121C5.757 2 7.172 2 10 2h4.172c.408 0 .613 0 .797.076c.183.076.328.22.617.51l3.828 3.828c.29.29.434.434.51.618c.076.183.076.388.076.796V16c0 2.828 0 4.243-.879 5.121C18.243 22 16.828 22 14 22h-4c-2.828 0-4.243 0-5.121-.879C4 20.243 4 18.828 4 16" />
                        <path d="M12 11v3m0 0v3m0-3H7.5m4.5 0h4.5m-7 3h5c.943 0 1.414 0 1.707-.293s.293-.764.293-1.707v-2c0-.943 0-1.414-.293-1.707S15.443 11 14.5 11h-5c-.943 0-1.414 0-1.707.293S7.5 12.057 7.5 13v2c0 .943 0 1.414.293 1.707S8.557 17 9.5 17" />
                    </g>
                </svg>
                <p class="pl4">Excel</p>
            </div>
        </div>

        <div>
            <div>
                <p><i><?= $page_info ?></i></p>
                <?php

                echo '<div id="product-list">';
                echo '<div>' . $page . '</div>';
                foreach ($products as $row) {
                ?>
                    <div class="round-sm border p8 m8 bg-secondary secondary-hover"
                        mx-post="products/show_item/<?= $row->id ?>"
                        mx-target="#show-prod">
                        <p> <?= $row->name ?> </p>
                        <p class="small-text text-secondary"><?= $row->part_number ?></p>
                    </div>

                <?php
                }
                ?>
            </div>
        </div>
    </div>
    </div>
    <div class="container ml16 w-600">
        <div class="flex align-center justify-between gap-1">
            <div>
                <a class="button btn-primary-45 flex-inline" href="products/add">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v8m4-4H8m14 0c0-5.523-4.477-10-10-10S2 6.477 2 12s4.477 10 10 10s10-4.477 10-10" color="currentColor" />
                    </svg>&nbsp;Add
                </a>
            </div>
            <div>
                <a class="button btn-primary-45 flex-inline" href="products/cat_make/search">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.5 17.5L22 22m-2-11a9 9 0 1 0-18 0a9 9 0 0 0 18 0" color="currentColor" />
                    </svg>&nbsp;
                    Search
                </a>
            </div>
            <div>
                <a class="button btn-primary-45 flex-inline" href="products-properties/display/categories">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5h12M3 5h2m4 7h12M3 12h2m4 7h12M3 19h2" color="currentColor" />
                    </svg>&nbsp;
                    Categories
                </a>
            </div>
            <div>
                <a class="button btn-primary-45 flex-inline" href="products-properties/display/makers">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                            <path d="M20.358 13.357c-1.19 1.189-3.427 1.143-6.859 1.143a4 4 0 0 1-3.999-4c0-3.43-.046-5.67 1.143-6.859s1.715-1.14 6.984-1.14a.57.57 0 0 1 .406.973L15.32 6.187a1.763 1.763 0 1 0 2.492 2.494l2.714-2.712a.57.57 0 0 1 .974.405c0 5.268.048 5.794-1.142 6.983" />
                            <path d="m13.5 14.5l-6.172 6.172a2.829 2.829 0 0 1-4-4L9.5 10.5m-3.991 8H5.5" />
                        </g>
                    </svg>&nbsp;
                    Makers
                </a>
            </div>
        </div>
        <div id="show-prod" class="p16">
            <div class="m8 prod-desc">
                <h2><?= $products[0]->name ?></h2>
                <h3 class="text-secondary"><?= $products[0]->part_number ?></h3>
            </div>
            <div class="image-section">
                <?php
                if ($products[0]->picture) {
                    echo '<img src="products_module/products_pics/' . $products[0]->id . '/' . $products[0]->picture . '">';
                } else {
                    echo '<img src="imgs/placeholder.jpg">';
                }
                ?>
            </div>
            <div class="m4 p4">
                <p class="m8-block"><span class="text-secondary">Qty:</span> <?= $products[0]->qty ?></p>
                <p class="m8-block"><span class="text-secondary">Price:</span> $ <?= $products[0]->price ?></p>
                <?php
                $truck_stock = $products[0]->truck_stock ? "Yes" : "No";
                ?>
                <p class="m8-block"><span class="text-secondary">Truck Stock:</span> <?= $truck_stock ?></p>
            </div>
            <div class="flex align-center justify-between">
                <div>
                    <a class="button btn-primary-45 flex align-center" href="products/add/<?= $products[0]->id ?>">
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
                    <a class="button btn-primary-45 flex align-center" href="products-product_photos/display/<?= $products[0]->id ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                <circle cx="7.5" cy="7.5" r="1.5" />
                                <path d="M2.5 12c0-4.478 0-6.718 1.391-8.109S7.521 2.5 12 2.5c4.478 0 6.718 0 8.109 1.391S21.5 7.521 21.5 12c0 4.478 0 6.718-1.391 8.109S16.479 21.5 12 21.5c-4.478 0-6.718 0-8.109-1.391S2.5 16.479 2.5 12" />
                                <path d="M5 21c4.372-5.225 9.274-12.116 16.498-7.458" />
                            </g>
                        </svg>
                        <p class="pl4">Update Photo</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .active {
        background-color: var(--color-primary-45);
    }

    .image-section {
        width: 425px;
        height: 425px;
        margin: 0 auto;
        background: white;
        border-radius: 1em;
        border: 1px solid white;
        overflow: hidden;
    }

    .image-section img {
        width: 100%;
        height: auto;
    }

    .prod-desc {
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-height: 80px;
    }

    .inline-block {
        display: inline-block;
    }
    .dl-close{
       position: absolute;
       top: 10px;
       right: 10px;
    }
</style>
<script src="js/flashDismiss.js"></script>