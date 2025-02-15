<?php
class Products extends Trongate {

    private $default_limit = 20;
    private $per_page_options = array(10, 20, 50, 100);


    function gen_excel() {       
        $this->module('members');
        $allowed_levels = [5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }
        http_response_code(200);
       
      
          // Fetch data from the 'products' table
        $sql = 'SELECT p.name, p.part_number, p.qty, p.price
                FROM products as p';
        $rows = $this->model->query($sql, 'object');

        $filename = "products_" . date("Y-m-d_H-i-s") . ".csv";

        // Define the output file path
        $destination = APPPATH . 'modules/products/assets/excel/'.$filename;

        // Open the file for writing
        $file = fopen($destination, 'w');
        if (!$file) {
            die('<p class="p8">Error: Unable to open file for writing.</p>');
        }

        // Add headers to the CSV
        $headers = ['Product Name','Part Number', 'Price', 'Quantity', 'Row Total'];
        fputcsv($file, $headers);

        $rowNumber = 2; // Start from the second row (after headers)
        foreach ($rows as $row) {
            $productName = $row->name;
            $productNumber = $row->part_number;
            $price = $row->price;
            $quantity = $row->qty;

            // Formula for the row total (C2 * D2)
            $rowTotalFormula = "=C$rowNumber*D$rowNumber";

            // Write the row with the formula
            fputcsv($file, [$productName,$productNumber, $price, $quantity, $rowTotalFormula]);

            $rowNumber++;
        }

        // Add a blank row (optional, for clarity)
        fputcsv($file, ["", "", "", "", ""]);

        // Formula for the column sum (sum of all row totals)
        $sumFormula = "=SUM(E2:E" . ($rowNumber - 1) . ")";
        fputcsv($file, ["", "", "", "Total Sum:", $sumFormula]);

        // Close the file
        fclose($file);

        $html = '<div class="p16 round-sm flex flex-col align-center">';
        $html .= '<div class="flex justify-center text-primary pointer dl-close" onclick="closeModal()" >
                  <svg xmlns="http://www.w3.org/2000/svg" width="36px" height="36px" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m15.75 15l-6-6m0 6l6-6m7 3c0-5.523-4.477-10-10-10s-10 4.477-10 10s4.477 10 10 10s10-4.477 10-10" color="currentColor" />
                  </svg>
                  </div>';
        $html .= '<div class="mt16 flex flex-col align-center"><div><p>While this is actually a CSV(comma separated values) file,  </p>';
        $html .= '<p class="mb8 flex">it can be downloaded into excel and saved as an .xlsx file</p></div>';
        $attributes['class'] = 'flex align-center justify-center p8 bg-primary round-sm text-white max-content hover-anchor text-center';
        $tag_decor = '<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.478 9.011h.022c2.485 0 4.5 2.018 4.5 4.508c0 2.32-1.75 4.232-4 4.481m-.522-8.989q.021-.248.022-.5A5.505 5.505 0 0 0 12 3a5.505 5.505 0 0 0-5.48 5.032m10.958.98a5.5 5.5 0 0 1-1.235 3.005M6.52 8.032A5.006 5.006 0 0 0 2 13.018a5.01 5.01 0 0 0 4 4.91m.52-9.896q.237-.023.48-.023c1.126 0 2.165.373 3 1.002M12 21v-8m0 8c-.7 0-2.008-1.994-2.5-2.5M12 21c.7 0 2.008-1.994 2.5-2.5" color="currentColor" />
            </svg>DownLoad Excel File';
        $html .=  anchor('products_module/excel/'.$filename, $tag_decor , $attributes);
       
        $html .= '</div></div>';

        echo $html;
    }


    function display() {
        $this->module('members');
        $allowed_levels = [5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }


        $offset = segment(3) ? (int)segment(3) : 0;
        $limit = 10;

        $sql = 'SELECT * 
                FROM products  
                ORDER BY name asc                    
                LIMIT :limit
                OFFSET :offset';

        $query_data['offset'] = $offset;
        $query_data['limit'] = $limit;
        $data['products'] = $this->model->query_bind($sql, $query_data, 'object');
        $prod_count = $this->model->count('products');

        $data['page'] = $this->paginator($prod_count, $offset, $limit);

        $data['heading'] = 'Products';

        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'products';
        $data['view_file'] = 'display';
        $this->template('ses', $data);
    }
    function display_items() {
        $offset = segment(3) ? (int)segment(3) : 0;
        $limit = 10;

        $sql = 'SELECT * 
                FROM products  
                ORDER BY name asc             
                LIMIT :limit
                OFFSET :offset';

        $query_data['offset'] = $offset;
        $query_data['limit'] = $limit;
        $data['products'] = $this->model->query_bind($sql, $query_data, 'object');
        $prod_count = $this->model->count('products');

        $data['page'] = $this->paginator($prod_count, $offset, $limit);

        $this->view('display2', $data);
    }

