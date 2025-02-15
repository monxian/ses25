<section class="main-sec">
    <div class="container max-content">
        <div class="container-header  pb8">
            <h2>Tech Status</h2>
            <p><?= ucfirst(out($jobs[0]->first_name)) ?></p>
            <p class="small-text text-secondary"> <?= date('M j, Y') ?></p>
        </div>
        <div class="flex gap-1 flex-wrap">
            <?php
            foreach ($tech_jobs as $worker_name => $jobs) {
            ?>
                <div class="round-sm border p8 w-320 align-self-start">
                    <h2><?= ucfirst($worker_name) ?></h2>
                    <?php
                    if (empty($jobs)) {
                        echo '<div class="mt8"><p class="text-primary-85 round-sm p8 max-content">No actions yet.</p></div>';
                    } else {
                        foreach ($jobs as $item) {
                            $status = $item->enroute == 1 ? 'En Route' : 'On Site';
                            $etc_msg = $status == 'En Route' ? 'Arrival Time: ' : 'Estimated Completion Time: ';
                            $open = $item->time_out == 'x' ? true : false;
                            $etc_set = $item->duration != NULL ? true : false;
                    ?>
                            <div class="p8 m8-block bg-secondary round-sm ">
                                <?php
                                echo '<div class="flex flex-wrap align-center justify-between"><div>' . html_entity_decode(out($item->job_name), ENT_QUOTES, 'UTF-8').'</div>';
                                if (!$open) {
                                    echo '<p class="small-text" style="color:#86c66c">Completed @ <span class="time-conv">'.$item->time_out.'</span></p>';                                  
                                    echo '</div>';
                                } else {
                                    echo '<div class="bg-ternary p4 round-sm alert-border small-text">' . $status . '</div></div>';
                                    if ($etc_set) {
                                        echo '<div class="flex flex-col p4 mt8 bg-ternary round-sm"><div class="p8"><span class="small-text">' . $etc_msg . '</span>';
                                        echo '<span class="time-conv text-danger ">' . out($item->duration) . '</span></div>';
                                        echo '<div class="pi-8"><i>' . out($item->reason) . '</i></div></div>';
                                    }
                                } ?>
                            </div>
                <?php }
                    }
                    echo '</div>';
                } ?>
                </div>
        </div>
</section>
<script src="js/timeConv.js"></script>