<section class="main-sec">
    <div class="container tech-truck-printout">
        <div class="container-header pb8">
            <h2><?= ucfirst(out($tech_name)) ?>'s Inventory</h2>
        </div>
        <?php
       
        foreach ($organizedData as $makerName => $products) {
            echo '<div class="bg-primary p4 row-title"><h3>' . $makerName . '</h3></div><table class="tech-truck-table bg-white p8">';
            foreach ($products as $item) {
                $alert = ($item->truck_qty <= $item->truck_level) ? '' : 'hide';
             
        ?>

                <tr class="<?= $break ?>">
                    <td class="small-text col-1"><?= out($item->truck_qty) ?></td>
                    <td class="small-text text-danger centered-cell col-2">
                        <svg class="<?= $alert ?>" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                <path d="M5.322 9.683c2.413-4.271 3.62-6.406 5.276-6.956a4.45 4.45 0 0 1 2.804 0c1.656.55 2.863 2.685 5.276 6.956c2.414 4.27 3.62 6.406 3.259 8.146c-.2.958-.69 1.826-1.402 2.48C19.241 21.5 16.827 21.5 12 21.5s-7.241 0-8.535-1.19a4.66 4.66 0 0 1-1.402-2.48c-.362-1.74.845-3.876 3.259-8.147"></path>
                                <path d="M12.242 17v-4c0-.471 0-.707-.146-.854c-.147-.146-.382-.146-.854-.146m.75-3h.009"></path>
                            </g>
                        </svg>
                    </td>
                    <td class="centered-cell col-3"><?= out($item->part_number) ?></td>
                    <td class="small-text centered-cell col-4"><?= out($item->name) ?></td>
                </tr>


            <?php 
            } ?>
            </table>
        <?php 
        } ?>

    </div>
</section>
<style>
    /* Link to the truck_inventories/assets/css/custom.css */
    @import url('<?= BASE_URL ?>truck_inventories_module/css/custom.css');

    .tech-truck-printout {
        max-width: 8.5in;
    }

    .tech-truck-table {
        width: 100%;
    }

    .centered-cell {
        text-align: center;
        vertical-align: middle;
    }

    table {
        width: 100%;
        /* Make the table take the full width */
        border-collapse: collapse;
        /* Remove gaps between borders */
    }

    td {
        border: 1px solid #d3d3d3;
        /* Light gray border */
        padding: 8px;
        /* Add some padding for spacing */
        text-align: center;
        /* Center text horizontally */
        vertical-align: middle;
        /* Center content vertically */
    }

    .col-1 {
        width: 15%;
        /* Each of the first two columns takes 15% of the width */
    }


    .col-2 {
        width: 5%;
        /* Each of the first two columns takes 15% of the width */
    }

    .col-3,
    .col-4 {
        width: 40%;
        /* Third column takes 10% of the width */
    }

  

    @media print {
        body{
            background-color: white;
        }
        .header-mobile {
            display: none;
        }

        main {
            background: #fff;
        }

        .tech-truck-printout {
            background-color: #fff;
            color: #000;
            border: none;
        }

        .row-title {
            background-color: var(--color-primary-85);
        }

      

    }
</style>
<script src="<?= BASE_URL ?>truck_inventories_module/js/custom.js"></script>