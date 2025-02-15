  <?php
    foreach ($products as $row) { ?>
      <tr>
          <td class="print-hide">
              <a href="truck_inventories-requests/delete/<?= $row->id ?>/<?= $request_form->id ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                      <path fill="none" stroke="#df2020" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 12H8m-5.5 0c0-4.478 0-6.718 1.391-8.109S7.521 2.5 12 2.5c4.478 0 6.718 0 8.109 1.391S21.5 7.521 21.5 12c0 4.478 0 6.718-1.391 8.109S16.479 21.5 12 21.5c-4.478 0-6.718 0-8.109-1.391S2.5 16.479 2.5 12" color="#df2020" />
                  </svg>
              </a>
          </td>
          <td><?= out($row->qty) ?></td>
          <td>
              <?= out($row->name) ?>
              <?= out($row->part_number) ?>
          </td>
      </tr>

  <?php
    }
    ?>