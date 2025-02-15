<section class="main-sec flex">
    <div class="container cont-sm">
        <div class="flex justify-center ">
            <?= flashdata() ?>
        </div>
        <div class="container-header pb8 flex align-center justify-between">
            <div>
                <h2><?= ucfirst($heading) ?></h2>
            </div>
            <div>
                <div>
                    <a class="button btn-primary-45 flex align-center" href="<?= $add_url  ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                <path d="M15 2.5V4c0 1.414 0 2.121.44 2.56C15.878 7 16.585 7 18 7h1.5" />
                                <path d="M4 16V8c0-2.828 0-4.243.879-5.121C5.757 2 7.172 2 10 2h4.172c.408 0 .613 0 .797.076c.183.076.328.22.617.51l3.828 3.828c.29.29.434.434.51.618c.076.183.076.388.076.796V16c0 2.828 0 4.243-.879 5.121C18.243 22 16.828 22 14 22h-4c-2.828 0-4.243 0-5.121-.879C4 20.243 4 18.828 4 16" />
                                <path d="M12 11v3m0 0v3m0-3H7.5m4.5 0h4.5m-7 3h5c.943 0 1.414 0 1.707-.293s.293-.764.293-1.707v-2c0-.943 0-1.414-.293-1.707S15.443 11 14.5 11h-5c-.943 0-1.414 0-1.707.293S7.5 12.057 7.5 13v2c0 .943 0 1.414.293 1.707S8.557 17 9.5 17" />
                            </g>
                        </svg>
                        <p class="pl4">Add</p>
                    </a>
                </div>
            </div>
        </div>

        <div>
            <div>
                <?php
                foreach ($items as $item) {
                    $table = $item_name == 'category_name' ? 'categories' : 'makers';
                ?>
                    <a href="products-properties/edit/<?= $table ?>/<?= $item->id ?>" class="round-sm border p8 m8 bg-secondary secondary-hover flex align-center justify-between text-white no-decoration">
                        <div>
                            <p> <?= $item->$item_name ?> </p>
                            <p class="small-text text-secondary">
                                <?php if ($item_name == 'maker_name') {
                                    echo 'phone: &nbsp;' . $item->support_number;
                                } ?>
                            </p>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                    <path d="m16.214 4.982l1.402-1.401a1.982 1.982 0 0 1 2.803 2.803l-1.401 1.402m-2.804-2.804l-5.234 5.234c-1.045 1.046-1.568 1.568-1.924 2.205S8.342 14.561 8 16c1.438-.342 2.942-.7 3.579-1.056s1.16-.879 2.205-1.924l5.234-5.234m-2.804-2.804l2.804 2.804" />
                                    <path d="M21 12c0 4.243 0 6.364-1.318 7.682S16.242 21 12 21s-6.364 0-7.682-1.318S3 16.242 3 12s0-6.364 1.318-7.682S7.758 3 12 3" />
                                </g>
                            </svg>
                        </div>
                    </a>

                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <script src="js/flashDismiss.js"></script>