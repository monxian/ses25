<?php
class Projects extends Trongate {


    public function search(){
        $this->module('members');
        $allowed_levels = [4, 5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            $data['return_url'] = $_SERVER['HTTP_REFERER'];
            $this->template('error_403', $data);
            die();
        }
        $data['heading'] = 'Search Projects';
        $data['mx-path'] = 'search_mx';
        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'projects';
        $data['view_file'] = 'search';
        $this->template('ses', $data);
    }

    public function search_mx(){
        $this->module('members');
        $allowed_levels = [4, 5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            $data['return_url'] = $_SERVER['HTTP_REFERER'];
            $this->template('error_403', $data);
            die();
        }

        $offset = segment(3) ? segment(3) : 0;
        $query = post('query', true);
        $query_data['search_query'] = '%' . $query . '%';       

        $sql_count = 'SELECT COUNT(*) as total_count 
                      FROM projects as p
                      WHERE p.project_name
                      LIKE :search_query';
        $row_count = $this->model->query_bind($sql_count, $query_data, 'object'); 
       
        $sql = 'SELECT p.* 
                FROM projects as p
                WHERE p.project_name LIKE :search_query
                LIMIT 10 OFFSET :offset';
      
        $query_data['offset'] = $offset;
        $data['projects'] = $this->model->query_bind($sql, $query_data, 'object');     
        
        $data['member_obj'] = $member_obj;
        $this->view('display_search', $data);
    }

    function search_fuzzy() {
        $this->module('members');
        $allowed_levels = [4, 5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            $data['return_url'] = $_SERVER['HTTP_REFERER'];
            $this->template('error_403', $data);
            die();
        }

        // Get the first day of the current year
        $firstDay = new DateTime('first day of January this year');     
        $data['start_date'] = $firstDay->format('Y-m-d');

        // Get the last day of the current year
        $lastDay = new DateTime('last day of December this year');
        $data['end_date'] = $lastDay->format('Y-m-d');

        $data['heading'] = 'Job Analysis';
        $data['loc'] = 'projects/search_results';

        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'projects';
        $data['view_file'] = 'search_fuzzy';
        $this->template('ses', $data);
    }

    function submit_search() {
        $this->module('members');
        $allowed_levels = [4, 5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            $data['return_url'] = $_SERVER['HTTP_REFERER'];
            $this->template('error_403', $data);
            die();
        }

        $job_name = post('job_name', true);
        $start_date = post('start_date', true);
        $end_date = post('end_date', true);
       

        $query_data['job_query'] = '%' . $job_name . '%';      
        $query_data['start_date'] = $start_date;
        $query_data['end_date'] = $end_date;

        $sql = 'SELECT jobs.*, members.first_name
                FROM jobs
                LEFT JOIN members on jobs.member_id = members.id
                WHERE job_name LIKE :job_query
                AND job_date BETWEEN :start_date 
                AND :end_date';
            
        $result = $this->model->query_bind($sql , $query_data, 'object');

        // Array to store total hours by technician
        $techHours = [];
        $total_job_hours = 0;  

        // Loop through the jobs
        foreach ($result as $job) {
            // Calculate total hours by technician
            if (isset($techHours[$job->first_name])) {
                $techHours[$job->first_name] += (float)$job->job_hours;               
            } else {
                $techHours[$job->first_name] = (float)$job->job_hours;               
            }

            $total_job_hours += (float)$job->job_hours;

            $jobName = $job->job_name;
            // Increment the count for the job name, or initialize it to 1 if not set
            if (isset($jobOccurrences[$jobName])) {
                $jobOccurrences[$jobName]++;
            } else {
                $jobOccurrences[$jobName] = 1;
            }
        }

        arsort($techHours);
        $data['query'] = $job_name;
        $data['techs'] = $techHours;
        $data['job_names'] = $jobOccurrences;
        $data['total_job_hours'] = $total_job_hours;

        $data['heading'] = 'Search Result For <i>"'.$job_name.'"</i>';      
       
        $data['date_start'] = $this->_convert_date($start_date);
        $data['date_end'] = $this->_convert_date($end_date);

        $data['link_start_date'] = $start_date;
        $data['link_end_date'] = $end_date;        
    
        $this->view('name_search_render', $data);
    
    } 

