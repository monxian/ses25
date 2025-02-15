<h1><?= $headline ?></h1>
<?= validation_errors() ?>
<div class="card">
    <div class="card-heading">
        Product Details
    </div>
    <div class="card-body">
        <?php
        echo form_open($form_location);
        echo form_label('Name');
        echo form_input('name', $name, array("placeholder" => "Enter Name"));
        echo form_label('part number');
        echo form_input('part_number', $part_number, array("placeholder" => "Enter part number"));
        echo form_label('Description <span>(optional)</span>');
        echo form_textarea('description', $description, array("placeholder" => "Enter Description"));
        echo $categories;
        echo $makers;
        echo form_label('qty');
        echo form_number('qty', $qty, array("placeholder" => "Enter qty"));
        echo form_label('Price <span>(optional)</span>');
        echo form_input('price', $price, array("placeholder" => "Enter Price"));
        echo form_label('shelf location <span>(optional)</span>');
        echo form_input('shelf_location', $shelf_location, array("placeholder" => "Enter shelf location"));
       
        echo form_submit('submit', 'Submit');
        echo anchor($cancel_url, 'Cancel', array('class' => 'button alt'));
        echo form_close();
        ?>
    </div>
</div>