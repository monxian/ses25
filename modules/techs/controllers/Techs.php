<?php
class Techs extends Trongate {

    function index () {
        $data['view_module'] = 'techs';
        $this->view('display', $data);
        /* Uncomment the lines below, 
         * Change the template method name, 
         * Remove lines above, if you want to load to the template
         */
        //$data['view_module'] = 'techs';
        //$data['view_file'] = 'display';
        //$this->template('template method here', $data);
    }

    public function status(){
        $this->module('members');
        $allowed_levels = [4,5,6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
      
        if (!$member_obj) {
            redirect(BASE_URL);
        }
        $member_id = (int) $member_obj->id;

        $sql = "SELECT
                    members.username,
                    members.id as tech_id,
                    trongate_users.user_level_id,
                    trongate_user_levels.level_title 
                FROM
                    trongate_user_levels
                LEFT OUTER JOIN
                    trongate_users
                ON
                    trongate_user_levels.id = trongate_users.user_level_id
                LEFT OUTER JOIN
                    members
                ON
                    trongate_users.id = members.trongate_user_id
                where trongate_user_levels.id  BETWEEN 3 AND 4
                AND members.confirmed = 1";
        $data['tech_list'] = $this->model->query($sql, 'object');

        $sql2 = 'SELECT 
                    members.id,
                    members.first_name
                 FROM members 
                 WHERE confirmed = 1 
                 AND is_tech = 1';
        $techs = $this->model->query($sql2, 'object');

        foreach($techs as $tech){
            $data['tech_jobs'][$tech->first_name] = $this->_get_tech_status($tech->id);
        }       

        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'techs';
        $data['view_file'] = 'display';
        $this->template('ses', $data);
    }

    function _get_tech_status($tech_id) {
        $this->module('members');
        $allowed_levels = [4, 5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            redirect(BASE_URL);
        }

        $target_tech_id = $tech_id;

        $sql = 'SELECT
                    members.id,
                    members.first_name,
                    jobs.*,                   
                    job_etc.duration,
                    job_etc.reason,
                    job_etc.on_site,
                    job_etc.enroute                     
                FROM
                    members
                LEFT OUTER JOIN
                    jobs
                ON
                    members.id = jobs.member_id
                left OUTER JOIN
                    job_etc
                ON
                    jobs.job_code = job_etc.job_code
                WHERE jobs.member_id = :member_id and jobs.job_date = :job_date
                ORDER BY jobs.time_in';

        $query_data['member_id'] = $target_tech_id;
        $query_data['job_date'] = date('Y-m-d');
       

        $jobs = $this->model->query_bind($sql, $query_data, 'object');

        return $jobs;
    }

    public function tech_status(){
        $this->module('members');
        $allowed_levels = [4, 5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            redirect(BASE_URL);
        }

        $target_tech_id = segment(3);

        $sql = 'SELECT
                    members.id,
                    members.first_name,
                    jobs.*,                   
                    job_etc.duration,
                    job_etc.reason,
                    job_etc.on_site 
                FROM
                    members
                LEFT OUTER JOIN
                    jobs
                ON
                    members.id = jobs.member_id
                left OUTER JOIN
                    job_etc
                ON
                    jobs.job_code = job_etc.job_code
                WHERE jobs.member_id = :member_id and jobs.job_date = :job_date
                ORDER BY jobs.time_in';

        $query_data['member_id'] = $target_tech_id;
        $query_data['job_date'] = date('Y-m-d');
       
        $data['jobs'] = $this->model->query_bind($sql, $query_data, 'object');
       
        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'techs';
        $data['view_file'] = 'tech_status';
        $this->template('ses', $data);
    }

    public function hours(){
        $this->module('members');
        $allowed_levels = [4];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
      
        if (!$member_obj) {
            redirect(BASE_URL);
        }

        $sql = "SELECT
                    members.username,
                    members.id as tech_id,
                    trongate_users.user_level_id,
                    trongate_user_levels.level_title 
                FROM
                    trongate_user_levels
                LEFT OUTER JOIN
                    trongate_users
                ON
                    trongate_user_levels.id = trongate_users.user_level_id
                LEFT OUTER JOIN
                    members
                ON
                    trongate_users.id = members.trongate_user_id
                where trongate_user_levels.id  BETWEEN 3 AND 4
                AND members.confirmed = 1";
        $data['tech_list'] = $this->model->query($sql, 'object');       

        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'techs';
        $data['view_file'] = 'tech_hours';
        $this->template('ses', $data);
    }

    public function hours_per_tech(): void {
        $this->module('members');
        $allowed_levels = [4, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            redirect(BASE_URL);
        }
      
        $tech_id = segment(3);

        $passed_week = segment(4);
        if (!empty($passed_week)) {
            $date_picked = $passed_week;
            $data['heading'] = 'Past Week';
        } else {
            $date_picked = date('Y-m-d', time());
            $data['heading'] = 'This Week';
        }

        $weekRange = $this->_getWeekRange($date_picked);
        $sql = 'SELECT jobs.*, members.first_name as name
                FROM jobs
                JOIN members ON jobs.member_id = members.id
                WHERE jobs.member_id = :member_id 
                AND jobs.job_date BETWEEN :week_start AND :week_end
                ORDER BY jobs.job_date ASC, jobs.time_in ASC';

        $query_data['week_start'] = $weekRange['start'];
        $query_data['week_end'] = $weekRange['end'];
        $query_data['member_id'] = $tech_id;
        $jobs = $this->model->query_bind($sql, $query_data, 'object');

        $start_date = date('M j, Y', strtotime($weekRange['start']));
        $data['start_date'] = $weekRange['start'];
        $end_date = date('M j, Y', strtotime($weekRange['end']));
        $data['week_info'] = $start_date . ' -- ' . $end_date;

        $_SESSION['return_url'] = current_url();

        foreach ($jobs as $job) {
            // Convert time_in to 12-hour format
            $time_in = $job->time_in;
            $dateTimeIn = DateTime::createFromFormat('H:i', $time_in);
            if ($dateTimeIn !== false) {
                $time12In = $dateTimeIn->format('g:i a');
                $job->time_in = $time12In;
            } else {
                $job->time_in = 'x';
            }

            // Convert time_out to 12-hour format
            $time_out = $job->time_out;
            $dateTimeOut = DateTime::createFromFormat('H:i', $time_out);
            if ($dateTimeOut !== false) {
                $time12Out = $dateTimeOut->format('g:i a');
                $job->time_out = $time12Out;
            } else {
                $job->time_out = 'x';
            }
        }

        $data['jobs'] = $jobs;
        // Call the function to sort the job data by day of the week
        $data['sortedJobs'] = $this->_sortJobsByDayOfWeek($jobs);

        $_SESSION['return_url'] = 'techs/hours_per_tech/'.$tech_id;
        $data['back'] = 'techs/hours';

        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'techs';
        $data['view_file'] = 'tech_week';
        $this->template('ses', $data);
    }



    public function _getWeekRange($dateString) {
        $timestamp = strtotime($dateString);
        //check if its sunday 
        if (date('l', $timestamp) == 'Sunday') {
            $startOfWeek = $timestamp;
        } else {
            $startOfWeek = strtotime('last Sunday', $timestamp);
        }

        $endOfWeek = strtotime('next Saturday', $startOfWeek);

        $weekStart = date('Y-m-d', $startOfWeek);
        $weekEnd = date('Y-m-d', $endOfWeek);

        return array('start' => $weekStart, 'end' => $weekEnd);
    }

    public function _sortJobsByDayOfWeek($jobData) {
        $sortedJobs = array(
            'Sunday' => array(),
            'Monday' => array(),
            'Tuesday' => array(),
            'Wednesday' => array(),
            'Thursday' => array(),
            'Friday' => array(),
            'Saturday' => array()
        );

        // Loop through each job entry
        foreach ($jobData as $job) {
            // Get the day of the week for the job date
            $dayOfWeek = date('l', strtotime($job->job_date));
            // Add the job to the corresponding day of the week
            $sortedJobs[$dayOfWeek][] = $job;
        }
        // Return the sorted array
        return $sortedJobs;
    }



    



}