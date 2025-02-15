<?php
class Service_tickets extends Trongate {

    function index () {     
        $job_code = segment(3);
       
        if($job_code){
            $service_ticket = $this->model->get_one_where('job_code', $job_code, 'service_tickets'); 
            $data['job_code'] = $job_code;
             //ticket data
            $td = json_decode($service_ticket->ticket_data)  ;
            // Accessing "addr-form" properties
            $data['job_name'] = $td->{"addr-form"}->job_name ?? '';
            $data['job_phone'] = $td->{"addr-form"}->job_phone ?? '';
            $data['job_addr'] = $td->{"addr-form"}->job_addr ?? '';
            $data['job_apt'] = $td->{"addr-form"}->job_apt ?? '';
            $data['job_city'] = $td->{"addr-form"}->job_city ?? '';
            $data['job_state'] = $td->{"addr-form"}->job_state ?? '';
            $data['job_county'] = $td->{"addr-form"}->job_county ?? '';          
            $data['job_zip'] = $td->{"addr-form"}->job_zip ?? '';

            // Accessing "account-form" properties
            $data['job_srq'] = $td->{"account-form"}->job_srq ?? '';
            $data['job_acc'] = $td->{"account-form"}->job_acc ?? '';
            $data['job_make'] = $td->{"account-form"}->job_make ?? '';
            $data['job_proposal']= $td->{"account-form"}->job_proposal ?? '';
            $data['job_purchase'] = $td->{"account-form"}->job_purchase ?? '';


            //add parts to the localstorage
            $data['parts'] = $td->parts;

            // Accessing "summary"
            $data['service_summary'] = $td->summary->service_summary ?? '';

            // Accessing "time-form"
            $data['time_ta'] = $td->{"time-form"}->time_ta ?? '';
            $data['time_tc'] = $td->{"time-form"}->time_tc ?? '';
            $data['time_dc'] = $td->{"time-form"}->time_dc ?? '';

            $data['time_tt'] = $td->{"time-ex-form"}->time_tt ?? '';
            $data['time_et'] = $td->{"time-ex-form"}->time_et ?? '';
            $data['time_ot'] = $td->{"time-ex-form"}->time_ot ?? '';

            
            $data['time_sl'] = $td->{"time-ex-form"}->time_sl ?? '';
          

            // Accessing "email-form"
            $data['send_to_email'] = $td->{"email-form"}->send_to_email;
            $data['printed_name'] = $td->printed_name;
         
            $data['show'] = '';
            if($td->image){
                $data['show'] = 'image-active';
                $data['image_data'] = $td->image;
            }       
                   
        }         
        
        $data['job_info'] = $this->model->get_one_where('job_code', $job_code, 'jobs');
        
        $data['view_module'] = 'service_tickets';
        $data['view_file'] = 'display';
        $this->template('ses', $data);
    }

