<?php
class Memberdb extends Trongate {

    function __construct() {
        parent::__construct();
        $this->parent_module = 'members';
        $this->child_module = 'memberdb';
    }

    function index () {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [6], true);

        if (!$member_obj) {
            $this->module('authorize');
            $this->authorize->restricted();
        }

        $show_all = segment(3);
        if ($show_all) {
            $sql = 'SELECT
                    members.id,
                    members.username,
                    members.first_name,
                    members.last_name,
                    members.email_address,
                    members.confirmed,
                    members.is_tech,
                    members.date_joined,
                    trongate_users.user_level_id,
                    trongate_user_levels.level_title 
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
                ORDER BY last_name asc';

                $msg = 'Showing all members, including disabled';
                $show = 'Only Active';
                $show_link = 'members-memberdb/index';
        } else {
            $sql = 'SELECT
                    members.id,
                    members.username,
                    members.first_name,
                    members.last_name,
                    members.email_address,
                    members.confirmed,
                    members.is_tech,
                    members.date_joined,
                    trongate_users.user_level_id,
                    trongate_user_levels.level_title 
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
                WHERE confirmed = 1              
                ORDER BY last_name asc';

                $msg = 'Showing only active members';
                $show= 'Show All';
                $show_link = 'members-memberdb/index/all';
        }       

      
        
        $fetched_members = $this->model->query($sql, 'object');

        foreach($fetched_members as $member){
            $member->deletable =[];
            if($member->is_tech){
                $has_jobs = $this->model->count_rows('member_id', $member->id, 'jobs');
                $member->deletable = $has_jobs > 0 ? false : true;
            } else {
                $member->deletable = true;
            }

            if($member_obj->id == $member->id){
                $member->deletable = false;
            }

            //add hours
            if($member->is_tech && $member->confirmed == true){
               $hours = $this->_hours_summary($member->id);
               $member->reg = $hours[0]->reg;
               $member->holiday = $hours[0]->holiday;
               $member->vaca = $hours[0]->vaca;
            }
          

        }
        $data['member_rows'] = $fetched_members;

        $data['msg'] = $msg;
        $data['show'] = $show;
        $data['link'] = $show_link;

        $data['member_obj'] = $member_obj;  
       
