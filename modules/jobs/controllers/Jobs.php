<?php
class Jobs extends Trongate {

    private $default_limit = 20;
    private $per_page_options = array(10, 20, 50, 100);
    private $template_to_use = "ses";


    public function etc_modal(): void {
        http_response_code(200);
        $job_code = segment(3);
        $job_etc = $this->model->get_one_where('job_code', $job_code, 'job_etc');
        $checked_on_site = $job_etc->on_site == '0' || $job_etc->on_site === null ? 'false' : 'true';
        $checked_enroute = $job_etc->enroute == '0' || $job_etc->enroute === null ? 'false' : 'true';
        $action = $job_etc ? 'Update Status' : 'On Site Status';

        $html = '<div class="modal-header-info text-center p8"><h3>' . $action . ' </h3></div>';
        $html .= form_open(BASE_URL . 'jobs/etc/' . $job_code, array('class' => 'modal-form'));

        $html .= '<div class="flex p16 "><div class="modal-form-group">';
        $html .=  form_label('En Route', array("for" => "enroute"));
        $html .=  form_radio('cur_status', 'enroute', $checked_enroute, array("id" => "enroute"));
        $html .= '</div><div class="modal-form-group">';
        $html .=  form_label('On Site', array("for" => "on-site"));
        $html .=  form_radio('cur_status', 'onsite', $checked_on_site, array("id" => "on-site"));
        $html .= '</div></div>';

        $html .= '<div class="modal-form-group">';
        $html .=  form_label('Estimated Time of Completion or Arrival time <span class="input-optional">(optional)</span>', array("for" => "duration"));
        $html .= '<input type="time" name="duration" value="' . out($job_etc->duration) . '" id="duration"></div>';
        $html .= '<div class="modal-form-group">';
        $html .=  form_label('Notes <span class="input-optional">(optional)</span>', array('class' => 'accent'));
        $attributes['id'] = 'notes';
        $attributes['rows'] = '6';
        $html .= form_textarea('reason', out($job_etc->reason), $attributes);
        $html .= '</div>';

        $html .= '<div class="modal-btn-group">';
        $html .= form_submit('Submit', 'submit', array("class" => "btn-primary-45"));
        $html .= '<button type="button" onclick="closeModal()" class="btn-modal-secondary">Cancel</button>';
        $html .= '</div>';
        $html .= form_close();

        echo $html;
    }

    public function etc() {
        $this->module('members');
        $allowed_levels = [3, 4];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }

        $job_code = segment(3);

        // Don't anticipate etc being set on non-current date.
        $date_now = date('Y-m-d');

        $job_etc = $this->model->get_one_where('job_code', $job_code, 'job_etc');

        $data['job_code'] = $job_code;
        $data['duration'] = post('duration', true);
        $data['reason'] = post('reason', true);
        $current_status = post('cur_status', true);

        switch ($current_status) {
            case "enroute":
                $enroute = 1;
                $onsite = 0;
                break;
            case "onsite":
                $enroute = 0;
                $onsite = 1;
                break;
            default:
                $enroute = 0;
                $onsite = 0;
        }

        $data['on_site'] = $onsite;
        $data['enroute'] = $enroute;       

        if ($job_etc) {
            $this->model->update_where('job_code', $job_code, $data, 'job_etc');
        } else {
            $this->model->insert($data, 'job_etc');
        }

