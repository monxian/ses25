<div class="timesheet__wrap <?= $not_first_week; ?>">
    <div class="timesheet__heading">
        <h2>Specialty Electronics Systems, Inc.</h2>
    </div>
    <div class="timesheet__sub-heading">
        <h4>Weekly Time Sheet</h4>
    </div>
    <div class="timesheet__profile">
        <div>Name: <?= $tech_name ?></div>
        <?php                     
            if($on_call){
                echo '<div class="ts-oncall"> ON CALL </div>';
            }
        ?>
        <div>Week Ending: <?= $eow ?></div>
    </div>
    <div class="timesheet__date-times">
        <div class="ts__w-10">Date</div>
        <div class="ts__w-10">Day</div>
        <div class="ts__w-5">Code</div>
        <div class="ts__w-35">Job Description</div>
        <div class="ts__w-10">Time In</div>
        <div class="ts__w-10">Lunch</div>
        <div class="ts__w-10">Time Out</div>
        <div class="ts__w-10">Total Hours</div>
    </div>
    <div class="ts__day-row-wrapper">
        <?php
        $days = [$Sunday, $Monday, $Tuesday, $Wednesday, $Thursday, $Friday, $Saturday];
        $count = 0;
        $vacation_hrs = 0;
        foreach ($days as $day_name) {
            $any_jobs = $day_name['job_count'] > 0 ? true : false;
        ?>
            <div class="ts__day-row">
                <div class="dr__date ts__w-10 br-left">
                    <div><?= date('n/d/Y', strtotime($week_dates[$count])) ?></div>
                </div>
                <div class="dr__day ts-flex-col ts__w-10 br-left">
                    <div><?= date('l', strtotime($week_dates[$count])) ?></div>
                    <?php if ($any_jobs) {
                        echo '<div class="dr__total-hrs">' . $day_name['day_total_hours'] . '</div>';
                    } ?>
                </div>
                <div class="dr__job-container">
                    <?php if (!$any_jobs) { ?>
                        <div class="dr__job-row ts-flex
                        ">
                            <div class="ts__w-5 br-left">&nbsp;</div>
                            <div class="ts__w-35 br-left">&nbsp;</div>
                            <div class="ts__w-10 br-left">&nbsp;</div>
                            <div class="ts__w-10 br-left">&nbsp;</div>
                            <div class="ts__w-10 br-left">&nbsp;</div>
                            <div class="ts__w-10">&nbsp;</div>
                        </div>
                        <div class="dr__job-row ts-flex
                        ">
                            <div class="ts__w-5 br-left">&nbsp;</div>
                            <div class="ts__w-35 br-left">&nbsp;</div>
                            <div class="ts__w-10 br-left">&nbsp;</div>
                            <div class="ts__w-10 br-left">&nbsp;</div>
                            <div class="ts__w-10 br-left">&nbsp;</div>
                            <div class="ts__w-10">&nbsp;</div>
                        </div>
                        <?php } else {                      
                        $lunch = $day_name['day_total_hours'] <= 5.5 ? false : true;
                        //add lunch if over 6 hours
                        if ($lunch) {
                            echo '<div class="dr__job-row ts-flex">
                                    <div class="ts__w-5 br-left">&nbsp;</div>
                                    <div class="ts__w-35 br-left">LUNCH</div>
                                    <div class="ts__w-10 br-left">&nbsp;</div>
                                    <div class="ts__w-10 br-left">0.50</div>
                                    <div class="ts__w-10 br-left">&nbsp;</div>
                                    <div class="ts__w-10 minus-alert">-.50</div>
                                  </div>';
                        }
                        // add jobs loop through array of jobs   
                        $job_count = $day_name['job_count'];
                        for ($i = 0; $i < $job_count; $i++) {
                            $non_work_codes = ['801', '901', '902', '903'];
                            $cost_code = $day_name[$i]->code;
                            if(in_array($cost_code, $non_work_codes)){
                                $time_block = '<div class="ts__w-10 br-left">&nbsp;</div>
                                               <div class="ts__w-10 br-left">&nbsp;</div>
                                               <div class="ts__w-10 br-left">&nbsp;</div>';
                            } else {
                             
                                $time_block = '<div class="ts__w-10 br-left time-conv">' . $day_name[$i]->time_in . '</div>
                                               <div class="ts__w-10 br-left">&nbsp;</div>
                                               <div class="ts__w-10 br-left  time-conv">' . $day_name[$i]->time_out . '</div>';
                            }
                            ?>
                            <div class="dr__job-row ts-flex
                            ">
                                <div class="ts__w-5 br-left"><?= $day_name[$i]->code ?></div>
                                <?php $tech_id = $admin_access ? $data_name[$i]->member_id : ""?>
                                <div class="ts__job-links ts__w-35 br-left"><a href="<?= BASE_URL ?>jobs/edit/<?= $day_name[$i]->job_code ?>/<?= $tech_id ?>"><?= $day_name[$i]->job_name ?></a></div>
                                <?= $time_block ?>
                                <div class="ts__w-10"><?= $day_name[$i]->job_hours ?></div>
                            </div>

                        <?php
                            if ($day_name[$i]->code == '801' || $day_name[$i]->code == '903') {
                                $vacation_hrs = ($vacation_hrs + $day_name[$i]->job_hours) - .5; //subtract lunch for now fix later
                            } 
                          } 
                        ?>

                        <div class="dr__job-row ts-flex
                        ">
                            <div class="ts__w-5 br-left">&nbsp;</div>
                            <div class="ts__w-35 br-left">&nbsp;</div>
                            <div class="ts__w-10 br-left">&nbsp;</div>
                            <div class="ts__w-10 br-left">&nbsp;</div>
                            <div class="ts__w-10 br-left">&nbsp;</div>
                            <div class="ts__w-10">&nbsp;</div>
                        </div>
                      

                <?php  
                  } 
                ?>
                </div><!-- dr__job-container -->
            </div><!--ts__day-row flex -->
        <?php
            $count++;
        } //end of foreach
        ?>
    </div><!--ts__day-row-wrapper -->
    <div class="ts__week-totals">
        <?php              
            if($vacation_hrs > 0){
                echo '<div class="pr16">
                        <div><span class="week__total-label">Vacation/Holiday Hrs:</span> '. $vacation_hrs .' hrs</div>
                      </div>';
            $reg_hrs = $week_total_hrs - $vacation_hrs;          
            if (($reg_hrs > 40)) {
                $ot = $reg_hrs - 40;
            } else {
                $ot = 0;
            }
               
            }

      
        ?>
        <div class="ts__reg-hours">
            <div><span class="week__total-label">Reg Hrs:</span> <?= $reg_hrs ?> hrs</div>
        </div>
        <div class="ts__ot-hours">
            <div><span class="week__total-label">OT Hrs: </span> <?= $ot ?> hrs</div>
        </div>
        <div class="ts__total-hrs">
            <div><span class="week__total-label">Total Hrs: </span><?= $week_total_hrs ?> hrs</div>
        </div>
    </div>
</div>
