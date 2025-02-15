   <div class="timesheet__page">
       <?php       
        $count = 0;            
        foreach($all_techs as $tech){           
            //we have to pass it this way because functions can't take 4 args
            $info2['member_id'] = $tech['id'];
            $info2['admin_access'] = $info['admin_access'];
           
             if ($count == 0) {
                echo Modules::run('timesheets/_generate_timesheet', $date_picked, $info2, '');
                echo Modules::run('timesheets/_generate_timesheet', $next_week, $info2, 'not-first');
            } else {
                //same as above just not showing the header
                echo Modules::run('timesheets/_generate_timesheet', $date_picked, $info2, 'not-first');
                echo Modules::run('timesheets/_generate_timesheet', $next_week, $info2, 'not-first');
            }
            $count++;
        }
        ?>
   </div>
   <style>
       @import url('<?= BASE_URL ?>timesheets_module/css/custom.css');
   </style>
 
   <script src="<?= BASE_URL ?>timesheets_module/js/custom.js"></script>