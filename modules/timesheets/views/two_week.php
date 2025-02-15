   <div class="timesheet__page">
       <?= Modules::run('timesheets/_generate_timesheet', $date_picked, $info, '') ?>
       <?= Modules::run('timesheets/_generate_timesheet', $next_week, $info, 'not-first') ?>
   </div>
   <style>
       @import url('<?= BASE_URL ?>timesheets_module/css/custom.css');
   </style>
 
   <script src="<?= BASE_URL ?>timesheets_module/js/custom.js"></script>