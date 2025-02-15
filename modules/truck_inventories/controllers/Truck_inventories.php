<?php
class Truck_inventories extends Trongate {

    private $template_to_use = 'ses';

    function show_inven() {        
        $type = segment(4);
        $truck_id = segment(3);

        $result_by = $type == 'all' ? 1 : 0;
        $data['notice'] = $result_by ? 'What should be on your truck!' : 'What\'s actually on your truck.';
        $organizedData = $this->_get_inventory_sort_by_maker($truck_id, $result_by);

        $data['organizedData'] = $organizedData;
        $this->view('truck_inven_list', $data);        
    }

    function index() {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [3, 4], true);
        if (!$member_obj) {
            $this->module('authorize');
            $this->authorize->restricted();
        }

        $data['id'] = $member_obj->id;

        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'truck_inventories';
        $data['view_file'] = 'display';
        $this->template($this->template_to_use, $data);
    }

    public function add_item() {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [3, 4], true);
        if (!$member_obj) {
            $this->module('authorize');
            $this->authorize->restricted();
        }

        $update_id = segment(3);
        $query_data['member_id'] = $member_obj->id;
        $query_data['product_id'] = $update_id;
        $truck_inven_id = $this->model->insert($query_data, 'truck_inventories');

        $html = '<div class="flex flex-col flex-w-1"><div class="p8 text-white">  
                   <p class="small-text">Adjust Quantity On Truck</p>      
                   <div class="flex align-center justify-between">
                        <div class="flex align-center pt8">                                             
                            <div mx-post="truck_inventories/change_qty/add/' . $truck_inven_id . '" mx-target="#part-qty">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36px" height="36px" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.5 12c0-4.478 0-6.718 1.391-8.109S7.521 2.5 12 2.5c4.478 0 6.718 0 8.109 1.391S21.5 7.521 21.5 12c0 4.478 0 6.718-1.391 8.109S16.479 21.5 12 21.5c-4.478 0-6.718 0-8.109-1.391S2.5 16.479 2.5 12M12 8v8m4-4H8" color="currentColor" />
                                </svg>
                            </div>

                            <div class="ml8" mx-post="truck_inventories/change_qty/sub/' . $truck_inven_id  . '" mx-target="#part-qty">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36px" height="36px" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.5 12c0-4.478 0-6.718 1.391-8.109S7.521 2.5 12 2.5c4.478 0 6.718 0 8.109 1.391S21.5 7.521 21.5 12c0 4.478 0 6.718-1.391 8.109S16.479 21.5 12 21.5c-4.478 0-6.718 0-8.109-1.391S2.5 16.479 2.5 12M16 12H8" color="currentColor" />
                                </svg>
                            </div>                       
                        </div>

                    <div class="pl8 large-text"><span class="small-text">qty:</span> <span id="part-qty">0</span></div>
                    </div>
                 </div>';
        $html .= '<div class="modal-btn-group">';
        $html .= '<button type="button" mx-post="truck_inventories/remove_results" mx-target="#item-' . $update_id . '" class="button btn-primary-45 ">Done</button>';
        $html .= '</div></div>';

        echo $html;
    }

    public function remove_results() {
        echo "Item successfully added.";
    }


    function add_to_truck() {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [3, 4], true);
        if (!$member_obj) {
            $this->module('authorize');
            $this->authorize->restricted();
        }

        $data['member_obj'] = $member_obj;
        $data['id'] = segment(4);
        $data['view_module'] = 'truck_inventories';
        $data['view_file'] = 'add_to_truck';
        $this->template($this->template_to_use, $data);
    }

    function search() {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [3, 4, 5, 6], true);
        if (!$member_obj) {
            $this->module('authorize');
            $this->authorize->restricted();
        }

        $search_type = segment(3);

        switch ($search_type) {
            case 'truck':
                $heading = 'Search Your Inventory';
                $mx_path = 'tech_truck';
                break;

                // search all trucks
            default:
                $heading = 'Search All Trucks';
                $mx_path = 'all_trucks';
                break;
        }

        $data['heading'] = $heading;
        $data['mx_path'] = $mx_path;

        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'truck_inventories';
        $data['view_file'] = 'search';
        $this->template($this->template_to_use, $data);
    }


    function search_mx() {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [3, 4, 5, 6], true);
        if (!$member_obj) {
            $this->module('authorize');
            $this->authorize->restricted();
        }


        //This is for adding to inventory looking by maker
        $by_maker = post('by_maker', true);
        $search = $by_maker == 1 ? "by_maker" : segment(3);

        $query = post('query', true);

        $display_view = 'search_partial';
        $searching_truck = true;
        $search_msg = 'Not found on your truck';

        if (strlen($query) > 2) {
            switch ($search) {
                case 'by_maker':
                    $sql =
                        'SELECT
                        products.*,                                
                        makers.id as m_id,
                        makers.maker_name 
                    FROM
                        makers
                    LEFT OUTER JOIN
                        products
                    ON
                        makers.id = products.maker_id
                    WHERE makers.maker_name LIKE :search_query
                    AND products.id NOT IN (SELECT product_id FROM truck_inventories WHERE member_id = :member_id)';
                    $searching_truck = false; //don't search in truck inventories
                    $query_data['search_query'] = '%' . $query . '%';
                    $query_data['member_id'] = $member_obj->id;
                    $search_msg = 'Not found talk to admin &nbsp;';
                    break;
                case 'tech_truck':
                    $truck = $this->model->get_one_where('member_id', $member_obj->id, 'truck_assign');
                    $truck_id = $truck->id;
                    $sql = 'SELECT p.*,
                              ti.*,
                              ti.qty truck_qty
                            FROM products p
                            INNER JOIN truck_inv ti ON p.id = ti.product_id
                            WHERE (p.name LIKE :search_query OR p.part_number LIKE :search_query)
                            AND ti.truck_id = :truck_id';
                    $query_data['search_query'] = '%' . $query . '%';
                    $query_data['truck_id'] = $truck_id;
                    $display_view = 'search_partial';
                    break;

                case 'all_trucks':
                    $sql = 'SELECT
                                truck_inv.id as truck_inv_id,
                                truck_inv.truck_id,
                                truck_assign.id,
                                truck_assign.member_name,
                                products.id,
                                products.name,
                                products.part_number,
                                products.qty as shop_qty,
                                truck_inv.qty as  truck_qty
                            FROM
                                products
                            LEFT OUTER JOIN
                                truck_inv
                            ON
                                products.id = truck_inv.product_id
                            LEFT OUTER JOIN
                                truck_assign
                            ON
                                truck_inv.truck_id = truck_assign.id
                            WHERE (products.name LIKE :search_query OR products.part_number LIKE :search_query) 
                            AND truck_inv.qty > 0
                            GROUP BY
                                products.part_number,
                                truck_assign.member_name';

                    $query_data['search_query'] = '%' . $query . '%';
                    $display_view = 'search_partial_all';
                    $search_msg = 'Not found on any trucks &nbsp;';
                    break;

                default:
                    $sql = 'SELECT * FROM products
                            WHERE (products.name LIKE :search_query
                            OR products.part_number LIKE :search_query)
                            AND products.id NOT IN (SELECT product_id FROM truck_inventories WHERE member_id = :member_id)';
                    $searching_truck = false;
                    $query_data['search_query'] = '%' . $query . '%';
                    $query_data['member_id'] = $member_obj->id;
                    $search_msg = 'Not found &nbsp;';
                    break;
            }

            $rows = $this->model->query_bind($sql, $query_data, 'object');
            if ($display_view == "search_partial_all") {
                $new_array = array();
                foreach ($rows as $item) {
                    $part_number = $item->part_number;
                    if (!isset($new_array[$part_number])) {
                        $new_array[$part_number] = array();
                    }
                    $new_array[$part_number][] = array(
                        "name" => $item->name,
                        "part_number" => $item->part_number,
                        "first_name" => $item->member_name,
                        "qty" => (int) $item->truck_qty
                    );
                }
            }
            $data['found_items'] = $new_array;
            $data['found'] = $rows && $rows[0]->part_number != NULL && $rows[0]->part_number != ''  ? true : false;
            $data['rows'] = $rows;
        } else {
            $data['rows'] = [];
        }

        $data['search_msg'] = $search_msg;
        $data['search_truck'] = $searching_truck;
        $data['member_id'] = $member_obj->id;
        $this->view($display_view, $data);
    }


    public function show() {
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
        $truck = $this->model->get_one_where('member_id', $member_id, 'truck_assign');

        //What if tech doesn't have truck?     
        if ($truck) {
            $organizedData = $this->_get_inventory_sort_by_maker($truck->id, 0);

            $data['organizedData'] = $organizedData;
            $view_to_display = 'show_truck';
        } else {           
            redirect('jobs/day_view');
            die();
        }

        $data['from_close'] = segment(3) == 'close' ? true : false; 
        $data['truck_id'] = $truck->id;     
        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'truck_inventories';
        $data['view_file'] = $view_to_display;
        $this->template($this->template_to_use, $data);
    }

    function _get_inventory_sort_by_maker($truck_id, $return_all = 1 ) {

        if($return_all){
            $sql = 'SELECT
                    truck_inv.id as truck_inv_id,
                    truck_inv.truck_id,
                    truck_inv.qty as truck_qty,
                    truck_inv.low_level,
                    truck_assign.member_id,
                    truck_assign.member_name,
                    products.id AS product_id,
                    products.name AS product_name,
                    products.part_number,
                    products.description,
                    products.qty AS product_qty,
                    products.picture,
                    makers.maker_name 
                FROM
                    truck_inv
                LEFT OUTER JOIN
                    truck_assign ON truck_inv.truck_id = truck_assign.id
                LEFT OUTER JOIN
                    products ON truck_inv.product_id = products.id
                LEFT OUTER JOIN
                    makers ON products.maker_id = makers.id
                WHERE
                    truck_assign.id = :truck_id';
        } else {
            //only return items with qty greater than zero
            $sql = 'SELECT
                    truck_inv.id as truck_inv_id,
                    truck_inv.truck_id,
                    truck_inv.qty as truck_qty,
                    truck_inv.low_level,
                    truck_assign.member_id,
                    truck_assign.member_name,
                    products.id AS product_id,
                    products.name AS product_name,
                    products.part_number,
                    products.description,
                    products.qty AS product_qty,
                    products.picture,
                    makers.maker_name 
                FROM
                    truck_inv
                LEFT OUTER JOIN
                    truck_assign ON truck_inv.truck_id = truck_assign.id
                LEFT OUTER JOIN
                    products ON truck_inv.product_id = products.id
                LEFT OUTER JOIN
                    makers ON products.maker_id = makers.id
                WHERE
                    truck_assign.id = :truck_id 
                AND truck_inv.qty > 0';
        }
       


        $query_data['truck_id'] = $truck_id;
        $rows = $this->model->query_bind($sql, $query_data, 'object');

        // Initialize an empty array to store organized data
        $organizedData = [];
        // Loop through the original array and organize data by maker name
        foreach ($rows as $product) {
            $makerName = $product->maker_name;
            // Check if the maker name already exists as a key in the organized array
            if (!isset($organizedData[$makerName])) {
                // If not, initialize an empty array for this maker
                $organizedData[$makerName] = [];
            }
            // Add the product to the array under the maker name key
            $organizedData[$makerName][] = $product;
        }

        ksort($organizedData);

        return $organizedData;
    }


    public function show_modal() {
        $truck_inv_id = (int) segment(3);
        http_response_code(200);

        $sql = 'SELECT
                    products.*,
                    truck_inv.id truck_inven_id,
                    truck_inv.truck_id,
                    truck_inv.qty as truck_qty,
                    truck_inv.low_level as low_level
                FROM
                    truck_inv
                LEFT OUTER JOIN
                    products
                ON
                    truck_inv.product_id = products.id
                where truck_inv.id = :truck_inv_id';


        $query_data['truck_inv_id'] = $truck_inv_id;
        $product = $this->model->query_bind($sql, $query_data, 'object');

        $html = '<div class="modal-header-info text-center p8">
                   <h3>' . out($product[0]->part_number) . ' </h3>
                   <p><i>' . out($product[0]->name) . '</i></p>
                </div>';

        $html .= '<div class="m8 desc-box">' . nl2br(out($product[0]->description)) . '</div>';

        $html .= '<div class=" m8 p8 round-sm  bg-primary-85 text-primary">  
                   <p class="small-text">Adjust Quantity On Truck</p>      
                   <div class="flex align-center justify-between">
                        <div class="flex align-center pt8">                                             
                            <div
                              mx-post="truck_inventories/change_qty/add/' . out($product[0]->truck_inven_id) . '" 
                              mx-target="#part-qty">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36px" height="36px" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.5 12c0-4.478 0-6.718 1.391-8.109S7.521 2.5 12 2.5c4.478 0 6.718 0 8.109 1.391S21.5 7.521 21.5 12c0 4.478 0 6.718-1.391 8.109S16.479 21.5 12 21.5c-4.478 0-6.718 0-8.109-1.391S2.5 16.479 2.5 12M12 8v8m4-4H8" color="currentColor" />
                                </svg>
                            </div>

                            <div class="ml8" mx-post="truck_inventories/change_qty/sub/' . out($product[0]->truck_inven_id) . '" mx-target="#part-qty">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36px" height="36px" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.5 12c0-4.478 0-6.718 1.391-8.109S7.521 2.5 12 2.5c4.478 0 6.718 0 8.109 1.391S21.5 7.521 21.5 12c0 4.478 0 6.718-1.391 8.109S16.479 21.5 12 21.5c-4.478 0-6.718 0-8.109-1.391S2.5 16.479 2.5 12M16 12H8" color="currentColor" />
                                </svg>
                            </div>                       
                        </div>

                    <div class="pl8 large-text"><span class="small-text">qty:</span> <span id="part-qty">' . out($product[0]->truck_qty) . '</span></div>
                    </div>
                 </div>';

        // Techs can change to level at which a notification goes out
        $html .= '<div class=" m8 p8 round-sm  bg-primary-85 text-primary">  
                   <p class="small-text">Set Limit For Low Qty Alerts</p>      
                   <div class="flex align-center justify-between">
                        <div class="flex align-center pt8">                                             
                            <div mx-post="truck_inventories/change_level/add/' . out($product[0]->truck_inven_id) . '" mx-target="#part-level"
                            mx-after-swap="hello">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36px" height="36px" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.5 12c0-4.478 0-6.718 1.391-8.109S7.521 2.5 12 2.5c4.478 0 6.718 0 8.109 1.391S21.5 7.521 21.5 12c0 4.478 0 6.718-1.391 8.109S16.479 21.5 12 21.5c-4.478 0-6.718 0-8.109-1.391S2.5 16.479 2.5 12M12 8v8m4-4H8" color="currentColor" />
                                </svg>
                            </div>

                            <div class="ml8" mx-post="truck_inventories/change_level/sub/' . out($product[0]->truck_inven_id) . '" mx-target="#part-level">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36px" height="36px" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.5 12c0-4.478 0-6.718 1.391-8.109S7.521 2.5 12 2.5c4.478 0 6.718 0 8.109 1.391S21.5 7.521 21.5 12c0 4.478 0 6.718-1.391 8.109S16.479 21.5 12 21.5c-4.478 0-6.718 0-8.109-1.391S2.5 16.479 2.5 12M16 12H8" color="currentColor" />
                                </svg>
                            </div>                       
                        </div>

                    <div class="pl8 large-text"><span class="small-text">qty:</span> <span id="part-level">' . out($product[0]->low_level) . '</span></div>
                    </div>
                 </div>';

        $html .= '<div class="modal-btn-group">';
        $html .= '<button type="button" onclick="closeModal(' . $product[0]->id . ')" class="button btn-primary-45 ">Done</button>';
        $html .= '</div>';
        $html .= form_close();
        echo $html;
    }

    public function change_qty() {
        $action = segment(3);
        $truck_id = segment(4);

        if ($action == "add") {
            $sql = 'UPDATE truck_inv
                    SET qty = qty + 1
                    WHERE id = :truck_id';
        } else {
            $sql = 'UPDATE truck_inv
                    SET qty = qty - 1
                    WHERE id = :truck_id';
        }

        $data['truck_id'] = $truck_id;
        $this->model->query_bind($sql, $data, 'object');
        $truck_record = $this->model->get_one_where('id', $truck_id, 'truck_inv');

        echo $truck_record->qty;
    }

    public function change_level() {
        $action = segment(3);
        $truck_id = segment(4);

        if ($action == "add") {
            $sql = 'UPDATE truck_inv
                    SET low_level = low_level + 1
                    WHERE id = :truck_id';
        } else {
            $sql = 'UPDATE truck_inv
                    SET low_level = low_level - 1
                    WHERE id = :truck_id';
        }

        $data['truck_id'] = $truck_id;
        $this->model->query_bind($sql, $data, 'object');
        $truck_record = $this->model->get_one_where('id', $truck_id, 'truck_inv');

        echo $truck_record->low_level;
    }


    public function printout() {
        $this->module('members');
        $allowed_levels = [5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }
      
        $data['tech_list']= $this->model->get('id', 'truck_assign');

        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'truck_inventories';
        $data['view_file'] = 'show_techs';
        $this->template($this->template_to_use, $data);
    }



    public function show_by_tech() {
        $this->module('members');
        $allowed_levels = [5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }

        $member_id = segment(3);

        $truck = $this->model->get_one_where('member_id', $member_id, 'truck_assign');
        $truck_id = $truck->id;
        $tech_name = $truck->member_name;

        $sql = 'SELECT
                    products.id,
                    products.name,
                    products.part_number,
                    products.description,
                    makers.maker_name,
                    truck_inv.id as truck_id,
                    truck_inv.qty as truck_qty,
                    truck_inv.low_level as truck_level
                FROM
                    truck_inv
                LEFT OUTER JOIN
                    products
                ON
                    truck_inv.product_id = products.id
                LEFT OUTER JOIN
                    makers
                ON
                    products.maker_id = makers.id

                where truck_inv.truck_id = :truck_id';


        $query_data['truck_id'] = $truck_id;
        $rows = $this->model->query_bind($sql, $query_data, 'object');

        // Initialize an empty array to store organized data
        $organizedData = [];
        // Loop through the original array and organize data by maker name
        foreach ($rows as $product) {
            $makerName = $product->maker_name;
            // Check if the maker name already exists as a key in the organized array
            if (!isset($organizedData[$makerName])) {
                // If not, initialize an empty array for this maker
                $organizedData[$makerName] = [];
            }
            // Add the product to the array under the maker name key
            $organizedData[$makerName][] = $product;
        }

        ksort($organizedData);
        $data['organizedData'] = $organizedData;

        $data['tech_name'] = $tech_name;

        $data['id'] = segment(4);
        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'truck_inventories';
        $data['view_file'] = 'printout';
        $this->template($this->template_to_use, $data);
    }
}
