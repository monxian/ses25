<?php
class Requests extends Trongate {

    function __construct() {
        parent::__construct();
        $this->parent_module = 'truck_inventories';
        $this->child_module = 'requests';
    }


    function index() {
        $this->module('members');
        $allowed_levels = [3, 4, 5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }

        //flush out any unsed(cancelled) request
       /*  $sql = 'DELETE FROM parts_request
                WHERE canceled = 1
                AND request_date < NOW() - INTERVAL 2 DAY';
        $this->model->query($sql); */

        $sql = 'SELECT *
                FROM parts_request
                WHERE member_id = :member_id
                ORDER BY request_date DESC
                LIMIT 10';
        $query_data['member_id'] = $member_obj->id;
        $data['rows'] = $this->model->query_bind($sql, $query_data, 'object');

        $data['heading'] = "Request Parts";

        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'truck_inventories/requests';
        $data['view_file'] = 'entry';
        $this->template('ses', $data);
    }

    function request2() {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [5, 6], true);

        if (!$member_obj) {
            $this->module('authorize');
            $this->authorize->restricted();
        }


        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'truck_inventories/requests';
        $data['view_file'] = 'request_full_form';
        $this->template('ses', $data);
    }

    function fulfill_request() {
        $this->module('members');
        $allowed_levels = [3, 4, 5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }

        $request_id = segment(3);
        $query_data['request_id'] = $request_id;
        $sql2 = 'SELECT
                    parts_request.*,
                    members.first_name 
                 FROM
                    parts_request
                 LEFT OUTER JOIN
                    members
                 ON
                    parts_request.member_id = members.id
                 WHERE parts_request.id = :request_id';
        $request_form = $this->model->query_bind($sql2, $query_data, 'object');
        $data['request_form'] = $request_form;

        $sql = 'SELECT
                    parts_request_list.*,
                    products.name,
                    products.part_number,
                    products.description,
                    products.maker_id,
                    makers.maker_name 
                FROM
                    parts_request_list
                LEFT OUTER JOIN
                    products
                ON
                    parts_request_list.product_id = products.id
                LEFT OUTER JOIN
                    makers
                ON
                    products.maker_id = makers.id
                WHERE parts_request_list.request_id = :request_id';
        $data['products'] = $this->model->query_bind($sql, $query_data, 'object');

        $data['heading'] = 'Requested Parts';
        $data['request_form'] = $request_form;

        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'truck_inventories/requests';
        $data['view_file'] = 'request_full_form';
        $this->template('ses', $data);
    }

    function fulfill_item() {
        http_response_code(200);
        $item_id = (int) segment(3);
        $request_id = (int) segment(4);

        $item_from_db = $this->model->get_one_where('id', $item_id, 'parts_request_list');

        if ($item_from_db->pulled) {
            $pulled = 0;
            $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                        <g fill="none" stroke="#df2020" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="#df2020">
                            <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2S2 6.477 2 12s4.477 10 10 10" />
                            <path d="M12.008 10.508a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3m0 0V7m3.007 8.02l-1.949-1.948" />
                        </g>
                      </svg>';
        } else {
            $pulled = 1;
            $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                        <g fill="none" stroke="#00e600" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="#00e600">
                            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12s4.477 10 10 10s10-4.477 10-10" />
                            <path d="m8 12.5l2.5 2.5L16 9" />
                        </g>
                    </svg>';
        }

        $query_data['pulled'] = $pulled;
        $this->model->update($item_id, $query_data, 'parts_request_list');

        //See if there are any unfulfilled items in request
        $sql = 'SELECT COUNT(*) AS not_pulled_count
                FROM parts_request_list
                WHERE pulled = 0 AND request_id = :request_id';

        $query_data_2['request_id'] = $request_id;
        $count = $this->model->query_bind($sql, $query_data_2, 'object');


        if ($count[0]->not_pulled_count > 0) {
            $param['fulfilled'] = 0;
        } else {
            $param['fulfilled'] = 1;
        }
        $this->model->update($request_id, $param, 'parts_request');

        echo $icon;
    }


    function new_form() {
        $this->module('members');
        $allowed_levels = [3, 4];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }     

        $data['loc'] = "truck_inventories-requests/submit_new_form";
        $data['cancel'] = 'truck_inventories-requests';

        $data['heading'] = "New Request";

        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'truck_inventories/requests';
        $data['view_file'] = 'new_form';
        $this->template('ses', $data);
    }

    function add_to_list() {
        http_response_code(200);
        $this->module('members');
        $allowed_levels = [3, 4, 5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }

        $request_id = segment(3);
        $request = $this->model->get_one_where('id', $request_id, 'parts_request');
        $data['request'] = $request;

        $data['list_sum'] = $this->model->count_where('request_id', $request->id, '=', 'parts_request_list');

        $data['heading'] = "Add to List";

        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'truck_inventories/requests';
        $data['view_file'] = 'add_to_list';
        $this->template('ses', $data);
    }

    public function search_request_mx() {
        http_response_code(200);
        $query = post('query', true);

        if (strlen($query) > 2) {
            $sql = 'SELECT
                        products.id,
                        products.name,
                        products.part_number,
                        products.description,
                        products.maker_id,
                        products.qty,                    
                        makers.maker_name 
                    FROM
                        products
                    LEFT OUTER JOIN
                        makers
                    ON
                        products.maker_id = makers.id
                    WHERE products.part_number
                    LIKE :search_query';
            $query_data['search_query'] = '%' . $query . '%';
            $data['rows'] = $this->model->query_bind($sql, $query_data, 'object');
        }

        $data['request_code'] = segment(3);

        $this->view('search_result', $data);
    }

    //modal for purpose and quantity
    public function add_request_mx() {
        http_response_code(200);
        $product_id = segment(3);
        $request_id = segment(4);

        $row = $this->model->get_one_where('id', $product_id, 'products');
        $loc = "truck_inventories-requests/submit_request_rows/" . $request_id;

        $html = '<div class="modal-header-info text-center p8"><h3>Request Parts</h3></div>';
        $html .= form_open($loc, array('class' => 'modal-form'));
        $html .= '<div class="p8 text-primary"><div class="flex pt8"><h2>' . $row->name . '</h2></div>';
        $html .= '<div class="flex pb8"><h3>#' . $row->part_number . '</h3></div></div>';

        $html .= form_hidden('product_id', $row->id);

        $html .= '<div class="modal-form-group">';
        $html .=  form_label('Quantity', array("for" => "qty"));
        $html .=  form_number('qty', 1, array("id" => "qty"));
        $html .= '</div>';

        $html .= '<div class="modal-btn-group">';
        $html .= form_submit('submit', 'Add to Form', array("class" => "btn-primary-45"));
        $html .= '<button  type="button" onclick="closeModal()" class="btn-modal-secondary">Cancel</button>';
        $html .= '</div>';
        $html .= form_close();
        echo $html;
    }


    // Add to request list manually when product not found in database.
    function add_manual() {
        $this->module('members');
        $allowed_levels = [3, 4];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }

        $data['loc'] = 'truck_inventories-requests/submit_add_manual/'.segment(3);  
        $data['cancel'] = 'truck_inventories-requests/add_to_list/' . segment(3);   

        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'truck_inventories/requests';
        $data['view_file'] = 'add_to_list_manual';
        $this->template('ses', $data);
    }
    function submit_add_manual() {     
        $this->module('members');
        $allowed_levels = [3, 4];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }

        $request_id = segment(3);

        
        $submit = post('submit', 'true');
        
        if ($submit == 'Submit') {         
        
            $this->validation_helper->set_rules('part_name', 'part name', 'required');
        
            $result = $this->validation_helper->run();
        
            if ($result == true) {
                $params['request_id'] = $request_id;
                $params['custom_name'] = post("part_name", true);
                $params['custom_num'] = post("part_num",  true);
                $params['qty']  = post("part_qty", true);

                $this->model->insert($params, 'parts_request_list');

                redirect('truck_inventories-requests/add_to_list/'.$request_id);
                
            } else {
                redirect('truck_inventories-requests/add_to_list/' . $request_id);
            }
        //set_flashdata($flash_msg);
        //redirect('store_accounts/show/'.$update_id);
        } else {
            redirect('truck_inventories-requests/add_to_list/' . $request_id);
        }
    }

    function submit_new_form() {
        $this->module('members');
        $allowed_levels = [3, 4, 5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }


        $submit = post('submit', 'true');

        if ($submit == 'Next') {
          
            $truck_stock = post('purpose', true);
            $data['truck_stock'] = $truck_stock == 'truck' ? 1 : 0;
            $query_data['request_name'] = post('request_name', true);
            $query_data['notes'] = post('notes', true);
            $query_data['request_date'] = time();
            $query_data['member_id'] = $member_obj->id;

            $update_id = $this->model->insert($query_data, 'parts_request');

            redirect('truck_inventories-requests/show/' . $update_id);
        } else {
        }
    }


    function submit_request_rows() {
        $this->module('members');
        $allowed_levels = [3, 4, 5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }

        $submit = post('submit', 'true');

        if ($submit == 'Add to Form') {
            $request_id = segment(3);


            $product_id = post('product_id', true);
            $item = $this->model->get_one_where('id', $product_id, 'products');

            $param_data['custom_name'] = $item->description;
            $param_data['custom_num'] = $item->part_number;

            $param_data['product_id'] = $product_id;
            $param_data['qty'] = post('qty', true);
            $param_data['request_id'] = $request_id;

            $this->model->insert($param_data, 'parts_request_list');

            $update_data['canceled'] = 0;
            $this->model->update($request_id, $update_data, 'parts_request');

            redirect('truck_inventories-requests/add_to_list/' . $request_id);
        } else {
            redirect(BASE_URL);
        }
    }

  
    function show() {
        $this->module('members');
        $allowed_levels = [3, 4, 5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }

        $request_id = segment(3);
        $request_form = $this->model->get_one_where('id', $request_id, 'parts_request');

        $sql = 'SELECT
                    parts_request_list.*,
                    products.name,
                    products.part_number,
                    products.description,
                    products.maker_id,
                    makers.maker_name 
                FROM
                    parts_request_list
                LEFT OUTER JOIN
                    products
                ON
                    parts_request_list.product_id = products.id
                LEFT OUTER JOIN
                    makers
                ON
                    products.maker_id = makers.id
                WHERE parts_request_list.request_id = :request_id';
        $query_data['request_id'] = $request_id;
        $data['products'] = $this->model->query_bind($sql, $query_data, 'object');

        $data['heading'] = 'Requested Parts';
        $data['back'] = 'truck_inventories-requests';
        $data['request_form'] = $request_form;

        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'truck_inventories/requests';
        $data['view_file'] = 'show_form';
        $this->template('ses', $data);
    }

    public function delete_modal(): void {
        http_response_code(200);
        $request_id = segment(3);
        $html = '<div class="modal-header-danger text-center p8"><h3>Deleting Job</h3></div>';
        $html .= '<div class="text-center pt16"><p>Are you sure you want to delete this request?</p></div>';
        $html .= '<div class="flex align-center justify-between p8">';
        $html .= '<a class="button btn-danger" href="truck_inventories-requests/delete_request/' . $request_id . '">Delete</a>';
        $html .= '<button type="button" onclick="closeModal()" class="btn-modal-secondary">Cancel</button>';
        $html .= '</div>';

        echo $html;
    }

    function delete() {
        $this->module('members');
        $allowed_levels = [3, 4];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">You do not own request. Shame!</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }

        $delete_id = (int) segment(3);
        $this->model->delete($delete_id, 'parts_request_list');

        redirect('truck_inventories-requests');
    }

    function delete_request() {
        $delete_id = (int) segment(3);
        $sql = 'DELETE FROM parts_request_list
                WHERE request_id = :request_id';

        $query_data['request_id'] = $delete_id;
        $this->model->query_bind($sql, $query_data);

        $this->model->delete($delete_id, 'parts_request');

        redirect('truck_inventories-requests');
    }


    function fulfill_center() {
        $this->module('members');
        $allowed_levels = [5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">You do not own request. Shame!</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }

        $sql = 'SELECT
                    members.first_name as first_name,
                    parts_request.* 
                FROM
                    parts_request
                LEFT OUTER JOIN
                    members
                ON
                    parts_request.member_id = members.id
                WHERE fulfilled = 0 
                AND sent = 1';
        $data['pending_fulfill'] = $this->model->query($sql, 'object');

        $data['heading'] = 'Parts Requested';
        $data['back'] = 'truck_inventories-requests/fulfill_center';

        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'truck_inventories/requests';
        $data['view_file'] = 'fulfill_center';
        $this->template('ses', $data);
    }


    function email_request() {
        $request_id = segment(3);

        $sql = 'SELECT parts_request.*, members.first_name, members.email_address
                FROM parts_request
                LEFT JOIN members ON parts_request.member_id = members.id
                WHERE parts_request.id = :request_id';
        $params['request_id'] = $request_id;
        $request_info = $this->model->query_bind($sql, $params, 'object');


        //update the fulfill_center with sent being true
        $update_id = $this->model->update($request_id, array('sent' => '1'), 'parts_request');

        if ($update_id) {
            $this->module('mailman');

            $data['subject'] = 'Parts Request';
            $data['target_name'] = $request_info[0]->first_name;
            $data['target_email'] = 'brent@sesalarms.com';
            $data['msg_html'] = $this->view('msg_request_sent', $data, true);
            $msg_plain = str_replace('</p>', '\\n\\n', $data['msg_html']);
            $data['msg_plain'] = strip_tags($msg_plain);
            $data['success_redirect'] = 'truck_inventories-requests';

            $this->mailman->_send_my_email($data);
        }
        redirect('truck_inventories-requests');
    }


    //update pulled qty 
    function update_pull() {
        $action = segment(3);
        $list_id = (int)segment(4);
        $request_id = (int)segment(5);

        //get parts_request_list
        $part_requested = $this->model->get_one_where('id', $list_id, 'parts_request_list');

        $qty_requested = (int)$part_requested->qty;
        $pulled_qty = (int)$part_requested->pulled_qty;

        $pending_icon = ' <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                <g fill="none" stroke="#df2020" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="#df2020">
                                <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2S2 6.477 2 12s4.477 10 10 10" />
                                <path d="M12.008 10.508a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3m0 0V7m3.007 8.02l-1.949-1.948" />
                            </g>
                        </svg>';
        $icon_color = 'text-danger';


        //all parts pulled false
        $status = 0;
        if ($action == 'add') {
            $qty_adjusted = $pulled_qty + 1;

            if ($qty_adjusted <= $qty_requested) {
                // is partially pulled still true, if not pull is completed
                if ($qty_requested == $qty_adjusted) {
                    $status = 1;
                    $params['partial_pull'] = 0;
                    $params['pulled'] = 1;
                    $pending_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                        <g fill="none" stroke="#00e600" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="#00e600">
                                            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12s4.477 10 10 10s10-4.477 10-10" />
                                            <path d="m8 12.5l2.5 2.5L16 9" />
                                        </g>
                                    </svg>';
                }

                $params['pulled_qty'] = $qty_adjusted;
                $this->model->update($list_id, $params, 'parts_request_list');

                // add or update truck inventory last argument is are we adding  
                $this->_update_truck_inventory($request_id, $part_requested->product_id, 'true');
            } else {
                $qty_adjusted = $pulled_qty;
                $pending_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                    <g fill="none" stroke="#00e600" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="#00e600">
                                        <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12s4.477 10 10 10s10-4.477 10-10" />
                                        <path d="m8 12.5l2.5 2.5L16 9" />
                                    </g>
                                 </svg>';
            }
        } else {
            //subtracting pulled parts
            if ($pulled_qty > 0) {
                $qty_adjusted = $pulled_qty - 1;
                $params['partial_pull'] = 1;
                $params['pulled'] = 0;
                $params['pulled_qty'] = $qty_adjusted;
                $this->model->update($list_id, $params, 'parts_request_list');

                // subtract from truck inventory last argument is are we adding             
                $this->_update_truck_inventory($request_id, $part_requested->product_id, 'false');
            } else {
                $qty_adjusted = $part_requested->pulled_qty;
            }
        }

        //Is the request fulfilled in other words are all the items pulled?  
        //If they are lets update the  fulfilled and fulfilled date on the parts_request
        $sql = 'SELECT 
                NOT EXISTS (
                    SELECT 1 
                    FROM parts_request_list 
                    WHERE request_id = :request_id AND pulled = 0
                ) AS all_pulled';

        $fulfill['request_id'] = $request_id;
        $any_unpulled_items = $this->model->query_bind($sql, $fulfill, 'object');

        if ($any_unpulled_items[0]->all_pulled) {
            //update parts_request
            $parts_request['fulfilled'] = 1;
            $parts_request['fulfilled_time'] = time();
            $parts_request['fulfilled_date'] = date('Y-m-d');
            $this->model->update($request_id, $parts_request, 'parts_request');
        }





        $html = '<div id="server-content">' . $qty_adjusted . '</div>';
        $html .= '<div id="server-status">' . $pending_icon . '</div>';
        echo $html;
    }

    //update the truck of the tech when a item is pulled for them
    function _update_truck_inventory($request_id = 63, $product_id = 38, $add = true) {
        $request = $this->model->get_one_where('id', $request_id, 'parts_request');
        $member_id = (int)$request->member_id;
        // get the truck id 
        $truck = $this->model->get_one_where('member_id', $member_id, 'truck_assign');

        $sql = 'SELECT *
                FROM truck_inv
                WHERE product_id= :product_id AND truck_id = :truck_id';
        $params['product_id'] = (int)$product_id;
        $params['truck_id'] = (int)$truck->id;
        $on_truck_already = $this->model->query_bind($sql, $params, 'object');



        if ($on_truck_already) {
            if ($add == 'true') {
                $update_query['qty'] = $on_truck_already[0]->qty + 1;
            } else {
                $update_query['qty'] = $on_truck_already[0]->qty - 1;
            }
            $this->model->update($on_truck_already[0]->id, $update_query, 'truck_inv');
        } else {
            $query_data['qty'] = 1;
            $query_data['truck_id'] = $truck->id;
            $query_data['product_id'] = $product_id;
            $this->model->insert($query_data, 'truck_inv');
        }
    }

    function search() {
        $this->module('members');
        $allowed_levels = [3, 4, 5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }

        //only allow members to search their request
        $member_id = $member_obj->id;
        $data['heading'] = 'Search Request';

        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'truck_inventories/requests';
        $data['view_file'] = 'search';
        $this->template('ses', $data);
    }

    function submit_search() {
        $this->module('members');
        $allowed_levels = [3, 4, 5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }

        $search_member = segment(3);

        if ($member_obj->id != $search_member) {
            $user_level = $member_obj->user_level_id;
            if ($user_level < 4) {
                redirect('truck_inventories-requests');
                die();
            }
        }

        $query = post('query', true);
        $result = $this->_handleInput($query);

        $html = '';
        if ($result['type'] === 'date') {
            $sql = 'SELECT parts_request.*, members.first_name 
                    FROM parts_request
                    JOIN members on members.id = parts_request.member_id 
                    WHERE fulfilled_date = :query_date';
            $data['query_date'] = $result['value'];
            $records_found = $this->model->query_bind($sql, $data, 'object');
         
           
        } else {
            $sql = 'SELECT parts_request.*, members.first_name 
                    FROM parts_request
                    JOIN members on members.id = parts_request.member_id 
                    WHERE parts_request.request_name LIKE :request_query';
           
            $data2['request_query'] = '%' . $result['value'] . '%';          
            $records_found = $this->model->query_bind($sql, $data2, 'object');
        }


        if ($records_found) {
            foreach ($records_found as $item) {
                $html .=  '<div class="p8 m8-block round-sm bg-secondary flex align-center justify-between">';
                $html .=  '<div>';
                $show_name = $item->request_name ? $item->request_name : 'Request Made';
                $html .=  '<p>' . $show_name . '</p>';
                $html .=  '<p class="xsmall-text">' . date('m-n-Y', $item->request_date) . ' by ' . $item->first_name . '</p>';
                $html .=  '</div><div class="flex">';
                $html .=  anchor(
                    'truck_inventories-requests/fulfill_request/' . $item->id,
                    '<svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor"><path d="M20.46 17.515c.36.416.54.624.54.985s-.18.57-.54.985C19.56 20.52 17.937 22 16 22s-3.561-1.48-4.46-2.515c-.36-.416-.54-.623-.54-.985c0-.361.18-.57.54-.985C12.44 16.48 14.063 15 16 15s3.561 1.48 4.46 2.515"/><path d="M20 13.003V7.82c0-1.694 0-2.54-.268-3.217c-.43-1.087-1.342-1.945-2.497-2.35C16.517 2 15.617 2 13.818 2c-3.148 0-4.722 0-5.98.441c-2.02.71-3.615 2.211-4.37 4.114C3 7.74 3 9.221 3 12.185v2.546c0 3.07 0 4.605.848 5.672c.243.305.53.576.855.805c.912.643 2.147.768 4.297.792"/><path d="M3 12a3.333 3.333 0 0 1 3.333-3.333c.666 0 1.451.116 2.098-.057A1.67 1.67 0 0 0 9.61 7.43c.173-.647.057-1.432.057-2.098A3.333 3.333 0 0 1 13 2m2.992 16.5h.01"/></g></svg>',
                    array('class' => 'alert-info p4 round-sm')
                );
                $html .=  '</div></div>';
                echo $html;
            }
        } else {
            $html .= 'no records found';
        }
    }

    function _handleInput($input) {      
        $date = DateTime::createFromFormat('m-d-Y', $input);

        if ($date && $date->format('m-d-Y') === $input) {
            // Input is a date, convert to timestamp
            $date_for_sql = $date->format('Y-m-d');
            return [
                'type' => 'date',
                'value' => $date_for_sql
            ];
        } else {
            // Input is plain text
            return [
                'type' => 'text',
                'value' => $input
            ];
        }
    }



    function __destruct() {
        $this->parent_module = '';
        $this->child_module = '';
    }
}