    function save_ticket(){
        $job_code = segment(3);      

        if ($_SERVER["REQUEST_METHOD"] === "POST") {            
            $localStorageData = json_decode(file_get_contents('php://input'), true);                  

            $site_id_for_servticket = 0;
            if ($localStorageData) {

                // Sanitize the entire structure for js
                $sanitizedData = $this->_sanitizeInput($localStorageData);

                if (isset($sanitizedData['addr-form'])) {  
                    $addrFormData = $sanitizedData['addr-form'];
                    $site['site_name'] = isset($addrFormData['job_name']) ? $addrFormData['job_name'] : '';
                    $site['phone'] = isset($addrFormData['job_phone']) ? $addrFormData['job_phone'] : '';
                    $site['addr'] = isset($addrFormData['job_addr']) ? $addrFormData['job_addr'] : '';
                    $site['apt_suite'] = isset($addrFormData['job_apt']) ? $addrFormData['job_apt'] : '';
                    $site['city'] = isset($addrFormData['job_city']) ? $addrFormData['job_city'] : '';
                    $site['state'] = isset($addrFormData['job_state']) ? $addrFormData['job_state'] : '';
                    $site['zip'] = isset($addrFormData['job_zip']) ? $addrFormData['job_zip'] : '';
                    $site['county'] = isset($addrFormData['job_county']) ? $addrFormData['job_county'] : '';

                    //search to see if name - address already in database
                    $sql = 'SELECT * FROM sites
                            WHERE site_name = :job_name
                            AND addr = :job_addr
                            LIMIT 1';
                    $params['job_name'] = $site['site_name'];
                    $params['job_addr'] = $site['addr'];

                    $addr_found = $this->model->query_bind($sql, $params, 'object');

                    if($addr_found[0]->id <= 0){
                        //add new address
                        $site_id_for_servticket = $this->model->insert($site, 'sites');
                    } else {
                        $site_id_for_servticket = $addr_found[0]->id;
                        $this->model->update($site_id_for_servticket, $site, 'sites');
                    }
                }           

                //add info to service ticket table   
                $st_data['job_code'] = $job_code;             
                $st_data['site_id'] = $site_id_for_servticket;
                $st_data['ticket_data'] = json_encode($localStorageData);


                //update or insert new ticket if found
                $exists = $this->model->get_one_where('job_code', $job_code, 'service_tickets');               
                if($exists){
                    $this->model->update($exists->id, $st_data, 'service_tickets');
                } else {
                    $this->model->insert($st_data, 'service_tickets');
                }
                http_response_code(200);
                echo json_encode($sanitizedData);  
            }         
           
        } else {
            http_response_code(400);
            echo json_encode("Something went wrong");
        }   
        die();
    }


    function email_ticket() {
        $job_code = segment(3);     

        $ticket = $this->ticket_html($job_code, true);
        echo $ticket;
        die();
        if ($ticket) {
            $this->module('mailman');

            $data['subject'] = 'Service Ticket';
            $data['target_name'] = 'brent morgan';
            $data['target_email'] = 'brent@sesalarms.com';
            $data['msg_html'] = $ticket;
            $msg_plain = str_replace('</p>', '\\n\\n', $data['msg_html']);
            $data['msg_plain'] = strip_tags($msg_plain);
            $data['success_redirect'] = '';

            $this->mailman->_send_my_email($data);
        }
        return true;
    }

    function ticket_html() {
        $job_code = segment(3);

        //send it off to email if true
        $send_off = segment(4);

        $ticket = $this->model->get_one_where('job_code', $job_code, 'service_tickets');
        $td = json_decode($ticket->ticket_data);        

        foreach ($td as $key => $value) {
            $data['td'][$key] = $value;           
        }

        $data['total_sl_hours'] = $this->_get_total_hours($data['td']['time-form']->time_ta, $data['td']['time-form']->time_tc);

        $data['td']['time-form']->time_ta = $this->convert_time($data['td']['time-form']->time_ta);
        $data['td']['time-form']->time_tc = $this->convert_time($data['td']['time-form']->time_tc);


      

        // Accessing "parts" array
        $html = '';
        $counter = 0;
        foreach ($td->parts as $part) {
            $part_name = $part->name;
            $part_quantity = $part->quantity;
            $part_number = $part->number;

            $html .= '<tr>
                        <td>' . $part_quantity.'</td>
                        <td>'. $part_number.'</td>
                        <td>'. $part_name .'</td>
                     </tr>';
            $counter++;            
        }
        $counter = 5 - $counter;
        if($counter > 0 ){
            for($i = 0; $i < $counter; $i++){
                $html .= '<tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>';
            }
        }
        $data['parts_html'] = $html; 

        if($send_off){
           return $this->view('service_ticket', $data, true); 
           die();
        }
        //Thi shows the file on the screen      
        $this->view('service_ticket', $data);
    }