    function job_analysis(){
        $this->module('members');
        $allowed_levels = [4, 5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            $data['return_url'] = $_SERVER['HTTP_REFERER'];
            $this->template('error_403', $data);
            die();
        }


        $job_name = urldecode( segment(3));
        $start_date = segment(4);
        $end_date = segment(5);

        $query_data['job_query'] = $job_name;      
        $query_data['start_date'] = $start_date;
        $query_data['end_date'] = $end_date;


        $sql = 'SELECT jobs.*, members.first_name
        FROM jobs
        LEFT JOIN members on jobs.member_id = members.id
        WHERE job_name = :job_query
        AND job_date BETWEEN :start_date 
        AND :end_date';
        
        $result = $this->model->query_bind($sql , $query_data, 'object');
       

        // Array to store total hours by technician
        $techHours = [];
        $total_job_hours = 0;  

        // Loop through the jobs
        foreach ($result as $job) {
            // Calculate total hours by technician
            if (isset($techHours[$job->first_name])) {
                $techHours[$job->first_name] += (float)$job->job_hours;               
            } else {
                $techHours[$job->first_name] = (float)$job->job_hours;               
            }

            $total_job_hours += (float)$job->job_hours;  
        
        }  
      
        arsort($techHours);
        $data['query'] = $job_name;
        $data['techs'] = $techHours;
        $data['job_names'] = $jobOccurrences;
        $data['total_job_hours'] = $total_job_hours;

        $data['heading'] = 'Search Result For <i>"'.$job_name.'"</i>';      
       
        $data['date_start'] = $this->_convert_date($start_date);
        $data['date_end'] = $this->_convert_date($end_date);

        $data['link_start_date'] = $start_date;
        $data['link_end_date'] = $end_date;        
    
        $this->view('job_analysis_render', $data);
        
    }

    function fix_name() {
        $this->module('members');
        $allowed_levels = [4, 5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            $data['return_url'] = $_SERVER['HTTP_REFERER'];
            $this->template('error_403', $data);
            die();
        }

        $data['old_job_name'] =  urldecode(segment(3));
        $data['cancel'] = 'projects/search_fuzzy';
        $data['heading'] = 'Fixing Job Name';

        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'projects';
        $data['view_file'] = 'fix_name_display';
        $this->template('ses', $data);
    }
    function submit_fix_name() {
        $this->module('members');
        $allowed_levels = [4, 5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            $data['return_url'] = $_SERVER['HTTP_REFERER'];
            $this->template('error_403', $data);
            die();
        }
        
        $submit = post('submit', 'true');
        
        if ($submit == 'Submit') {
        
            $this->validation_helper->set_rules('new_job_name', 'Job Name', 'required');
        
            $result = $this->validation_helper->run();
        
            if ($result == true) {
               
                $old_job_name = post('old_job_name', true);

                $row_count = $this->model->count_where('job_name', $old_job_name, "=", "jobs");

                $query_data['old_job_name'] = $old_job_name;
                $query_data['new_job_name'] = post('new_job_name', true);

                $sql = 'UPDATE jobs 
                        SET job_name = :new_job_name
                        WHERE job_name = :old_job_name';

                $this->model->query_bind($sql, $query_data);

                $flash_msg = 'Succesfully updated '. $row_count .' rows';
                set_flashdata($flash_msg);
                redirect('projects/search_fuzzy');
                
            } else {
                redirect('projects/search_fuzzy');
            }
     
        } else {
            redirect('projects/search_fuzzy');
        }
    }

    function _convert_date($date_string) {
        $timestamp = strtotime($date_string);
        $formattedDate = date("M j, Y", $timestamp);        
        return $formattedDate;
    }

  

}