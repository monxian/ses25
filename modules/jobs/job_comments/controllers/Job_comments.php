<?php
class Job_comments extends Trongate {

    function __construct() {
        parent::__construct();
        $this->parent_module = 'jobs';
        $this->child_module = 'job_comments';
    }

    function index() {
        $this->module('members');
        $allowed_levels = [3, 4];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }

        $data['member_id'] = $member_obj->id;

        $job_code = segment(3);
        $data['job'] = $this->model->get_one_where('job_code', $job_code, 'jobs');
        $comments = $this->model->get_many_where('job_code', $job_code, 'job_comments');

        foreach ($comments as $item) {
            $timestamp = strtotime($item->comment_date);
            $formattedDate = date('M j, Y', $timestamp);
            $item->comment_date = $formattedDate;
            $item->editable = $member_obj->id == $item->member_id ? true : false;
        }


        $data['member_obj'] = $member_obj;
        $data['comments'] = $comments;
        $data['view_module'] = 'jobs/job_comments';
        $data['view_file'] = 'display';
        $this->template('ses', $data);
    }


    public function add_comment_modal(): void {
        http_response_code(200);
        $update_id = segment(3);

        $is_int = false;
        if (is_numeric($update_id)) {
            $is_int = true;
        }

        if ($is_int) {
            $job_comments = $this->model->get_one_where('id', $update_id, 'job_comments');
            $action = 'Update';
            $form_loc = BASE_URL . 'jobs-job_comments/update_comment/' . $update_id;
        } else {
            $action = 'Add';
            $form_loc =  BASE_URL . 'jobs-job_comments/add_comment/' . $update_id;
        }

        $html = '<div class="modal-header-info text-center p8"><h3>' . $action . ' Comment</h3></div>';
        $html .= form_open($form_loc, array('class' => 'modal-form'));
        $html .= '<div class="modal-form-group">';
        $html .=  form_label('Summary', array("for" => "summary"));
        $html .= '<input type="text" id="summary" name="summary" value="' . out($job_comments->summary) . '"  required></div>';
        $html .= '<div class="modal-form-group">';
        $html .=  form_label('Comment', array('for' => 'comment'));
        $attributes['id'] = 'comment';
        $attributes['rows'] = '6';
        $html .= form_textarea('comment', out($job_comments->comment), $attributes);
        $html .= '</div>';

        $html .= '<div class="modal-btn-group">';
        $html .= form_submit('Submit', 'submit', array("class" => "btn-primary-45"));
        $html .= '<button  type="button" onclick="closeModal()" class="btn-modal-secondary">Cancel</button>';
        $html .= '</div>';
        $html .= form_close();


        echo $html;
    }

    function add() {
        $this->module('members');
        $allowed_levels = [3, 4];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted </div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }

        $job_code = segment(3);     

        $job = $this->model->get_one_where('job_code', $job_code, 'jobs');
        $data['job_name'] = $job->job_name;
        $data['loc'] = 'jobs-job_comments/add_comment/'.$job_code; 

        $data['member_obj'] = $member_obj;
        $data['view_file'] = 'add';
        $this->template('ses', $data);
    }


    public function add_comment() {
        $this->module('members');
        $allowed_levels = [3, 4];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            redirect(BASE_URL);
        }
        $member_id = $member_obj->id;

        $job_code = segment(3);
        $job = $this->model->get_one_where('job_code', $job_code, 'jobs');

        $sent_from = post('sent_from', true);
        if($sent_from == 'close'){
            $from_close = true;
        }

        $data['job_code'] = $job->job_code;
        $data['job_name'] = $job->job_name;
        $data['member_id'] = $member_id;

        $data['summary'] = post('summary', true);
        $data['comment'] = post('comment', true);
        $data['comment_date'] = date('Y-m-d');

        $this->model->insert($data, 'job_comments');

        if($from_close){
            //check if tech has a truck to perform inventory
            $tech_has_truck = $this->model->count_where('member_id', $member_id, '=','truck_assign');            
            if($tech_has_truck){
                $flash_msg = '<a href="jobs/day_view" class="flex align-center justify-center alert-success round-sm p8 mt8 no-decoration med-text" id="flash-msg">Adjust Inventory or click to SKIP. </a>';
                set_flashdata($flash_msg);
                redirect('truck_inventories/show/close');        
            } else {
                redirect('jobs/day_view');
            }
          
        }      

        redirect(BASE_URL . 'jobs-job_comments/index/' . $job->job_code);
    }
    
    public function update_comment() {
        $this->module('members');
        $allowed_levels = [3, 4];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            redirect(BASE_URL);
        }

        $update_id = segment(3);

        $data['summary'] = post('summary', true);
        $data['comment'] = post('comment', true);
        $data['comment_date'] = date('Y-m-d');

        $this->model->update($update_id, $data, 'job_comments');
        $job = $this->model->get_one_where('id', $update_id, 'job_comments');

        redirect(BASE_URL . 'jobs-job_comments/index/' . $job->job_code);
    }


    public function delete_comment_modal(): void {
        http_response_code(200);
        $job_code = segment(3);

        $html = '<div class="modal-header-danger text-center p8"><h3>Deleting Comment</h3></div>';
        $html .= '<div class="text-center pt16"><p>Are you sure you want to delete this comment?</p></div>';
        $html .= '<div class="flex align-center justify-between p8">';
        $html .= '<a class="button btn-danger" href="' . BASE_URL . 'jobs-job_comments/delete/' . $job_code . '">Delete</a>';
        $html .= '<button onclick="closeModal()" class="btn-modal-secondary">Cancel</button>';
        $html .= '</div>';

        echo $html;
    }

    public function delete() {
        $this->module('members');
        $allowed_levels = [3, 4];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            redirect(BASE_URL);
        }
        $member_id = $member_obj->id;

        $update_id = (int) segment(3);
        $comment = $this->model->get_one_where('id', $update_id, 'job_comments');

        if ($member_id == $comment->member_id) {
            $this->model->delete($update_id, 'job_comments');
        }

        redirect(BASE_URL . 'jobs-job_comments/index/' . $comment->job_code);
    }

    public function search() {
        $this->module('members');
        $allowed_levels = [3, 4, 5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            redirect(BASE_URL);
        }
        $member_id = $member_obj->id;

        //get last 10 comments      
        $sql = 'SELECT job_comments.*,
                       m.first_name 
                FROM job_comments 
                LEFT JOIN members m on m.id = job_comments.member_id               
                ORDER BY comment_date DESC 
                LIMIT 5';
        $data['last_comments'] = $this->model->query($sql, 'object');

        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'jobs/job_comments';
        $data['view_file'] = 'search';
        $this->template('ses', $data);
    }

    public function search_result() {
        $this->module('members');
        $allowed_levels = [3, 4];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        $query = post('query', true);

        if (strlen($query) > 2) {
            $sql = 'SELECT * FROM job_comments
                WHERE job_name LIKE :search_query
                OR summary LIKE :search_query
               ';
            $data['search_query'] = '%' . $query . '%';
            $data['rows'] = $this->model->query_bind($sql, $data, 'object');
        } else {
            $data['rows'] = [];
        }

        $data['member_obj'] = $member_obj;
        $data['member_id'] = $member_obj->id;
        $this->view('display_search', $data);
    }










    function __destruct() {
        $this->parent_module = '';
        $this->child_module = '';
    }
}
