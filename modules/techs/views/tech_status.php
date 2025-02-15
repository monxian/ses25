<section class="main-sec">
    <div class="container cont-sm">
        <div class="container-header pb8">
            <h2>Tech Status</h2>
            <p><?= ucfirst(out($jobs[0]->first_name)) ?></p>
            <p class="small-text text-secondary"> <?= date('M j, Y') ?></p>
        </div>
        <div>
           <?php 
            if(empty($jobs)){
                echo '<p class="text-primary-85 p8 max-content">No actions yet.</p>';
            } else {   
            
            foreach ($jobs as $item) {
                $open = $item->time_out == 'x' ? true : false;
                $etc_set = $item->duration != NULL ? true : false;
            ?>
                <div class="p8 m8-block bg-secondary round-sm ">
                    <?php
                    echo '<div class="flex align-center justify-between">' . html_entity_decode(out($item->job_name), ENT_QUOTES, 'UTF-8');
                    echo $open;
                    if (!$open) {
                        echo '<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                 <g fill="none" stroke="#38f088" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="#38f088">
                                 <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12s4.477 10 10 10s10-4.477 10-10" />
                                 <path d="M8 12.75s1.6.912 2.4 2.25c0 0 2.4-5.25 5.6-7" />
                                 </g>
                               </svg></div>';
                    } else {
                        echo '<div class="bg-secondary p4 round-sm">Open</div>';
                        if ($etc_set) {
                            echo '</div><div class="flex flex-col p4 mt8 bg-secondary round-sm"><div class="p8">ETC:&nbsp; <span class="time-conv large-text">' . out($item->duration) . '</span></div>';
                            echo '<div class="pi-8"><i>' . out($item->reason) . '</i></div></div>';
                        }
                    } ?>

                </div>
            <?php } }?>
        </div>

    </div>
</section>
<script src="js/timeConv.js"></script>