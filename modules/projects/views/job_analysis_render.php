<div class="m8-block pt16 pb16">
    <?php
            echo '<h2 class="pb4">'.$query.'</h2>';
            echo '<h4 >Total of ' . $total_job_hours . ' hours</h4>';
            echo  '<p class="small-text"><i>' . $date_start . '  to ' . $date_end . '</i></p>';
            echo '<div class="m8-block">';
            foreach ($techs as $key => $value) {
                $percent = ($value / $total_job_hours) * 100;
                $css_width = (466 * $percent) / 100;
            ?>
    <h4><?= ucfirst($key) ?>: &nbsp;<span class="small-text orange-text"><?= $value ?> hrs</span></h4>
    <div class="hours-meter">
        <div class="percent-cover" style="width:<?= $css_width ?>px">
            <p><?= round($percent) ?>%</p>
        </div>
        <div class="dark-cover" style="width:<?= (466 - $css_width) ?>px">
        </div>
    </div>

    <?php
      }     
    ?>
</div>