    function paginator($t_count, $offset, $limit) {
        $prev = $offset - $limit;
        $next = $offset + $limit;

        $active_page = ceil($offset / $limit);
        $pages = ceil($t_count / $limit);

        $total_items = $next < $t_count ? $next : $t_count;

        $html = '<div class="small-text text-secondary ml16"><i>showing...' . $offset . ' to ' . $total_items . ' of ' . $t_count . '</i></div>';

        $html .= '<div class="flex align-center m8">';

        if ($prev > -1) {
            $html .= '<a mx-get="products/display_items/' . $prev . '" mx-target="#product-list" class="round-xs border p4 m4 text-white no-decoration pointer "> < </a>';
        }

        for ($i = 0; $i < $pages; $i++) {
            $link_offset = $i * $limit;
            $active = $active_page == $i ? "active" : "";
            $html .= '<a mx-get="products/display_items/' . $link_offset . '" mx-target="#product-list" class="round-xs border p4 m4 text-white no-decoration pointer ' . $active . '">' . ($i + 1) . '</a>';
        }

        if ($next < $t_count) {
            $html .= '<a mx-get="products/display_items/' . $next . '" mx-target="#product-list"class="round-xs border p4 m4 text-white no-decoration pointer "> > </a>';
        }

        $html .= "</div>";
        return $html;
    }

    function show_item() {
        http_response_code(200);
        $product_id = segment(3);
        $data['item'] = $this->model->get_one_where('id', $product_id, 'products');

        $this->view('show_product', $data);
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
            $data['categories'] = $this->_get_categories($data['category_id']);
            $data['makers'] = $this->_get_makers($data['maker_id']);
        } else {
            $data = $this->get_data_from_post();
            $data['categories'] = $this->_get_categories($data['category_id']);
            $data['makers'] = $this->_get_makers($data['maker_id']);
        }



        if ($update_id > 0) {
            $data['headline'] = 'Update Product Record';
            $data['cancel_url'] = BASE_URL . 'products/show/' . $update_id;
        } else {
            $data['headline'] = 'Create New Product Record';
            $data['cancel_url'] = BASE_URL . 'products/manage';
        }

