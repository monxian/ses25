<section class="part-div p16 m8 maxw-1054">
    <div class="mr-heading flex align-center justify-center">
        <div class="text-center">
            <h2>Material Requisition</h2>
        </div>
    </div>
    <div class="form-info">
        <p>Project Name: <i><?= ucfirst($project->project_name) ?></i></p>
        <p>Technician: <i><?= ucfirst($request_form[0]->first_name) ?></i></p>
    </div>
    <section>
        <table class="request-table">
            <tr>
                <th class="print-hide">Status</th>
                <th class="print-hide">Pulled</th>
                <th>Date</th>
                <th>Manufacturer</th>
                <th>Part Number</th>
                <th>Quantity</th>
                <th>Description</th>
            </tr>

            <?php
            $count = 0;
            foreach ($products as $row) { ?>
                <tr>
                    <td class="print-hide">
                        <div class="pull-action">
                            <a mx-target="#fulfill-<?= $row->id ?>" mx-post="truck_inventories-requests/fulfill_item/<?= $row->id ?>/<?= $request_form[0]->id ?>">
                                <?php if (!$row->pulled) { ?>
                                    <span id="fulfill-<?= $row->id ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                            <g fill="none" stroke="#df2020" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="#df2020">
                                                <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2S2 6.477 2 12s4.477 10 10 10" />
                                                <path d="M12.008 10.508a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3m0 0V7m3.007 8.02l-1.949-1.948" />
                                            </g>
                                        </svg>
                                    </span>
                                <?php } else {  ?>
                                    <span id="fulfill-<?= $row->id ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                            <g fill="none" stroke="#00e600" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="#00e600">
                                                <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12s4.477 10 10 10s10-4.477 10-10" />
                                                <path d="m8 12.5l2.5 2.5L16 9" />
                                            </g>
                                        </svg>
                                    </span>
                                <?php } ?>
                            </a>
                        </div>
                    </td>
                    <td>
                        <div class="flex align-center justify-between">
                            <div
                                class="pointer btn-color"
                                mx-put="truck_inventories-requests/update_pull/sub/<?= $row->id ?>/<?= $request_form[0]->id ?>"
                                mx-select-oob="#server-content:#pulled-<?= $row->id ?>, #server-status:#fulfill-<?= $row->id ?>"
                                mx-trigger="click"
                                mx-swap="none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.5 12c0-4.478 0-6.718 1.391-8.109S7.521 2.5 12 2.5c4.478 0 6.718 0 8.109 1.391S21.5 7.521 21.5 12c0 4.478 0 6.718-1.391 8.109S16.479 21.5 12 21.5c-4.478 0-6.718 0-8.109-1.391S2.5 16.479 2.5 12M16 12H8" color="currentColor" />
                                </svg>
                            </div>
                            <div class="text-black" id="pulled-<?= $row->id ?>">
                                <?php echo out($row->pulled_qty); ?>
                            </div>
                            <div
                                class="pointer btn-color"
                                mx-put="truck_inventories-requests/update_pull/add/<?= $row->id ?>/<?= $request_form[0]->id ?>"
                                mx-select-oob="#server-content:#pulled-<?= $row->id ?>, #server-status:#fulfill-<?= $row->id ?>"
                                mx-trigger="click"
                                mx-swap="none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v8m4-4H8m-5.5 0c0-4.478 0-6.718 1.391-8.109S7.521 2.5 12 2.5c4.478 0 6.718 0 8.109 1.391S21.5 7.521 21.5 12c0 4.478 0 6.718-1.391 8.109S16.479 21.5 12 21.5c-4.478 0-6.718 0-8.109-1.391S2.5 16.479 2.5 12" color="currentColor" />
                                </svg>
                            </div>
                        </div>
                    </td>
                    <td><?= date('M d, Y', $request_form[0]->request_date) ?></td>
                    <td><?= out($row->maker_name) ?></td>
                    <td>
                        <?php if ($row->part_number) {
                            echo out($row->part_number);
                        } else {
                            echo out($row->custom_num);
                        }
                        ?>
                    </td>
                    <td><?= out($row->qty) ?></td>
                    <td> <?php if ($row->description) {
                                    echo out($row->description);
                                } else {
                                    echo out($row->custom_name);
                                }
                            ?>
                    </td>
                </tr>

            <?php
            }
            ?>
        </table>
    </section>
    <section class="request-purpose">
        <div class="pt8 pb8"><b>Purpose Of Use: </b></div>
        <div>
            <?php
            $truck_stock = $request_form[0]->truck_stock == 1 ? true : false;
            $checked = '<svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                    <path d="M2.5 12c0-4.478 0-6.718 1.391-8.109S7.521 2.5 12 2.5c4.478 0 6.718 0 8.109 1.391S21.5 7.521 21.5 12c0 4.478 0 6.718-1.391 8.109S16.479 21.5 12 21.5c-4.478 0-6.718 0-8.109-1.391S2.5 16.479 2.5 12" />
                                    <path d="M8 13.75s1.6.912 2.4 2.25c0 0 2.4-5.25 5.6-7" />
                                </g>
                            </svg>';
            $unchecked = '<svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.5 12c0-4.478 0-6.718 1.391-8.109S7.521 2.5 12 2.5c4.478 0 6.718 0 8.109 1.391S21.5 7.521 21.5 12c0 4.478 0 6.718-1.391 8.109S16.479 21.5 12 21.5c-4.478 0-6.718 0-8.109-1.391S2.5 16.479 2.5 12" color="currentColor" />
                            </svg>';
            ?>
            <div class="flex align-center">
                <?php if ($truck_stock) {
                    echo $checked;
                } else {
                    echo $unchecked;
                } ?> &nbsp; Truck Stock
            </div>
            <div class="flex align-center">
                <?php if (!$truck_stock) {
                    echo $checked;
                } else {
                    echo $unchecked;
                } ?>&nbsp; Project
            </div>
        </div>
    </section>
    <section class="note-section">
        <div class="pt8 pb16">Project Notes / Location of device(s)</div>
        <div class="notes">
            <?= nl2br($request_form->notes) ?>
        </div>


    </section>
    <section class="pt8 pb8">
        <table class="pd-table">
            <th colspan="2">
                To be filled in by purchasing department
            </th>
            <tr>
                <td>Date Ordered:</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>PO Number:</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Supplier:</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Approved:</td>
                <td>&nbsp;</td>
            </tr>

        </table>
    </section>
</section>
<style>
    /* Link to the truck_inventories/assets/css/custom.css */
    @import url('<?= BASE_URL ?>truck_inventories-requests_module/css/custom.css');

    .maxw-1054 {
        max-width: 1054px;
    }

    .request-add {
        color: var(--color-primary-45);
        cursor: pointer;
    }

    .request-add:hover {
        color: var(--color-primary-35);
    }

    .pull-action {
        padding-top: 4px;
        border-radius: 5px;

    }

    .pull-action:hover {
        background-color: var(--color-surface-90);
    }

    .btn-color {
        color: #78909C;
    }

    .btn-color:hover {
        color: #5A9BD5;
    }
</style>
<div style="color: white">
    <?php json($products); ?>
</div>