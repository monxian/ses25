<section class="main-sec flex">
    <div class="container ">
        <div class="flex justify-center ">
            <?= flashdata() ?>
        </div>
        <div class="container-header pb8 flex align-center justify-between">
            <div>
                <h2><?= $heading ?></h2>
                <p><?= $item->name ?></p>
            </div>
        </div>
        <div class="img-sec">
            <img src="<?= $item->picture ?>" alt="product_image">
            <div class="img-form">
                <?php

                echo form_open($loc, array('enctype' => 'multipart/form-data'));

                echo '<div class="img-input">';
                $attributes['accept'] = 'image/*';
                echo form_file_select('picture', $attributes);
                echo '</div>';

                echo '<div class="form-btns">';
                echo form_submit('submit', 'Submit', array('class' => ''));
                echo '<a class="button btn-tertiary" href="' . $cancel . '">Back</a>';
                echo '</div>';

                echo form_close();
                ?>

            </div>
        </div>
    </div>
</section>

<style>
    .img-sec {
        width: 600px;
        height: 600px;
        border-radius: 1em;
        overflow: hidden;
        position: relative;
    }

    .img-sec img {
        display: block;
        width: 100%;

    }

    .img-form {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: hsl(0, 0%, 90%, .7);
        border: 1px solid var(--border);
        border-radius: 1em;
        width: max-content;
        padding: 1em;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .img-input {
        color: var(--color-surface-20);
    }
</style>

<!-- Link to the assets/js/custom.js -->
<script src="<?= BASE_URL ?>products-product_photos_module/js/custom.js"></script>