        $data['form_location'] = BASE_URL . 'products/submit/' . $update_id;
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
            $params['name'] = '%' . $searchphrase . '%';
            $params['part_number'] = '%' . $searchphrase . '%';
            $params['shelf_location'] = '%' . $searchphrase . '%';
            $params['product_code'] = '%' . $searchphrase . '%';
            $sql = 'select * from products
            WHERE name LIKE :name
            OR part_number LIKE :part_number
            OR shelf_location LIKE :shelf_location
            OR product_code LIKE :product_code
            ORDER BY id';
            $all_rows = $this->model->query_bind($sql, $params, 'object');
        } else {
            $data['headline'] = 'Manage Products';
            $all_rows = $this->model->get('id');
        }

        $pagination_data['total_rows'] = count($all_rows);
        $pagination_data['page_num_segment'] = 3;
        $pagination_data['limit'] = $this->get_limit();
        $pagination_data['pagination_root'] = 'products/manage';
        $pagination_data['record_name_plural'] = 'products';
        $pagination_data['include_showing_statement'] = true;
        $data['pagination_data'] = $pagination_data;

        $data['rows'] = $this->reduce_rows($all_rows);
        $data['selected_per_page'] = $this->get_selected_per_page();
        $data['per_page_options'] = $this->per_page_options;
        $data['view_module'] = 'products';
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
            redirect('products/manage');
        }

        $sql = 'SELECT
                    products.*,
                    categories.category_name,
                    makers.maker_name 
                FROM
                    products
                LEFT OUTER JOIN
                    categories
                ON
                    products.category_id = categories.id
                LEFT OUTER JOIN
                    makers
                ON
                    products.maker_id = makers.id
                WHERE products.id = :product_id';
        $query_data['product_id'] = $update_id;
        $result = $this->model->query_bind($sql, $query_data, 'array');
        $data = $result[0];

        $data['token'] = $token;

        if ($data == false) {
            redirect('products/manage');
        } else {
            //generate picture folders, if required
            $picture_settings = $this->_init_picture_settings();
            $this->_make_sure_got_destination_folders($update_id, $picture_settings);

            //attempt to get the current picture
            $column_name = $picture_settings['target_column_name'];

            if ($data[$column_name] !== '') {
                //we have a picture - display picture preview
                $data['draw_picture_uploader'] = false;
                $picture = $data['picture'];

                if ($picture_settings['upload_to_module'] == true) {
                    $module_assets_dir = BASE_URL . segment(1) . MODULE_ASSETS_TRIGGER;
                    $data['picture_path'] = $module_assets_dir . '/' . $picture_settings['destination'] . '/' . $update_id . '/' . $picture;
                } else {
                    $data['picture_path'] = BASE_URL . $picture_settings['destination'] . '/' . $update_id . '/' . $picture;
                }
            } else {
                //no picture - draw upload form
                $data['draw_picture_uploader'] = true;
            }



            $data['update_id'] = $update_id;
            $data['headline'] = 'Product Information';
            $data['view_file'] = 'show';
            $this->template('admin', $data);
        }
    }

    function _get_categories($product_category_id = null): string {
        $categories = $this->model->get('id', 'categories');

        $html = '<label for="category">Category</label><select name="category_id" id="category">';
        foreach ($categories as $item) {
            if ((int)$item->id == (int)$product_category_id) {
                $html .= '<option value="' . $item->id . '" selected>' . $item->category_name . '</option>';
            } else {
                $html .= '<option value="' . $item->id . '">' . $item->category_name . '</option>';
            }
        }
        $html .= '</select>';
        return $html;
    }

    function _get_makers($product_maker_id = null): string {
        $makers = $this->model->get('maker_name asc', 'makers');

        $html = '<label for="maker">Maker</label><select name="maker_id" id="maker">';
        foreach ($makers as $item) {
            if ((int)$item->id == (int)$product_maker_id) {
                $html .= '<option value="' . $item->id . '" selected>' . $item->maker_name . '</option>';
            } else {
                $html .= '<option value="' . $item->id . '">' . $item->maker_name . '</option>';
            }
        }
        $html .= '</select>';
        return $html;
    }

    function add(): void {
        $this->module('members');
        $allowed_levels = [5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }

        $update_id = (int) segment(3);
        $submit = post('submit');

        if (($submit == '') && ($update_id > 0)) {
            $data = $this->get_data_from_db($update_id);
            $data['categories'] = $this->_get_categories($data['category_id']);
            $data['makers'] = $this->_get_makers($data['maker_id']);
        } else {
            $data = $this->get_data_from_post();
            $data['categories'] = $this->_get_categories($data['category_id']);
            $data['makers'] = $this->_get_makers($data['maker_id']);
        }



        if ($update_id > 0) {
            $data['headline'] = 'Update Product Record';           
            $data['deletable'] = $this->_deletable_record($update_id);

        } else {
            $data['headline'] = 'Create New Product Record';           
            $data['deletable'] = false;
        }

        $data['loc'] = BASE_URL . 'products/submit/' . $update_id;
        $data['cancel_url'] = BASE_URL . 'products/display';

        $data['member_obj'] = $member_obj;       
        $data['view_file'] = 'add';
        $this->template('ses', $data);
    }


    function _deletable_record($update_id){
        $found_one = $this->model->count_where('product_id', $update_id,  '=', 'truck_inv');

        if($found_one >= 1){
            return false;
        } else {
            return true;
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
            die();
        }

        $update_id = segment(3);
        //double check someone isn't just sending
        // a delete url
        $deletable = $this->_deletable_record($update_id);
        if($deletable){
            $this->model->delete($update_id, 'products');
            $flash_msg = '<span class="alert alert-success round-sm p8  flash-msg" id="flash-msg">Record Deleted</span>';
            set_flashdata($flash_msg);          

        } else{
            $flash_msg = '<span class="alert alert-danger round-sm p8  flash-msg" id="flash-msg">Not Deletable</span>';
            set_flashdata($flash_msg);
        }
      
        redirect('products/display');
        
    }
















    /**
     * Handle submitted record data.
     *
     * @return void
     */











    public function submit(): void {
        $this->module('members');
        $allowed_levels = [5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }

        $submit = post('submit', true);

        if ($submit == 'Submit') {

            $this->validation->set_rules('name', 'Name', 'required|min_length[2]|max_length[255]');
            $this->validation->set_rules('part_number', 'part number', 'required|min_length[2]|max_length[255]');
            $this->validation->set_rules('description', 'Description', 'min_length[2]');
            $this->validation->set_rules('category_id', 'Category Name', 'required|max_length[11]|numeric|greater_than[0]|integer');
            $this->validation->set_rules('maker_id', 'Maker Name', 'required|max_length[11]|numeric|greater_than[0]|integer');
            $this->validation->set_rules('qty', 'qty', 'numeric|integer');
            $this->validation->set_rules('price', 'Price', 'max_length|numeric|numeric');
            $this->validation->set_rules('shelf_location', 'shelf location', 'min_length[2]|max_length[255]');

            $result = $this->validation->run();

            if ($result == true) {

                $update_id = (int) segment(3);
                $data = $this->get_data_from_post();

                $data['truck_stock'] = $data['truck_stock'] == '' ? 0 : 1;

                if ($data['qty'] == "") {
                    $data['qty'] = 0;
                }

                if ($data['price'] <= 0) {
                    $data['price'] = NULL;
                }
                if ($update_id > 0) {
                    //update an existing record
                    $this->model->update($update_id, $data, 'products');
                    $flash_msg = '<span class="alert alert-success round-sm p8 m16-block flash-msg" id="flash-msg">The record was successfully updated</span>';
                } else {
                    //is it already in database
                    $part_number = $data['part_number'];
                    $count = $this->model->count_where('part_number', $part_number, "=", "products");

                    if ($count > 0) {
                        $flash_msg = '<span class="alert alert-danger round-sm p8  flash-msg" id="flash-msg">This part is already in the system.</span>';
                        set_flashdata($flash_msg);
                        redirect('products/display');
                    }

                    //insert the new record
                    $data['product_code'] = make_rand_str(10);
                    $update_id = $this->model->insert($data, 'products');
                    $flash_msg = '<p class="alert alert-success round-sm p8 m16-block flash-msg" id="flash-msg">The record was successfully created</p>';
                }

                set_flashdata($flash_msg);
                redirect('products/display');
            } else {
                //form submission error
                $this->add();
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
            $params['module'] = 'products';
            $this->model->query_bind($sql, $params);

            //delete the record
            $this->model->delete($params['update_id'], 'products');

            //set the flashdata
            $flash_msg = 'The record was successfully deleted';
            set_flashdata($flash_msg);

            //redirect to the manage page
            redirect('products/manage');
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
        redirect('products/manage');
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
        $record_obj = $this->model->get_where($update_id, 'products');

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
        $data['name'] = post('name', true);
        $data['part_number'] = post('part_number', true);
        $data['description'] = post('description', true);
        $data['truck_stock'] = post('truck_stock', true);
        $data['category_id'] = post('category_id', true);
        $data['maker_id'] = post('maker_id', true);
        $data['qty'] = post('qty', true);
        $data['price'] = post('price', true);
        $data['shelf_location'] = post('shelf_location', true);
        $data['product_code'] = post('product_code', true);
        return $data;
    }

    function _init_picture_settings() {
        $picture_settings['max_file_size'] = 2000;
        $picture_settings['max_width'] = 1200;
        $picture_settings['max_height'] = 1200;
        $picture_settings['resized_max_width'] = 450;
        $picture_settings['resized_max_height'] = 450;
        $picture_settings['destination'] = 'products_pics';
        $picture_settings['target_column_name'] = 'picture';
        $picture_settings['thumbnail_dir'] = 'products_pics_thumbnails';
        $picture_settings['thumbnail_max_width'] = 120;
        $picture_settings['thumbnail_max_height'] = 120;
        $picture_settings['upload_to_module'] = true;
        $picture_settings['make_rand_name'] = false;
        return $picture_settings;
    }

    function _make_sure_got_destination_folders($update_id, $picture_settings) {

        $destination = $picture_settings['destination'];

        if ($picture_settings['upload_to_module'] == true) {
            $target_dir = APPPATH . 'modules/' . segment(1) . '/assets/' . $destination . '/' . $update_id;
        } else {
            $target_dir = APPPATH . 'public/' . $destination . '/' . $update_id;
        }

        if (!file_exists($target_dir)) {
            //generate the image folder
            mkdir($target_dir, 0777, true);
        }

        //attempt to create thumbnail directory
        if (strlen($picture_settings['thumbnail_dir']) > 0) {
            $ditch = $destination . '/' . $update_id;
            $replace = $picture_settings['thumbnail_dir'] . '/' . $update_id;
            $thumbnail_dir = str_replace($ditch, $replace, $target_dir);
            if (!file_exists($thumbnail_dir)) {
                //generate the image folder
                mkdir($thumbnail_dir, 0777, true);
            }
        }
    }

    function submit_upload_picture($update_id) {
        $this->module('members');
        $allowed_levels = [5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }

        if ($_FILES['picture']['name'] == '') {
            redirect($_SERVER['HTTP_REFERER']);
        }

       
      

        $picture_settings = $this->_init_picture_settings();
        $this->_make_sure_got_destination_folders($update_id, $picture_settings);

        extract($picture_settings);

        $validation_str = 'allowed_types[gif,jpg,jpeg,png]|max_size[' . $max_file_size . ']|max_width[' . $max_width . ']|max_height[' . $max_height . ']';
        $this->validation->set_rules('picture', 'item picture', $validation_str);

        $result = $this->validation->run();

        if ($result == true) {

            $config['destination'] = $destination . '/' . $update_id;
            $config['max_width'] = $resized_max_width;
            $config['max_height'] = $resized_max_height;

            if ($thumbnail_dir !== '') {
                $config['thumbnail_dir'] = $thumbnail_dir . '/' . $update_id;
                $config['thumbnail_max_width'] = $thumbnail_max_width;
                $config['thumbnail_max_height'] = $thumbnail_max_height;
            }

            //upload the picture
            $config['upload_to_module'] = (!isset($picture_settings['upload_to_module']) ? false : $picture_settings['upload_to_module']);
            $config['make_rand_name'] = $picture_settings['make_rand_name'] ?? false;

            $file_info = $this->upload_picture($config);

            //update the database with the name of the uploaded file
            $data[$target_column_name] = $file_info['file_name'];
            $this->model->update($update_id, $data);

            $flash_msg = '<p class="alert alert-success round-sm p8">Successfully Uploaded</p>';
            set_flashdata($flash_msg);
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    function ditch_picture($update_id) {

        if (!is_numeric($update_id)) {
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->module('members');
        $allowed_levels = [5, 6];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);

        if (!$member_obj) {
            $flash_msg = '<div class="align-center login-alert">Access denied - Restricted Area</div>';
            set_flashdata($flash_msg);
            redirect(BASE_URL);
            die();
        }

        $result = $this->model->get_where($update_id);

        if ($result == false) {
            redirect($_SERVER['HTTP_REFERER']);
        }

        $picture_settings = $this->_init_picture_settings();
        $target_column_name = $picture_settings['target_column_name'];
        $picture_name = $result->$target_column_name;

        if ($picture_settings['upload_to_module'] == true) {
            $picture_path = APPPATH . 'modules/' . segment(1) . '/assets/' . $picture_settings['destination'] . '/' . $update_id . '/' . $picture_name;
        } else {
            $picture_path = APPPATH . 'public/' . $picture_settings['destination'] . '/' . $update_id . '/' . $picture_name;
        }

        $picture_path = str_replace('\\', '/', $picture_path);

        if (file_exists($picture_path)) {
            unlink($picture_path);
        }

        if (isset($picture_settings['thumbnail_dir'])) {
            $ditch = $picture_settings['destination'] . '/' . $update_id;
            $replace = $picture_settings['thumbnail_dir'] . '/' . $update_id;
            $thumbnail_path = str_replace($ditch, $replace, $picture_path);

            if (file_exists($thumbnail_path)) {
                unlink($thumbnail_path);
            }
        }

        $data[$target_column_name] = '';
        $this->model->update($update_id, $data);

        $flash_msg = 'The picture was successfully deleted';
        set_flashdata($flash_msg);
        redirect($_SERVER['HTTP_REFERER']);
    }
}