        redirect(BASE_URL . 'jobs/day_view/' . $date_now);
    }

    public function delete_modal(): void {
        http_response_code(200);
        $job_code = segment(3);
        $html = '<div class="modal-header-danger text-center p8"><h3>Deleting Job</h3></div>';
        $html .= '<div class="text-center pt16"><p>Are you sure you want to delete this job?</p></div>';
        $html .= '<div class="flex align-center justify-between p8">';
        $html .= '<a class="button btn-danger" href="' . BASE_URL . 'jobs/delete_job/' . $job_code . '">Delete</a>';
        $html .= '<button type="button" onclick="closeModal()" class="btn-modal-secondary">Cancel</button>';
        $html .= '</div>';

        echo $html;
    }

    public function delete_job() {
        $this->module('members');
        $allowed_levels = [3, 4, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }
        $member_id = $member_obj->id;

        $job_code = segment(3);
        $job = $this->model->get_one_where('job_code', $job_code, 'jobs');

        //check ownership
        if ($job->member_id != $member_id) {
            redirect(BASE_URL . 'jobs/day_view/' . $job->job_date);
        }

        $sql = 'DELETE FROM jobs WHERE job_code = :job_code';
        $param['job_code'] = $job->job_code;
        $this->model->query_bind($sql, $param);

        $sql2 = 'DELETE FROM job_comments WHERE job_code = :job_code';
        $this->model->query_bind($sql2, $param);

        redirect(BASE_URL . 'jobs/day_view/' . $job->job_date);
    }




    function day_view() {       
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [2, 3, 4], true);

        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }

        $member_id = $member_obj->id;
        $passed_date = segment(3);

        $sql = 'SELECT 
                    members.first_name AS name, 
                    jobs.*, 
                    job_etc.duration
                FROM 
                    jobs
                INNER JOIN 
                    members ON jobs.member_id = members.id
                LEFT JOIN 
                    job_etc ON jobs.job_code = job_etc.job_code
                WHERE 
                    jobs.member_id = :member_id
                    AND jobs.job_date = :job_date
                ORDER BY 
                    jobs.time_in ASC';

        if (!$passed_date) {
            $query_data['job_date'] = date('Y-m-d');
        } else {
            $query_data['job_date'] = $passed_date;
        }
        $query_data['member_id'] = $member_id;
        $data['jobs'] = $this->model->query_bind($sql, $query_data, 'object');

        foreach ($data['jobs'] as $job) {
            if ($job->time_in != 'x') {
                $time_in = $job->time_in;
                $dateTime = DateTime::createFromFormat('H:i', $time_in);
                $time12 = $dateTime->format('g:i a');
                $job->time_in = $time12;
            }

            if ($job->time_out != 'x') {
                $time_out = $job->time_out;
                $dateTime = DateTime::createFromFormat('H:i', $time_out);
                $time12 = $dateTime->format('g:i a');
                $job->time_out = $time12;
            }

            if ($job->duration != null) {
                $dateTime = DateTime::createFromFormat('H:i', $job->duration);
                $time12 = $dateTime->format('g:i a');
                $job->duration = $time12;
            }
        }

        $data['date'] = date('M j, Y', strtotime($query_data['job_date']));
        $data['date_pass'] = date('Y-m-d', strtotime($query_data['job_date']));
        $data['day'] = date('l', strtotime($data['date']));

        $_SESSION['return_url'] = current_url();

        $data['member_obj'] = $member_obj;
        $data['view_file'] = 'day_view';
        $this->template($this->template_to_use, $data);
    }


    function add() {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [3, 4], true);

        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }
       
        $sql = 'SELECT jobs.time_out
                FROM jobs
                WHERE jobs.job_date = :job_date 
                AND jobs.member_id = :member_id
                ORDER BY jobs.time_out DESC
                LIMIT 1';
        $params['job_date'] = date('Y-m-d');
        $params['member_id'] = $member_obj->id;
        $last_time_out = $this->model->query_bind($sql, $params, 'object');
       
        if(count($last_time_out) != 0){
            $data['time_in'] = $last_time_out[0]->time_out;
        } else {
            $data['time_in'] = $this->get_quarter_hour();
        }

        $data['codes'] = $this->_get_cost_code();
        $data['job_date'] = segment(3);
        

        $data['loc'] = BASE_URL . 'jobs/submit_add_job/' . segment(3);
        $data['cancel'] = $_SESSION['return_url'];

        $data['member_obj'] = $member_obj;
        $data['view_file'] = 'add';
        $this->template($this->template_to_use, $data);
    }

    function submit_add_job(): void {
        $this->module('members');
        $allowed_levels = [3, 4];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }

        $member_id = (int) $member_obj->id;

        $submit = post('submit', true);

        if ($submit == 'Submit') {

            $this->validation_helper->set_rules('job_date', 'job date', 'required|min_length[2]|max_length[255]');
            $this->validation_helper->set_rules('job_name', 'job name', 'required|min_length[2]|max_length[255]');
            $this->validation_helper->set_rules('time_in', 'time in', 'required|min_length[2]|max_length[255]');
            $this->validation_helper->set_rules('cost_code', 'cost code', 'required|max_length[11]|numeric|greater_than[0]|integer');
            

            $result = $this->validation_helper->run();

            if ($result == true) {

                $data = $this->_get_data_from_post_add();

                $data['time_out'] = 'x';
                $data['job_hours'] = 0;
                $data['job_code'] = make_rand_str(10);
                $data['member_id'] = $member_id;

                //insert the new record
                $update_id = $this->model->insert($data, 'jobs');
                redirect($_SESSION['return_url']);
            } else {
                //form submission error failed validation
                redirect(BASE_URL . 'jobs/add/' . segment(3));
            }
        }
        //form submission error
        redirect(BASE_URL . 'jobs/add/' . segment(3));
    }


    function close() {
        $this->module('members');
        $allowed_levels = [3, 4];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }
        $member_id = (int) $member_obj->id;

        $job_code = segment(3);
        $job = $this->model->get_one_where('job_code', $job_code, 'jobs');

        $data['job_name'] = $job->job_name;
        $data['job_code'] = $job->job_code;

        $data['time_out'] = $this->get_quarter_hour();

        $data['loc'] = BASE_URL . 'jobs/submit_close/' . $job->job_code;
        $data['cancel'] = $_SESSION['return_url'];

        $data['member_obj'] = $member_obj;
        $data['view_file'] = 'close';
        $this->template($this->template_to_use, $data);
    }

    function submit_close() {
        $this->module('members');
        $allowed_levels = [3, 4];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }
        $member_id = (int) $member_obj->id;

        $job = $this->model->get_one_where('job_code', segment(3), 'jobs');

        //was etc set on this job
        $found_etc = $this->model->get_one_where('job_code', segment(3), 'job_etc');
      
        $submit = post('submit', 'true');

        if ($submit == 'Submit') {

            $this->validation_helper->set_rules('time_out', 'time out', 'required|min_length[2]|max_length[255]');

            $result = $this->validation_helper->run();

            if ($result == true) {
                $data['time_out'] = post('time_out', true);

                $job_hours = $this->_get_total_hours($job->time_in, $data['time_out']);
                $data['job_hours'] = $job_hours;

                //update an existing record
                $this->model->update_where('job_code', $job->job_code, $data, 'jobs');

                if ($found_etc) {
                    $this->model->delete($found_etc->id, 'job_etc');
                }               
         
                redirect('jobs-job_comments/add/'.$job->job_code);               
               
            } else {
                redirect(BASE_URL . 'jobs/close/' . $job->job_code);
            }
            //set_flashdata($flash_msg);
            //redirect('store_accounts/show/'.$update_id);
        } else {
            redirect(BASE_URL . 'jobs/day_view/' . $job->job_date);
        }
    }


    function edit() {
        $this->module('members');
        $allowed_levels = [3, 4, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }

        $job_code = segment(3);

        if ($job_code) {
            $record_obj = $this->model->get_one_where('job_code', $job_code, 'jobs');
            $data = (array) $record_obj;
        } else {
            $data = $this->_get_data_from_post_edit();
        }
        $data['heading'] = 'Update Job';

        $cc_array = ['18','20','21','22'];
        $non_job_entry = false;
        if(in_array($record_obj->cost_code, $cc_array)){
            $non_job_entry = true;
            $data['heading'] = 'Update Entry';
        }
        $data['non_job_entry'] = $non_job_entry;

        $comment_count = $this->model->count_where('job_code', $job_code, '=', 'job_comments');
        $data['deletable'] = $comment_count > 0 ? 'false' : 'true';

        $data['delete_job'] = BASE_URL . 'jobs/delete/' . $job_code;
        $data['codes'] = $this->_get_cost_code($data['cost_code']);
     
        $data['loc'] = BASE_URL . 'jobs/submit_edit_job/' . segment(3);
        $data['cancel'] = $_SESSION['return_url'];

        $data['job_code'] = $job_code;


        $data['member_obj'] = $member_obj;
        $data['view_file'] = 'edit';
        $this->template($this->template_to_use, $data);
    }

    function submit_edit_job(): void {
        $this->module('members');
        $allowed_levels = [3, 4, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }
        $member_id = (int) $member_obj->id;

        $job = $this->model->get_one_where('job_code', segment(3), 'jobs');

        //check if admin is adjusting job or lead tech
        if ($job->member_id != $member_id) {
            if ($member_obj->user_level_id == 4 || $member_obj->user_level_id == 6) {
                $member_id = (int) $job->member_id;
            } else {
                redirect($_SESSION['return_url']);
            }
        }

       

        $submit = post('submit', true);

        if ($submit == 'Submit') {

            $this->validation_helper->set_rules('job_date', 'job date', 'required|min_length[2]|max_length[255]');
            $this->validation_helper->set_rules('job_name', 'job name', 'required|min_length[2]|max_length[255]');
            $this->validation_helper->set_rules('time_in', 'time in', 'required|min_length[2]|max_length[255]');
            $this->validation_helper->set_rules('time_out', 'time out', 'min_length[2]|max_length[255]');
            $this->validation_helper->set_rules('cost_code', 'cost code', 'required|max_length[11]|numeric|greater_than[0]|integer');
        
            $result = $this->validation_helper->run();

            if ($result == true) {

                $data = $this->_get_data_from_post_edit();
                $job_hours = $this->_get_total_hours($data['time_in'], $data['time_out']);
                $data['job_hours'] = $job_hours;

                //updaterecord
                $update_id = $this->model->update_where('job_code', $job->job_code, $data, 'jobs');
                redirect($_SESSION['return_url']);
            } else {
                //form submission error failed validation
                redirect(BASE_URL . 'jobs/edit');
            }
        }
        //form submission error
        redirect(BASE_URL . 'jobs/edit/' . $job->job_code);
    }

    function _get_cost_code($passed_id = null) {
        $codes = $this->model->get('id', 'cost_codes');
        $select_code = '<label for="cost_code" class="accent">Cost Code</label><select name="cost_code">';
        foreach ($codes as $code) {
            if ((int)$code->id  == (int)$passed_id) {
                $select_code .= '<option value="' . $code->id . '" selected>' . $code->description . '</option>';
            } else {
                $select_code .= '<option value="' . $code->id . '">' . $code->description . '</option>';
            }
        }
        $select_code .= '</select>';

        return $select_code;
    }

    function _get_total_hours($time_in, $time_out) {
        $time_in_int = strtotime($time_in);
        $time_out_int = strtotime($time_out);
        $time_in_mins = $time_in_int / 3600;
        $time_out_mins = $time_out_int / 3600;
        if ($time_out_mins < $time_in_mins) {
            $total_hrs = ($time_out_mins + 24) - $time_in_mins; // Output: 10.5
        } else {
            $total_hrs = $time_out_mins - $time_in_mins; // Output: 10.5

        }

        return $total_hrs;
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


    private function get_quarter_hour() {
        $dateTime = new DateTime();
        $minutes = $dateTime->format('i');
        $roundedMinutes = round($minutes / 15) * 15;
        $dateTime->setTime($dateTime->format('H'), $roundedMinutes);
        $roundedTime = $dateTime->format('H:i');

        return $roundedTime;
    }


    public function search_past() {
        $this->module('members');
        $allowed_levels = [3, 4];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }
        $member_id = $member_obj->id;


        $data['member_obj'] = $member_obj;
        $data['view_file'] = 'past_jobs';
        $this->template($this->template_to_use, $data);
    }


    public function holiday_modal(): void {
        http_response_code(200);
        
        $job_date = segment(3); 
        $job_code = segment(4);
        $job_hours = 0;

        if($job_code){
            $entry = $this->model->get_one_where('job_code', $job_code, 'jobs');
            $name_array = ['Vacation Day','Holiday','Sick Day','No Work'];
            $selected = "";
            $spec_name = "";
           
            $job_hours = $entry->job_hours - .5;
            if(in_array($entry->job_name, $name_array)){
                $selected = $name_array[$entry->job_name];               
            } else {
                $selected = $name_array[$entry->job_name];
                $spec_name = $entry->job_name;
            }
            
        }    

        $html = '<div class="modal-header-info text-center p8">
                    <h3>Non Work Hours</h3>                    
                 </div>';
        $html .= form_open(BASE_URL . 'jobs/submit_holiday/'.$job_code, array('class' => 'modal-form'));
        $html .= '<div class="p8 text-center"><p class="text-primary">Auto generates an entry</p></div>'; 
        
        $html .= form_hidden('passed_date', $job_date );

        $html .= '<div class="modal-form-group">';
        $html .=  form_label('Non Work type.', array("for" => "nonwork"));
        $html .=  form_dropdown('hour_type', ['1'=>'Vacation Day', '2'=>'Holiday', '3' => 'Sick Day', '4' => 'No Work'], $selected , array("id"=>"nonwork"));
        $html .= '</div>';

        $html .= '<div class="modal-form-group">';
        $html .=  form_label('Specific Name (optional).', array("for" => "spec_name"));
        $html .= '<input type="text" name="spec_name" value="'.$spec_name.'" id="spec_name"></div>';
      
        $html .= '<div class="modal-form-group">';
        $html .=  form_label('Hours needed.', array("for" => "hours"));
        $html .= '<input type="number" name="job_hours" value="'.$job_hours.'" id="hours" min="0"></div>';
   
        $html .= '<div class="modal-btn-group">';
        $html .= form_submit('submit', 'Submit', array("class" => "btn-primary-45"));
        $html .= '<button type="button" onclick="closeModal()" class="btn-modal-secondary">Cancel</button>';
        $html .= '</div>';
        $html .= form_close();

        echo $html;
    }

  
    function submit_holiday() {
        $this->module('members');
        $allowed_levels = [3, 4, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }
        $member_id = (int) $member_obj->id;
        $job_code = segment(3);
        
        $submit = post('submit', 'true');       
        
        if ($submit == 'Submit') {  
           $job_date = post('passed_date', true);      
           $hour_type = post('hour_type', true);
           $spec_name = post('spec_name', true);
           $claimed_hours = post('job_hours', true);

           switch ($hour_type){
                case 1:
                    if ($spec_name !== "") {
                        $job_name = $spec_name;
                    } else {
                        $job_name = 'Vacation Day';
                    } 
                    $claimed_hours = $claimed_hours + .5;
                    $cost_code = '22';
                    break;            
                case 2:
                    if ($spec_name !== "") {
                        $job_name = $spec_name;
                    } else {
                        $job_name = 'Holiday';
                    }
                    $claimed_hours = $claimed_hours + .5;                
                    $cost_code = '18';
                    break;
                case 3:
                    if ($spec_name !== "") {
                        $job_name = $spec_name;
                    } else {
                        $job_name = 'Sick Day';
                    }                  
                    $cost_code = '21';
                    $claimed_hours = 0;
                    break;
                case 4:
                    if ($spec_name !== "") {
                        $job_name = $spec_name;
                    } else {
                        $job_name = 'No Work';
                    }                   
                    $cost_code = '20';
                    $claimed_hours = 0;
                    break;                
           }
           
           if($job_code){
                $params['job_name'] = $job_name;
                $params['cost_code'] = $cost_code;
                $params['job_hours'] = $claimed_hours;               
                
                $entry = $this->model->get_one_where('job_code', $job_code, 'jobs');
                $entry_id = $entry->id;               
                $this->model->update($entry_id, $params, 'jobs');    
           } else {
                $params['job_name'] = $job_name;
                $params['cost_code'] = $cost_code;
                $params['job_hours'] = $claimed_hours;
                $params['job_date'] = $job_date;
                $params['time_out'] = 'x';
                $params['time_in'] = 'x';
                $params['job_code'] = make_rand_str(10);
                $params['member_id'] = $member_id;
                $this->model->insert($params, 'jobs');    
           }               
       
            redirect('jobs/day_view');
        } else {           
            redirect('jobs/day_view');
        }
    }































    /**
     * Display a webpage with a form for creating or updating a record.
     */
    public function create(): void {
        $this->module('trongate_security');
        $this->trongate_security->_make_sure_allowed();

        $update_id = (int) segment(3);
        $submit = post('submit');

        if (($submit == '') && ($update_id > 0)) {
            $data = $this->get_data_from_db($update_id);
        } else {
            $data = $this->get_data_from_post();
        }

        if ($update_id > 0) {
            $data['headline'] = 'Update Job Record';
            $data['cancel_url'] = BASE_URL . 'jobs/show/' . $update_id;
        } else {
            $data['headline'] = 'Create New Job Record';
            $data['cancel_url'] = BASE_URL . 'jobs/manage';
        }

        $data['form_location'] = BASE_URL . 'jobs/submit/' . $update_id;
        $data['view_file'] = 'create';
        $this->template('admin', $data);
    }

    /**
     * Display a webpage to manage records.
     *
     * @return void
     */
    public function manage(): void {
        $this->module('trongate_security');
        $this->trongate_security->_make_sure_allowed();

        if (segment(4) !== '') {
            $data['headline'] = 'Search Results';
            $searchphrase = trim($_GET['searchphrase']);
            $params['job_date'] = '%' . $searchphrase . '%';
            $params['job_name'] = '%' . $searchphrase . '%';
            $params['time_in'] = '%' . $searchphrase . '%';
            $params['time_out'] = '%' . $searchphrase . '%';
            $params['job_code'] = '%' . $searchphrase . '%';
            $sql = 'select * from jobs
            WHERE job_date LIKE :job_date
            OR job_name LIKE :job_name
            OR time_in LIKE :time_in
            OR time_out LIKE :time_out
            OR job_code LIKE :job_code
            ORDER BY id';
            $all_rows = $this->model->query_bind($sql, $params, 'object');
        } else {
            $data['headline'] = 'Manage Jobs';
            $all_rows = $this->model->get('id');
        }

        $pagination_data['total_rows'] = count($all_rows);
        $pagination_data['page_num_segment'] = 3;
        $pagination_data['limit'] = $this->get_limit();
        $pagination_data['pagination_root'] = 'jobs/manage';
        $pagination_data['record_name_plural'] = 'jobs';
        $pagination_data['include_showing_statement'] = true;
        $data['pagination_data'] = $pagination_data;

        $data['rows'] = $this->reduce_rows($all_rows);
        $data['selected_per_page'] = $this->get_selected_per_page();
        $data['per_page_options'] = $this->per_page_options;
        $data['view_module'] = 'jobs';
        $data['view_file'] = 'manage';
        $this->template('admin', $data);
    }

    /**
     * Display a webpage showing information for an individual record.
     *
     * @return void
     */
    public function show(): void {
        $this->module('trongate_security');
        $token = $this->trongate_security->_make_sure_allowed();
        $update_id = (int) segment(3);

        if ($update_id == 0) {
            redirect('jobs/manage');
        }

        $data = $this->get_data_from_db($update_id);
        $data['token'] = $token;

        if ($data == false) {
            redirect('jobs/manage');
        } else {
            $data['update_id'] = $update_id;
            $data['headline'] = 'Job Information';
            $data['view_file'] = 'show';
            $this->template('admin', $data);
        }
    }

    /**
     * Handle submitted record data.
     *
     * @return void
     */
    public function submit(): void {
        $this->module('trongate_security');
        $this->trongate_security->_make_sure_allowed();

        $submit = post('submit', true);

        if ($submit == 'Submit') {

            $this->validation->set_rules('job_date', 'job date', 'required|min_length[2]|max_length[255]');
            $this->validation->set_rules('job_name', 'job name', 'required|min_length[2]|max_length[255]');
            $this->validation->set_rules('time_in', 'time in', 'required|min_length[2]|max_length[255]');
            $this->validation->set_rules('time_out', 'time out', 'min_length[2]|max_length[255]');
            $this->validation->set_rules('job_hours', 'job hours', 'max_length|numeric|greater_than[0]|numeric');
            $this->validation->set_rules('member_id', 'Member ID', 'required|max_length[11]|numeric|greater_than[0]|integer');
            $this->validation->set_rules('cost_code', 'cost code', 'required|max_length[11]|numeric|greater_than[0]|integer');
            $this->validation->set_rules('job_code', 'job code', 'min_length[2]|max_length[255]');
   
            $result = $this->validation->run();

            if ($result == true) {

                $update_id = (int) segment(3);
                $data = $this->get_data_from_post();

                if ($update_id > 0) {
                    //update an existing record
                    $this->model->update($update_id, $data, 'jobs');
                    $flash_msg = 'The record was successfully updated';
                } else {
                    //insert the new record
                    $update_id = $this->model->insert($data, 'jobs');
                    $flash_msg = 'The record was successfully created';
                }

                set_flashdata($flash_msg);
                redirect('jobs/show/' . $update_id);
            } else {
                //form submission error
                $this->create();
            }
        }
    }

    /**
     * Handle submitted request for deletion.
     *
     * @return void
     */
    public function submit_delete(): void {
        $this->module('trongate_security');
        $this->trongate_security->_make_sure_allowed();

        $submit = post('submit');
        $params['update_id'] = (int) segment(3);

        if (($submit == 'Yes - Delete Now') && ($params['update_id'] > 0)) {
            //delete all of the comments associated with this record
            $sql = 'delete from trongate_comments where target_table = :module and update_id = :update_id';
            $params['module'] = 'jobs';
            $this->model->query_bind($sql, $params);

            //delete the record
            $this->model->delete($params['update_id'], 'jobs');

            //set the flashdata
            $flash_msg = 'The record was successfully deleted';
            set_flashdata($flash_msg);

            //redirect to the manage page
            redirect('jobs/manage');
        }
    }

    /**
     * Set the number of items per page.
     *
     * @param int $selected_index Selected index for items per page.
     *
     * @return void
     */
    public function set_per_page(int $selected_index): void {
        $this->module('trongate_security');
        $this->trongate_security->_make_sure_allowed();

        if (!is_numeric($selected_index)) {
            $selected_index = $this->per_page_options[1];
        }

        $_SESSION['selected_per_page'] = $selected_index;
        redirect('jobs/manage');
    }

    /**
     * Get the selected number of items per page.
     *
     * @return int Selected items per page.
     */
    private function get_selected_per_page(): int {
        $selected_per_page = (isset($_SESSION['selected_per_page'])) ? $_SESSION['selected_per_page'] : 1;
        return $selected_per_page;
    }

    /**
     * Reduce fetched table rows based on offset and limit.
     *
     * @param array $all_rows All rows to be reduced.
     *
     * @return array Reduced rows.
     */
    private function reduce_rows(array $all_rows): array {
        $rows = [];
        $start_index = $this->get_offset();
        $limit = $this->get_limit();
        $end_index = $start_index + $limit;

        $count = -1;
        foreach ($all_rows as $row) {
            $count++;
            if (($count >= $start_index) && ($count < $end_index)) {
                $rows[] = $row;
            }
        }

        return $rows;
    }

    /**
     * Get the limit for pagination.
     *
     * @return int Limit for pagination.
     */
    private function get_limit(): int {
        if (isset($_SESSION['selected_per_page'])) {
            $limit = $this->per_page_options[$_SESSION['selected_per_page']];
        } else {
            $limit = $this->default_limit;
        }

        return $limit;
    }

    /**
     * Get the offset for pagination.
     *
     * @return int Offset for pagination.
     */
    private function get_offset(): int {
        $page_num = (int) segment(3);

        if ($page_num > 1) {
            $offset = ($page_num - 1) * $this->get_limit();
        } else {
            $offset = 0;
        }

        return $offset;
    }

    /**
     * Get data from the database for a specific update_id.
     *
     * @param int $update_id The ID of the record to retrieve.
     *
     * @return array|null An array of data or null if the record doesn't exist.
     */
    private function get_data_from_db(int $update_id): ?array {
        $record_obj = $this->model->get_where($update_id, 'jobs');

        if ($record_obj == false) {
            $this->template('error_404');
            die();
        } else {
            $data = (array) $record_obj;
            return $data;
        }
    }

    /**
     * Get data from the POST request.
     *
     * @return array Data from the POST request.
     */
    private function get_data_from_post(): array {
        $data['job_date'] = post('job_date', true);
        $data['job_name'] = post('job_name', true);
        $data['time_in'] = post('time_in', true);
        $data['time_out'] = post('time_out', true);
        $data['job_hours'] = post('job_hours', true);
        $data['member_id'] = post('member_id', true);
        $data['cost_code'] = post('cost_code', true);
        $data['job_code'] = post('job_code', true);
      
        return $data;
    }

    function _get_data_from_post_add(): array {
        $data['job_date'] = post('job_date', true);
        $data['job_name'] = post('job_name', true);
        $data['time_in'] = post('time_in', true);
        $data['cost_code'] = post('cost_code', true);
       
        return $data;
    }

    function _get_data_from_post_edit(): array {
        $data['job_date'] = post('job_date', true);
        $data['job_name'] = post('job_name', true);
        $data['time_in'] = post('time_in', true);
        $data['time_out'] = post('time_out', true);
        $data['cost_code'] = post('cost_code', true);
       
        return $data;
    }
}
