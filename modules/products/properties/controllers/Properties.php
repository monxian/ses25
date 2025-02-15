<?php
class Properties extends Trongate {

    function __construct() {
        parent::__construct();
        $this->parent_module = 'products';
        $this->child_module = 'properties';
    }

    function index () {
        $data['view_module'] = 'products/properties';
        $this->view('display', $data);
        /* Uncomment the lines below, 
         * Change the template method name, 
         * Remove lines above, if you want to load to the template
         */
        //$data['view_module'] = 'products/properties';
        //$data['view_file'] = 'display';
        //$this->template('template method here', $data);
    }


    function display() {
        $this->module('members');
        $allowed_levels = [5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
        }
        $product_type = segment(3);
        if ($product_type == 'categories') {
            $items = $this->model->get('id', 'categories');
            $heading = "categories";
            $item_name = 'category_name';
        } else {
            $items = $this->model->get('id', 'makers');
            $heading = "makers";
            $item_name = "maker_name";
        }
        $data['items'] = $items;
        $data['item_name'] = $item_name;
      


        $data['heading'] = $heading;
        $data['add_url'] = 'products-properties/add/'.$product_type;

        


        $data['member_obj'] = $member_obj;
        $data['view_file'] = 'cat_maker';
        $this->template('ses', $data);
    }

    function add() {
        $this->module('members');
        $allowed_levels = [5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
        }

        $heading = segment(3);
        $data['heading'] = $heading;
        $data['loc'] = 'products-properties/submit_add/' . $heading;
        $data['cancel'] = 'products-properties/display/'.$heading;

        $data['member_obj'] = $member_obj;
        $data['view_file'] = 'add';
        $this->template('ses', $data); 

    }

    function submit_add() {
        $this->module('members');
        $allowed_levels = [5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
        }
        //category or maker
        $table = segment(3);     
        
        $submit = post('submit', 'true');
        
        if ($submit == 'Submit') {

            if($table == 'categories'){
                $this->validation_helper->set_rules('category_name', 'category name', 'required');
            } else {
                $this->validation_helper->set_rules('maker_name', 'maker name', 'required');              
            }        
        
            $result = $this->validation_helper->run();        
            if ($result == true) {

                if($table == 'categories'){
                    $target_table = 'categories';
                    $params['category_name'] = post('category_name', true);
                } else {
                    $target_table = 'makers';
                    $params['maker_name'] = post('maker_name', true);
                    $params['support_number'] = post('support_number', true);
                }
                $update_id = $this->model->insert($params, $target_table);

                $flash_msg = '<span class="alert alert-success round-sm p8 m16-block flash-msg" id="flash-msg">Successfully Added</span>';
                set_flashdata($flash_msg);
                redirect('products-properties/display/'.$table);    
                
            } else {
                redirect('products-properties/add/'.$table);
            }
        //set_flashdata($flash_msg);
        //redirect('store_accounts/show/'.$update_id);
        } else {
           redirect('products-properties/add/'.$table); 
        }
    }


    function edit() {
        $this->module('members');
        $allowed_levels = [5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
        }

        $heading = segment(3);
        $update_id = segment(4);              

        $item = $this->model->get_one_where('id', $update_id, $heading);  
        $data = (array) $item;

        $column = $heading == 'categories' ? 'category_id' : 'maker_id';
        $exists = $this->model->count_where($column, $update_id, '=', 'products');
        $data['deletable'] = $exists > 0 ? false : true;

        $data['heading'] = $heading;
        $data['loc'] = 'products-properties/submit_edit/' . $heading .'/'.$update_id;
        $data['cancel'] = 'products-properties/display/' . $heading;

        $data['member_obj'] = $member_obj;
        $data['view_file'] = 'edit';
        $this->template('ses', $data);
    }

    function submit_edit() {
        $this->module('members');
        $allowed_levels = [5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
        }
        //category or maker
        $table = segment(3);
        $update_id = segment(4);

        $submit = post('submit', 'true');

        if ($submit == 'Submit') {

            if ($table == 'categories') {
                $this->validation_helper->set_rules('category_name', 'category name', 'required');
            } else {
                $this->validation_helper->set_rules('maker_name', 'maker name', 'required');
            }

            $result = $this->validation_helper->run();
            if ($result == true) {

                if ($table == 'categories') {
                    $target_table = 'categories';
                    $params['category_name'] = post('category_name', true);
                } else {
                    $target_table = 'makers';
                    $params['maker_name'] = post('maker_name', true);
                    $params['support_number'] = post('support_number', true);
                }
                $update_id = $this->model->update($update_id, $params, $target_table);
                $flash_msg = '<span class="alert alert-success round-sm p8 m16-block flash-msg" id="flash-msg">Successfully Updated</span>';
                set_flashdata($flash_msg);
                redirect('products-properties/display/' . $table);
            } else {
                redirect('products-properties/edit/' . $table . '/' . $update_id);
            }
            //set_flashdata($flash_msg);
            //redirect('store_accounts/show/'.$update_id);
        } else {
            redirect('products-properties/edit/' . $table.'/'.$update_id);
        }
    }



    function delete() {
        $this->module('members');
        $allowed_levels = [5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
        }

        $table = segment(3);
        $update_id = segment(4);    

        $column = $table == 'categories' ? 'category_id' : 'maker_id';
        $exists = $this->model->count_where($column, $update_id, '=', 'products');

        if($exists <= 0){
            $this->model->delete($update_id, $table);
            $flash_msg = '<span class="alert alert-danger round-sm p8 m16-block flash-msg" id="flash-msg">Deleted Successfully</span>';
            set_flashdata($flash_msg);         
        } else {
            $flash_msg = '<span class="alert alert-danger round-sm p8 m16-block flash-msg" id="flash-msg">Denied associate with another record</span>';
            set_flashdata($flash_msg);         
        }
       
        redirect('products-properties/display/'.$table);
      
    }


    function __destruct() {
        $this->parent_module = '';
        $this->child_module = '';
    }
}