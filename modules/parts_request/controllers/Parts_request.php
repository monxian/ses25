<?php
class Parts_request extends Trongate {

    function index () {
        $this->module('members');
        $allowed_levels = [3, 4, 5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }
        $data['heading'] = 'Parts Requested';
        $data['member_obj'] = $member_obj->id;

        $sql = 'SELECT pr.*
                FROM parts_request_v2 as pr             
                WHERE pr.member_id = :member_id               
                LIMIT 10';
        $query_data['member_id'] = $member_obj->id;        
        $data['requests'] = $this->model->query_bind($sql, $query_data, 'object');


        $data['member_obj'] = $member_obj->id;      
        $data['view_file'] = 'display';
        $this->template('ses', $data);
    }

    function start() {
        $this->module('members');
        $allowed_levels = [3, 4, 5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }
        
        $data['heading'] = "Request Parts";
        $data['subheading'] = "Start here by adding parts.";
        $data['parts_list'] = [];     
    

        $request_code = make_rand_str(10);
        if(segment(3)){
            //Get old request and parts
            $request_code = segment(3);
            $current_request = $this->model->get_one_where('request_code', $request_code, 'parts_request_v2');          

            if($current_request){
                //get the parts already entered
                $data['parts_list'] = $this->model->get_many_where('request_code', $request_code, 'parts_request_list_v2');
                $request_code = $current_request->request_code;
            }          
        }

        $data['request_code'] = $request_code;
       
        $data['member_obj'] = $member_obj->id;       
        $data['view_file'] = 'start_request';
        $this->template('ses', $data);
    }

    function save_row() {
        $request_code = segment(3);
        $part_name = post('part_name', true);
        $part_num = post('part_num', true);
        $part_qty = post('part_qty', true);

        $params['request_code'] = $request_code;
        $params['part_name'] = $part_name;
        $params['part_num'] = $part_num;
        $params['part_qty'] = $part_qty;

        $update_id = $this->model->insert($params, 'parts_request_list_v2');
        
        $item_id = "'item-$update_id'";
        $html = '<div class="flex align-center justify-between" id="item-'.$update_id.'">                   
                     <div class="ptable-cell">' . $part_qty . '</div>
                     <div class="ptable-cell">' . $part_name . '</div>
                     <div class="ptable-cell">' . $part_num . '</div>   
                     <button 
                        onclick="removeRow('. $item_id.')" 
                        mx-post="parts_request/delete_row/<?= $item->id ?>" 
                        class="btn-danger btn-sm">×</button>                 
                 </div>';   
       
        echo $html;
    }

    function delete_row(){
        $row_id = segment(3, 'int');
        $this->model->delete($row_id, 'parts_request_list_v2');
        echo $row_id;

    }

    function save_request(){
        $this->module('members');
        $allowed_levels = [3, 4, 5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }
        
        $request_code = segment(3);

        //does request already exists
        $exists = $this->model->get_one_where("request_code", $request_code, 'parts_request_v2');
        if(!$exists){
            $params['request_code'] = $request_code;
            $params['member_id'] = $member_obj->id;
            $params['timestamp'] =  time();
            $this->model->insert($params, 'parts_request_v2');
        }     

        redirect('parts_request');
    }

    function send() {
        $this->module('members');
        $allowed_levels = [3, 4, 5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }


        $request_code = segment(3);
        $this->model->update_where('request_code', $request_code, array("sent" => "1"), 'parts_request_v2');


       redirect('parts_request');
    }

    function delete_request() {
        $this->module('members');
        $allowed_levels = [3, 4, 5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }

        $request_code = segment(3);
        
        //Get request from db
        $request = $this->model->get_one_where('request_code', $request_code, 'parts_request_v2');

        if($request->member_id != $member_obj->id){
            redirect('parts_request');
            die();
        }

        $param['request_code'] = $request_code;
        $sql = 'DELETE FROM parts_request_v2
                WHERE request_code = :request_code';
        $this->model->query_bind($sql, $param);

        $sql = 'DELETE FROM parts_request_list_v2
                WHERE request_code = :request_code';
        $this->model->query_bind($sql, $param);

        redirect('parts_request');
        

    }

}