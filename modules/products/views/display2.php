 <?php
   echo '<div>' . $page . '</div>';
  foreach ($products as $row) {  ?>
        <div class="round-sm border p8 m8 bg-secondary secondary-hover"
            mx-post="products/show_item/<?= $row->id ?>"
            mx-target="#show-prod">
            <p> <?= $row->name ?> </p>
            <p class="small-text text-secondary"><?= $row->part_number ?></p>
        </div>
 <?php
      }
  ?>