    function _sanitizeInput($data) {
        if (is_array($data)) {
            // Recursively sanitize each element of the array
            foreach ($data as $key => $value) {
                $data[$key] = $this->_sanitizeInput($value);
            }
        } elseif (is_string($data)) {
            // Sanitize strings by removing HTML and escaping special characters
            $data = htmlspecialchars(strip_tags($data), ENT_QUOTES, 'UTF-8');
        }
        // Non-string types (e.g., integers) are returned as is
        return $data;
    }

    //concvert time to 12hr and am or pm just for presentation
    function convert_time($time_in) {       
        $dateTime = DateTime::createFromFormat('H:i', $time_in);
        $time12 = $dateTime->format('g:i a');
        return $time12;
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


    function ticket_two(){
        $this->module('members');
        $allowed_levels = [3, 4];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }       

        $data['tech_sign'] = BASE_URL. 'members-account_module/imgs/signatures/'.$member_obj->signature.'.png'; 
        $data['tech_name'] = $member_obj->first_name.' '.$member_obj->last_name; 
        $data['job_code'] = segment(3);


        //get any existing data from db 
        

        $data['members_obj'] = $member_obj;
        $data['view_module'] = 'service_tickets';
        $data['view_file'] = 'service_ticket_v2';
        $this->template('ses', $data);
    }


    function save_data() {
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
                $filePath = APPPATH . 'modules/members/account/assets/imgs/signatures/' . $file_name . '.png';


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



    function save_ticket_btns(){

 
        $job_code = segment(3);

        $job = $this->model->get_one_where('job_code', segment(3), 'jobs');

        //was etc set on this job
        $found_etc = $this->model->get_one_where('job_code', segment(3), 'job_etc');


        // 1. Get the JSON data from the request body
        $jsonData = file_get_contents('php://input');       
        $data = json_decode($jsonData, true); // Use true for associative array, false for object

        // 3. Access the data
        if ($data !== null) { // Check if decoding was successful
            $jobData = $data['jobData'];
            $partsData = $data['partsData'];
            $signature = $data['signature'];
            $summaryData = $data['summaryData'];
            $timeData = $data['timeData'];
            $accData = $data['accData'];

           //create new ticket in database


       


            $total_hours = $this->_get_total_hours($timeData['timeTa'], $timeData['timeTc']);
            
            $params['time_out'] = $timeData['timeTc'];
            $params['time_out'] = $timeData['timeTc'];
            $params['job_hours'] = floatval($total_hours);        
            $this->model->update_where('job_code', $job_code, $params, 'jobs');

            if ($found_etc) {
                $this->model->delete($found_etc->id, 'job_etc');
            }

           //add to sites table in database if it's not there all ready.
           $in_db = $this->_store_site_info($jobData);
        
           //adjust iventory
           $test=[];
           foreach($partsData['parts'] as $item){
              
                 
              
           }
         
                     // Example of returning data as JSON:
            $response = array('status' => $in_db, 'message' => 'Data received');
            header('Content-Type: application/json'); // Set the content type header
            echo json_encode($response);

          
        } else {
            // Handle JSON decoding errors
            http_response_code(400); // Bad Request
            echo json_encode(array('status' => 'error', 'message' => 'Invalid JSON data'));
        }

    }

    function _store_site_info($data){
        $query_data['address'] = $data['address'];
        $query_data['name'] = $data['name'];
        $query_data['apt'] = $data['apt'];
        $query_data['city'] = $data['city'];

        $sql = 'SELECT * FROM cust_address
                WHERE LOWER(REPLACE(TRIM(name), "\'", "")) = LOWER(REPLACE(TRIM(:name), "\'", ""))
                AND LOWER(REPLACE(TRIM(address), "\'", "")) = LOWER(REPLACE(TRIM(:address), "\'", ""))
                AND LOWER(city) = LOWER(:city)
                AND LOWER(apt) = LOWER(:apt)';
        $found_address = $this->model->query_bind($sql, $query_data, 'object');

        if(!$found_address){
            $this->model->insert($data, 'cust_address');
            return 'added';
        }            
        return 'exists';
    }

 













}