        $data['view_module'] = 'members/memberdb';
        $data['view_file'] = 'display';
        $this->template('ses', $data);
    }

    function add() {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [6], true);

        if (!$member_obj) {
            $this->module('authorize');
            $this->authorize->restricted();
        }

        $submit = post('submit');
        if ($submit == 'Submit') {
            $data = $this->_get_data_from_post();
        }

        $data['loc'] = 'members-memberdb/submit_update';

        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'members/memberdb';
        $data['view_file'] = 'add';
        $this->template('ses', $data);
    }

    function update() {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [6], true);

        if (!$member_obj) {
            $this->module('authorize');
            $this->authorize->restricted();
        }

        $update_id = segment(3);

        $submit = post('submit');
        if ($submit == 'Submit') {
            $data = $this->_get_data_from_post();
        } else {
            $update_member = $this->model->get_one_where('id', $update_id, 'members');
            $data = (array) $update_member;
        }

        $data['loc'] = 'members-memberdb/submit_update/'.$update_id;

        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'members/memberdb';
        $data['view_file'] = 'update';
        $this->template('ses', $data);
    }

    function update_password() {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [6], true);

        if (!$member_obj) {
            $this->module('authorize');
            $this->authorize->restricted();
        }

        $update_id = segment(3);

        $submit = post('submit');
        if ($submit == 'Submit') {
            $data = $this->_get_data_from_post();
        } else {
            $update_member = $this->model->get_one_where('id', $update_id, 'members');
            $data = (array) $update_member;
        }

        $data['loc'] = 'members-memberdb/submit_password/' . $update_id;

        if($update_member->password == ''){
            $data['heading'] = 'Please set '.$update_member->first_name.'\'s password.';
        } else{
            $data['heading'] = 'Updating ' . $update_member->first_name . '\'s password.';
        }
       

        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'members/memberdb';
        $data['view_file'] = 'up_password';
        $this->template('ses', $data);
    }
    
    function submit_password() {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [6], true);

        if (!$member_obj) {
            $this->module('authorize');
            $this->authorize->restricted();
        } 

        $update_id = segment(3);
        
        $submit = post('submit', 'true');
        
        if ($submit == 'Submit') {
        
            $this->validation_helper->set_rules('password', 'password', 'required');
        
            $result = $this->validation_helper->run();
        
            if ($result == true) {
                $member_info =  $this->model->get_one_where('id', $update_id, 'members');
                $new_member = $member_info->password == '' ? true : false;

                if($new_member){
                    $flash_msg = '<div class="alert-success round-sm p8" id="flashMsg">Member added and password set</div>';
                } else {
                    $flash_msg = '<div class="alert-success round-sm p8" id="flashMsg">Password Updated successfully</div>';
                }

                $pw = post('password', true);
                $data['password'] = $this->_hash_string($pw);
                $this->model->update($update_id, $data, 'members');                       
                
                set_flashdata($flash_msg);
                redirect('members-memberdb');            

            } else {
                redirect('members-memberdb/update_password/' . $update_id);  
            }
        //set_flashdata($flash_msg);
        //redirect('store_accounts/show/'.$update_id);
        } else {
            redirect('members-memberdb/update_password/' . $update_id);
        }
    }


    function _get_data_from_post() {
        $data['username'] = post('username', true);
        $data['first_name'] = post('first_name', true);
        $data['last_name'] = post('last_name', true);
        $data['email_address'] = post('email_address', true);
        $data['confirmed'] = post('confirmed', true);
        return $data;
    }

    function _hash_string($str) {
        $hashed_string = password_hash($str, PASSWORD_BCRYPT, array(
            'cost' => 11
        ));
        return $hashed_string;
    }


    function submit_update() {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [6], true);

        if (!$member_obj) {
            $this->module('authorize');
            $this->authorize->restricted();
        }

        $update_id = (int) segment(3);      
        $submit = post('submit', 'true');
        
        if ($submit == 'Submit') {

            $this->validation_helper->set_rules('username', 'username', 'required|min_length[2]|max_length[55]');
            $this->validation_helper->set_rules('first_name', 'first name', 'required|min_length[2]|max_length[65]');
            $this->validation_helper->set_rules('last_name', 'last name', 'required|min_length[1]|max_length[75]');
            $this->validation_helper->set_rules('email_address', 'email address', 'required|valid_email');
        
            $result = $this->validation_helper->run();
        
            if ($result == true) {                         
                $data = $this->_get_data_from_post();               
                if($update_id > 0){                  
                    $this->model->update($update_id, $data, 'members');
                    $flash_msg = '<div class="alert-success round-sm p8" id="flashMsg">Account details have been successfully updated</div>';
                    set_flashdata($flash_msg);
                    redirect('members-memberdb');
                } else {
                    $data['url_string'] = $this->members->_make_unique_url_string($data['username']);
                    $data['date_joined'] = time();
                    $data['code'] = make_rand_str(16);
                    $data['password'] = '';
                    $data['num_logins'] = 0;
                    $data['last_login'] = 0;
                    $this->module('members');
                    $data['trongate_user_id'] = $this->members->_create_new_trongate_user();
                    $data['confirmed'] = 1;
                    $data['user_token'] = ''; 
                    $data['is_tech'] = 1;

                    $member_id = $this->model->insert($data, 'members');
                  
                    $flash_msg = '<div class="alert-success round-sm p8" id="flashMsg">New member has been added</div>';
                    set_flashdata($flash_msg);
                    redirect('members-memberdb/update_password/'.$member_id);
                }
              
                
            } else {
                if ($update_id) {
                    redirect('members-memberdb/update/' . $update_id);
                } else {
                    redirect('members-memberdb/add');
                }            
                
            }
        //set_flashdata($flash_msg);
        //redirect('store_accounts/show/'.$update_id);
        } else {
            if($update_id){
                redirect('members-memberdb/update/'.$update_id);
            } else {
                redirect('members-memberdb/add');
            }
            
        }
    }



    function delete() {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [6], true);

        if (!$member_obj) {
           $this->module('authorize');
           $this->authorize->restricted();
        }

        $delete_id = (int)segment(3);
        $member_info = $this->model->get_one_where('id', $delete_id, 'members');

        $has_jobs = $this->model->count_rows('member_id', $member_info->id, 'jobs');

        if($has_jobs > 0){
            $flash_msg = '<div class="alert-danger round-sm p8" id="flashMsg">Deletion Restricted</div>';
            set_flashdata($flash_msg);
            redirect('members-memberdb');
        }
       $this->model->delete($member_info->trongate_user_id, 'trongate_users');
       $this->model->delete($member_info->id, 'members');

        $flash_msg = '<div class="alert-success round-sm p8" id="flashMsg">Members successfully deleted</div>';
        set_flashdata($flash_msg);
        redirect('members-memberdb');
    }



    function _hours_summary($member_id) {

        // get regular hours minus vacation and holiday
        $params['start_date'] = '2024-01-01';
        $params['end_date'] = '2024-12-31';
        $params['member_id'] = $member_id;

        $sql = 'SELECT SUM(job_hours) AS reg
                FROM jobs
                WHERE member_id = :member_id 
                AND job_date
                BETWEEN :start_date AND :end_date
                AND cost_code NOT IN (18, 22)';
        $hours = $this->model->query_bind($sql, $params, 'object');


        $sql2 = 'SELECT cost_code, SUM(job_hours) AS non_reg
                 FROM jobs
                 WHERE member_id = :member_id 
                 AND job_date
                 BETWEEN :start_date AND :end_date
                 AND cost_code IN (18, 22)
                 GROUP BY cost_code';
        $vac_holiday_hours = $this->model->query_bind($sql2, $params, 'object');

        $hours[0]->holiday = $vac_holiday_hours[0]->non_reg;
        $hours[0]->vaca = $vac_holiday_hours[1]->non_reg;

        return $hours;
    }
  




    function __destruct() {
        $this->parent_module = '';
        $this->child_module = '';
    }
}