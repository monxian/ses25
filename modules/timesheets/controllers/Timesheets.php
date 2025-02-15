<?php
class Timesheets extends Trongate {

    private $template_to_use = 'ses';

    function index () {        
      
        $data['view_module'] = 'timesheet';
        $data['view_file'] = 'display';
        $this->template($this->template_to_use, $data);
    }  
    function pick_week() {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [3, 4, 6], true);

        if (!$member_obj) {
            redirect(BASE_URL);
        }

        $data['loc'] = BASE_URL . 'timesheets/submit_picked_date';
        $data['cancel'] = $_SESSION['return_url'];

        $data['member_obj'] = $member_obj;  
        $data['view_module'] = 'timesheets';
        $data['view_file'] = 'pick_week';
        $this->template($this->template_to_use, $data);
    }

    function submit_picked_date() {
        //Uncomment the following as your need
        //$this->module('security');
        //$this->security->_make_sure_allowed();
        
        $submit = post('submit', 'true');
        
        if ($submit == 'Submit') {
        
            $this->validation_helper->set_rules('picked_date', 'Picked Date', 'required');
        
            $result = $this->validation_helper->run();
        
            if ($result == true) {
                $picked_date = post('picked_date', true);
                redirect(BASE_URL.'timesheets/display/all_techs/'.$picked_date);
                
            } else {
                $this->pick_week();
            }
        //set_flashdata($flash_msg);
        //redirect('store_accounts/show/'.$update_id);
        } else {
            $this->pick_week();
        }
    }


    function display() {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [3, 4, 6], true);

        if (!$member_obj) {
            redirect(BASE_URL);
        }
       
        $admin_access = false;

        //passed in member id
        if (!empty(segment(5))) {
            $this->module('members');
            $member_obj = $this->members->_get_member_custom($user_level = [6], true);

            if (!$member_obj) {
                redirect(BASE_URL);
            }
            //$data['loc'] = BASE_URL . 'members-account/submit_profile_pic/' . $code;
            $member_id = segment(5);
            $admin_access = true;
        } else {
            $member_id = $member_obj->id;
        }

        $view_file = segment(3);
        $passed_week = segment(4);      
       
        if (!empty($passed_week)) {
            if($view_file == 'all_techs'){
                $date_picked = date("Y-m-d", strtotime($passed_week . " -2 week"));
                $admin_access = true;              
            }  else {
                $date_picked = $passed_week; 
            }  
        } else {          
            //$date_picked = date('Y-m-d', time());
            $date_picked = date("Y-m-d", strtotime("-2 week"));
        }

        // Get the week after this one, if doing two week payroll
        $date = DateTime::createFromFormat('Y-m-d', $date_picked);
        $date->add(new DateInterval('P1W'));
        $data['next_week'] = $date->format('Y-m-d');

        $data['date_picked'] = $date_picked;
        $data['info']['member_id'] = $member_id;
        $data['info']['admin_access'] = $admin_access; // bool     
       

       if($view_file == 'all_techs'){          
            $sql = 'SELECT
                        members.id 
                    FROM
                        members
                    LEFT OUTER JOIN
                        trongate_users
                    ON
                        members.trongate_user_id = trongate_users.id
                    LEFT OUTER JOIN
                        trongate_user_levels
                    ON
                        trongate_users.user_level_id = trongate_user_levels.id
                    WHERE members.confirmed = 1 
                    and trongate_user_levels.level_title = "tech" OR trongate_user_levels.level_title = "lead"';
                    
            $data['all_techs'] = $this->model->query($sql, 'array');           
       }

       //set the new return url because of editing jobs from timesheet
        $_SESSION['return_url'] = current_url();


        $data['member_obj'] = $member_obj;    
        $data['view_module'] = 'timesheets';
        $data['view_file'] = $view_file;
        $this->template($this->template_to_use, $data);
    }

    function _generate_timesheet($date_picked, $info, $not_first_week) {        
        $member_id = $info['member_id'];
        $admin_access = $info['admin_access'];

        $weekRange = $this->_getWeekRange($date_picked);
        
        $member_info = $this->model->get_one_where('id', $member_id, 'members');

        $sql = 'SELECT
                    jobs.*,
                    cost_codes.code,
                    cost_codes.description,
                    members.first_name,
                    members.last_name
                FROM jobs
                LEFT OUTER JOIN cost_codes ON jobs.cost_code = cost_codes.id
                LEFT OUTER JOIN members ON jobs.member_id = members.id
                WHERE jobs.member_id = :member_id
                    AND jobs.job_date BETWEEN :week_start AND :week_end
                ORDER BY jobs.job_date ASC, jobs.time_in ASC';

        $query_data['week_start'] = $weekRange['start'];
        $query_data['week_end'] = $weekRange['end'];
        $query_data['member_id'] = $member_id;
        $jobs = $this->model->query_bind($sql, $query_data, 'object');       
      

        // if there are no jobs end this function.
        if(empty($jobs)){
            return '<div class="max-content p8 m8 round-sm alert-info hide-print">'. ucfirst(out($member_info->first_name)).' had no reported jobs for the week of '.$date_picked.'</div>';
            die();
        }

        // Get on call status for this week
        $weekNumber = date("W", strtotime($weekRange['start']));
        $sql = 'SELECT * FROM on_call WHERE week_of = :week_of AND member_id = :member_id';
        $onCall_data['week_of'] = $weekNumber + 1; // plus on because week starts on monday but we use sunday
        $onCall_data['member_id'] = $member_id;
        $on_call = $this->model->query_bind($sql, $onCall_data, 'object');
        $data['on_call'] = $on_call ? true : false;
      
        $data['tech_name'] = ucfirst($member_info->first_name) .' '. ucfirst($member_info->last_name);

        $start_date = date('n/d/Y', strtotime($weekRange['start']));
        $end_date = date('n/d/Y', strtotime($weekRange['end']));
        $data['week_info'] = $start_date . ' thru ' . $end_date;

        $data['eow'] = $end_date;
        $week_days = $this->_create_week_array($start_date);

        $week_total_hrs = 0;
        for ($i = 0; $i <= 6; $i++) {
            $day = date('l', strtotime($week_days[$i]));
            $data[$day] = [];
            $job_count = 0;
            $day_total_hours = 0;

            foreach ($jobs as $item) {
                if ($item->job_date == $week_days[$i]) {
                    $data[$day][] = $item;
                    $job_count++;
                    $day_total_hours += $item->job_hours;
                }
            }
            $data[$day]['job_count'] = $job_count;
            $data[$day]['day_total_hours'] = $day_total_hours;

            if ($day_total_hours > 6) {
                $day_total_hours -= .5;
                $data[$day]['day_total_hours'] -= .5;
            }
            $week_total_hrs += $day_total_hours;
        }


        // calculate overtime
        if ($week_total_hrs > 40) {
            $ot = $week_total_hrs - 40;
            $reg_hrs = 40;
        } else {
            $ot = 0;
            $reg_hrs = $week_total_hrs;
        }

        $data['ot'] = $ot;
        $data['reg_hrs'] = $reg_hrs;

        $data['week_total_hrs'] = $week_total_hrs;
        $data['week_dates'] = $week_days;
        $data['not_first_week'] = $not_first_week; 
        $data['admin_access'] = $admin_access;  
       
        return $this->view('generate_timesheet', $data);  
      
    }


    function _getWeekRange($dateString) {
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

    function _create_week_array($date_passed) {
        $startDate = new DateTime($date_passed);
        $weekDates = array();

        for ($i = 0; $i < 7; $i++) {
            $currentDate = clone $startDate; // Create a copy of the start date
            $currentDate->modify('+' . $i . ' day'); // Add $i days to the current date
            $formattedDate = $currentDate->format('Y-m-d');
            $weekDates[] = $formattedDate;
        }
        return $weekDates;
    }

        


}