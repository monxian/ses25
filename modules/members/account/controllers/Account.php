<?php
class Account extends Trongate {

    private $template_to_use = 'ses';

    function __construct() {
        parent::__construct();
        $this->parent_module = 'members';
        $this->child_module = 'account';
    }

    function signature() {
        $this->module('members');
        $allowed_levels = [3, 4];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }

        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'members/account';
        $data['view_file'] = 'signature';
        $this->template($this->template_to_use, $data);
    }

    function save_signature() {
        $this->module('members');
        $allowed_levels = [3, 4];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
           echo "not allowed";
           die();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Read the JSON input
            $data = json_decode(file_get_contents('php://input'), true);

            if (isset($data['image'])) {
                // Get the Base64 string
                $imageBase64 = $data['image'];

                // Remove the "data:image/png;base64," part
                $imageBase64 = str_replace('data:image/png;base64,', '', $imageBase64);
                $imageBase64 = str_replace(' ', '+', $imageBase64);

                // Decode the Base64 string
                $imageData = base64_decode($imageBase64);

                $file_name = 'image_' . time();

                // Define the file path to save the image
                $filePath = APPPATH.'modules/members/account/assets/imgs/signatures/' . $file_name . '.png';


                //Should delete the old one if it exists

                $sql = 'UPDATE members
                         SET signature = :file_name
                         WHERE id = :member_id';
                $params['file_name'] = $file_name;
                $params['member_id'] = $member_obj->id;
                $this->model->query_bind($sql, $params);

                // Save the image to the file system
                if (file_put_contents($filePath, $imageData)) {                   
                    echo "Image saved successfully: $filePath";
                } else {
                    echo "Failed to save the image.";
                }
            } else {
                echo "No image data found.";
            }
        } else {
            echo "Invalid request method.";
        }



    }
    function _base64ToImage($base64String, $outputFile) {
        // Extract the Base64 string if it has metadata
        if (str_contains($base64String, 'base64,')) {
            $base64String = explode('base64,', $base64String)[1];
        }

        // Decode the Base64 string
        $decodedData = base64_decode($base64String);

        // Save the decoded data as an image file
        if (file_put_contents($outputFile, $decodedData)) {
            return "Image saved successfully to: $outputFile";
        } else {
            return "Failed to save the image.";
        }
    }

    function login() {
        $this->module('trongate_tokens');
        $this->trongate_tokens->_destroy();
        $data = $this->_get_login_data_from_post();
        $this->view('login', $data);
    }

    function your_account() {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom(NULL , 'account'); 

        if (!$member_obj) {
            redirect(BASE_URL);
        }

        $data['hours_summary'] = $this->_hours_summary($member_obj->id);        
        
        //$data = (array) $member_obj;
        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'members/account';
        $data['view_file'] = 'your_account';
        $this->template($this->template_to_use, $data);        
    }

    function forgot_password() {
        $data['view_module'] = 'members/account';
        $data['view_file'] = 'forgot_password';
        $this->template($this->template_to_use, $data);  
    }

    function update() {
        $this->module('members');
        $token = $this->members->_make_sure_allowed();

        $submit = post('submit');
        if ($submit == 'Submit') {
            $data = $this->_get_data_from_post();
        } else {
            $member_obj = $this->members->_get_member_obj($token);
            $data = (array) $member_obj;
        }

        $data['form_location'] = str_replace('/update', '/submit_update_details', current_url());
        $data['view_module'] = 'members/account';
        $data['view_file'] = 'update_account';
        $this->template($this->template_to_use, $data);        
    }

    function update_password() {
    	$this->module('members');
        $member_obj = $this->members->_get_member_obj();
        if ($member_obj == false) {
            redirect('members/login');
        }

        $password = $member_obj->password;
        if ($password == '') {
            $data['headline'] = 'Please set password';
        } else {
            $data['headline'] = 'Update password';
            $data['cancel_url'] = BASE_URL.'members-account/your_account';
        }

        $data['form_location'] = str_replace('/update', '/submit_update', current_url());
        $data['view_module'] = 'members/account';
        $data['view_file'] = 'update_password';
        $this->template($this->template_to_use, $data);        
    }

    function init_reset_password() {
        $user_token = segment(3);
        if (strlen($user_token) !== 32) {
            redirect('members/ouch');
        } else {
            //attempt to fetch member_obj with user token
            $member_obj = $this->model->get_one_where('user_token', $user_token, 'members');

            if ($member_obj == false) {
                redirect('members/ouch');
            } else {
                $this->module('members');
                $member_id = $member_obj->id;
                $data['password'] = '';
                $this->model->update($member_id, $data, 'members');
                $this->members->_in_you_go($member_id, true);
            }
        }
    }

    function submit_login() {
        $this->validation_helper->set_rules('username', 'username', 'required|callback_login_check');
        $this->validation_helper->set_rules('password', 'password', 'required|min_length[5]');
        $result = $this->validation_helper->run();

        if ($result == true) {
            $params['username'] = post('username');
            $params['email_address'] = post('username');
            $sql = 'SELECT * FROM members WHERE username =:username OR email_address =:email_address';
            $rows = $this->model->query_bind($sql, $params, 'object');
            $member_obj = $rows[0];
            $member_id = $member_obj->id;
            $trongate_user_id = $member_obj->trongate_user_id;
            $remember = post('remember');

            if ($remember == 1) {
                $remember = true;
            } else {
                $remember = false;
            }

            $this->module('members');
            $this->members->_in_you_go($member_id, $remember);

        } else {           
            $flash_msg = '<div class="align-center login-alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                    <path d="M10.5 22c-3.948 0-7-3.134-7-7s3.2-7 7.148-7c2.765 0 5.163 1.537 6.352 3.787" />
                                    <path d="M15 9V6.5a4.5 4.5 0 1 0-9 0v3M13.5 22l3.5-3.5m0 0l3.5-3.5M17 18.5L13.5 15m3.5 3.5l3.5 3.5" />
                                </g>
                            </svg>Username or password incorrect</div>';
            set_flashdata($flash_msg);
            redirect('/');
        }
    }

    function submit_update_details() {
        $this->module('members');
        $token = $this->members->_make_sure_allowed();
        $member_obj = $this->members->_get_member_obj($token);
        $update_id = $member_obj->id;

        $this->validation_helper->set_rules('username', 'username', 'required|min_length[2]|max_length[55]|callback_username_check');
        $this->validation_helper->set_rules('first_name', 'first name', 'required|min_length[2]|max_length[65]');
        $this->validation_helper->set_rules('last_name', 'last name', 'required|min_length[1]|max_length[75]');
        $this->validation_helper->set_rules('email_address', 'email address', 'required|valid_email|callback_email_check');

        $result = $this->validation_helper->run();

        if ($result == true) {

            $data = $this->_get_data_from_post();
            $data['url_string'] = $this->members->_make_unique_url_string($data['username'], $update_id);
            
            //update an existing record
            $this->model->update($update_id, $data, 'members');
            $flash_msg = 'Your account details have been successfully updated';
            
            set_flashdata($flash_msg);
            redirect('members-account/your_account');

        } else {
            //form submission error
            $this->update();
        }
    }

    function submit_update_password() {
    	$this->module('members');
        $member_obj = $this->members->_get_member_obj();

        if ($member_obj == false) {
            redirect('members/login');
        }

        $this->validation_helper->set_rules('password', 'password', 'required|min_length[5]|max_length[35]|callback_password_check');
        $this->validation_helper->set_rules('password_repeat', 'password repeat', 'required|matches[password]');

      if ($this->validation_helper->run()) {
        $data['password'] = $this->_hash_string(post('password'));
        $this->model->update($member_obj->id, $data, 'members');
        $this->update_password_success($member_obj);
      } else {
        //form submission error
        $this->update_password();
      }
    }

    function submit_forgot_password() {
        $this->validation_helper->set_rules('my_vibe', 'form field', 'required|callback_forget_password_check');
        $result = $this->validation_helper->run();

        if ($result == true) {
            //fetch the member obj
            $params['username'] = post('my_vibe');
            $params['email_address'] = post('my_vibe');

            $sql = 'SELECT * FROM members WHERE username =:username OR email_address =:email_address';
            $rows = $this->model->query_bind($sql, $params, 'object');
            $member_obj = $rows[0];

            //create temp token & send reset email
            $this->_init_password_reset($member_obj);

        } else {
            $this->forgot_password();
        }

    }

    function _init_password_reset($member_obj) {
        $this->module('members');
        $data['user_token'] = make_rand_str(32);
        $this->model->update($member_obj->id, $data, 'members');
        $reset_url = BASE_URL.'members-account/init_reset_password/'.$data['user_token'];
        $this->members->_send_password_reset_email($member_obj, $reset_url);
        redirect('members/check_your_email/reset');
    }

    function update_password_success($member_obj) {
      $num_logins = $member_obj->num_logins;
      $flash_msg = $num_logins < 2 ? 'Ahoy! Welcome aboard the fun bus. It\'s great to have you here!' : 'Your password was successfully updated.';
      set_flashdata($flash_msg);
      redirect('members-account/your_account');
    }

    function _hash_string($str) {
        $hashed_string = password_hash($str, PASSWORD_BCRYPT, array(
            'cost' => 11
        ));
        return $hashed_string;
    }

    function _verify_hash($plain_text_str, $hashed_string) {
        $result = password_verify($plain_text_str, $hashed_string);
        return $result; //true or false
    }

    function password_check($str) {
        // *** MODIFY THIS METHOD AND ADD YOUR OWN RULES, AS REQUIRED **
        if (preg_match('/[A-Za-z]/', $str) & preg_match('/\d/', $str) == 1) {
            return true;  // password contains at least one letter and one number
        } else {
            $error_msg = 'The password must contain at least one letter and one number.';
            return $error_msg;
        }
    }

    function _get_data_from_post() {
        $data['username'] = post('username', true);
        $data['first_name'] = post('first_name', true);
        $data['last_name'] = post('last_name', true);
        $data['email_address'] = post('email_address', true);    
        return $data;
    }

    function _get_login_data_from_post() {
        $data['username'] = post('username');
        $data['password'] = post('password');
        $data['remember'] = post('remember');
        return $data;
    }

    function username_check($username) {
        // Check if the username is formatted correctly
        $filtered_name = filter_name($username);

        if ($filtered_name !== $username) {
            $error_msg = 'The username contains characters that are not allowed.';
            return $error_msg;
        }

        // Make sure submitted username is available
        $code = segment(3);
        $update_id = 0;
        $member_obj = $this->model->get_one_where('code', $code, 'members');

        if (is_object($member_obj)) {
            $update_id = $member_obj->id ?? 0;
        }

        if ($update_id === 0) {
            $error_msg = 'The user that you submitted could not be validated.';
            return $error_msg;
        }

        $params['username'] = $username;
        $params['update_id'] = $update_id;
        $sql = 'SELECT COUNT(*) as count FROM members WHERE username =:username AND id !=:update_id';
        $rows = $this->model->query_bind($sql, $params, 'object');
        $count = $rows[0]->count ?? 0;

        if($count>0) {
            $error_msg = 'The submitted username is not available.';
            return $error_msg;        
        }

        return true;
    }


    function email_check($email_address) {
        // Make sure submitted email_address is available
        $code = segment(3);
        $update_id = 0;
        $member_obj = $this->model->get_one_where('code', $code, 'members');

        if (is_object($member_obj)) {
            $update_id = $member_obj->id ?? 0;
        }

        if ($update_id === 0) {
            $error_msg = 'The email address that you submitted could not be validated.';
            return $error_msg;
        }

        $params['email_address'] = $email_address;
        $params['update_id'] = $update_id;
        $sql = 'SELECT COUNT(*) as count FROM members WHERE email_address =:email_address AND id !=:update_id';
        $rows = $this->model->query_bind($sql, $params, 'object');
        $count = $rows[0]->count ?? 0;

        if($count>0) {
            $error_msg = 'The submitted email address is not available.';
            return $error_msg;        
        }

        return true;
    }

    function login_check($str) {
        $error_msg = 'Your username and/or password was not valid.';
        $params['username'] = $str;
        $params['email_address'] = $str;

        $sql = 'SELECT * FROM members WHERE username = :username OR email_address = :email_address';
        $rows = $this->model->query_bind($sql, $params, 'object');

        if(!isset($rows[0])) {
            //invalid username and/or email
            return $error_msg;
        } else {
            //record found, is account confirmed & what about the password?
            $confirmed = $rows[0]->confirmed ?? 0;

            if ($confirmed === 0) {
                return $error_msg;
            }

            $stored_password = $rows[0]->password;
            $password = post('password');
            $password_result = $this->_verify_hash($password, $stored_password);

            if ($password_result == false) {
                //wrong password
                return $error_msg;
            } else {
                //password was correct
                return true;
            }
        }
    }

    function forget_password_check($str) {
        $params['username'] = $str;
        $params['email_address'] = $str;

        $sql = 'SELECT COUNT(*) as count FROM members WHERE username =:username OR email_address =:email_address';
        $rows = $this->model->query_bind($sql, $params, 'object');
        $count = $rows[0]->count ?? 0;

        if($count == 0) {
            $error_msg = 'We could not match the information that you submitted with an account.';
            return $error_msg;        
        }

        return true;
    }

    function _hours_summary($member_id) {

        // Get the first day of the current year
        $firstDay = new DateTime('first day of January this year');
        $start_date = $firstDay->format('Y-m-d');

        // Get the last day of the current year
        $lastDay = new DateTime('last day of December this year');
        $end_date = $lastDay->format('Y-m-d');

      
        // get regular hours minus vacation and holiday
        $params['start_date'] = $start_date; 
        $params['end_date'] = $end_date;
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