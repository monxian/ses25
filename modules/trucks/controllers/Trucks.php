<?php
class Trucks extends Trongate {
   

    function display() {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [6], true);

        if (!$member_obj) {
            $this->module('authorize');
            $this->authorize->restricted();
        }

        $sql = 'SELECT
                    members.id as tech_id,
                    members.first_name,
                    members.last_name,
                    truck_assign.id as truck_id,
                    truck_assign.plate_number,
                    truck_assign.vin,
                    truck_assign.assigned,
                    truck_assign.make
                FROM
                    members
                LEFT OUTER JOIN
                    truck_assign
                ON
                    members.id = truck_assign.member_id

                WHERE members.is_tech = 1 AND confirmed = 1';
        $data['techs'] = $this->model->query($sql, 'object');


        $sql2 = 'SELECT * 
                FROM truck_assign
                WHERE member_id IS NULL OR member_id = ""';
        $data['trucks_available'] = $this->model->query($sql2, 'object');


        $data['member_obj'] = $member_obj;        
        $data['view_file'] = 'display';
        $this->template('ses', $data);
    }

    function truck_un_assign() {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [6], true);

        if (!$member_obj) {
            $this->module('authorize');
            $this->authorize->restricted();
        }
        $update_id = segment(3);

        $param['truck_id'] = $update_id;
        $sql = 'UPDATE truck_assign
                SET member_id = NULL, member_name = NULL, assigned = 0
                WHERE id = :truck_id';

        $this->model->query_bind($sql, $param);

        redirect('trucks/display');
    }

    function assign() {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [6], true);

        if (!$member_obj) {
            $this->module('authorize');
            $this->authorize->restricted();
        }
        $tech_id = segment(3);

        $tech = $this->model->get_one_where('id', $tech_id, 'members');
        $data['tech_name'] = $tech->first_name;
        $data['tech_id'] = $tech->id;        
      
        $data['trucks'] = $this->model->get_many_where('assigned', '0', 'truck_assign');  
        
        if($data['trucks']){
            $heading = '<h2>Trucks Avaliable to Assign</h2>
                        <div class="flex align-end">Assigning a truck to &nbsp;<h3 class="text-primary">'. ucfirst($data['tech_name']) .'</h3></div>
                        <p class="small-text text-secondary">Click truck to assign</p>';
        } else {
            $heading = '<h2 class="text-danger">No Trucks Available to Assign</h2>';
        }
        $data['header'] = $heading;

        $data['member_obj'] = $member_obj;
        $data['view_file'] = 'assign';
        $this->template('ses', $data);
    }

    function submit_assign() {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [6], true);

        if (!$member_obj) {
            $this->module('authorize');
            $this->authorize->restricted();
        }
        $tech_id = segment(3);
        $truck_id = segment(4);

        $tech = $this->model->get_one_where('id', $tech_id, 'members');

        $sql = 'UPDATE truck_assign
                SET member_id = :member_id, member_name = :member_name, assigned = 1
                WHERE id = :truck_id';
        $params['member_id'] = $tech_id;
        $params['member_name'] = $tech->first_name;
        $params['truck_id'] = $truck_id;
        $this->model->query_bind($sql, $params);

        redirect('trucks/display');
        
    }

    function edit() {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [6], true);

        if (!$member_obj) {
            $this->module('authorize');
            $this->authorize->restricted();
        }

        $data['trucks'] = $this->model->get('id', 'truck_assign');


        $data['member_obj'] = $member_obj;
        $data['view_file'] = 'edit';
        $this->template('ses', $data);
    }

    function edit_truck() {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [6], true);

        if (!$member_obj) {
            $this->module('authorize');
            $this->authorize->restricted();
        }

        $truck_id = segment(3);     

        $submit = post('submit');
        if (($submit == '') && ($truck_id > 0)) {
            $data = $this->_get_data_from_db($truck_id);            
        } else {
            $data = $this->_get_data_from_post();           
        }

        if(!$truck_id){
             $data['heading'] = "Add New Truck";
             $data['loc'] = 'trucks/submit_edit';
        } else {
            $data['heading'] = "Edit Existing Truck";
            $data['loc'] = 'trucks/submit_edit/' . $truck_id;
        }
      
       

        $data['cancel'] = 'trucks/edit';
        $data['member_obj'] = $member_obj;
        $data['view_file'] = 'edit_truck';
        $this->template('ses', $data);
    }

    function submit_edit() {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [6], true);

        if (!$member_obj) {
            $this->module('authorize');
            $this->authorize->restricted();
        }
        $update_id = (int) segment(3);
        
        $submit = post('submit', 'true');
        
        if ($submit == 'Submit') {
        
            $this->validation_helper->set_rules('make', 'make', 'required');
            $this->validation_helper->set_rules('plate_number', 'plate number', 'required');
            $this->validation_helper->set_rules('vin', 'vin', 'required');
        
            $result = $this->validation_helper->run();
        
            if ($result == true) {

                $params['make'] = post('make', true);
                $params['plate_number'] = post('plate_number', true);
                $params['vin'] = post('vin', true);

                if($update_id > 0){
                    $this->model->update($update_id, $params, 'truck_assign');
                } else {
                    $param['truck_id'] = $this->model->insert($params, 'truck_assign');
                                        
                    $sql = 'INSERT INTO truck_inv (truck_id, product_id, qty, low_level)
                            SELECT :truck_id , id, 0, 0
                            FROM products'; 
                    $this->model->query_bind($sql, $param);

                }               
            } else {
                redirect('trucks/edit_truck/'.$update_id);
            }
            redirect('trucks/edit');
        } else {
            redirect('trucks/edit_truck/' . $update_id);
        }
    }

    public function delete_modal(): void {
        http_response_code(200);
        $update_id = segment(3);
        $html = '<div class="modal-header-danger text-center p8"><h3>Deleting Truck</h3></div>';
        $html .= '<div class="text-center pt16">
                  <p>Deleting the truck will also delete truck inventory</p>
                  <p>for this truck.</p>
                 </div>';
        $html .= '<div class="flex align-center justify-between p8">';
        $html .= '<a class="button btn-danger" href="' . BASE_URL . 'trucks/delete/' . $update_id . '">Delete</a>';
        $html .= '<button type="button" onclick="closeModal()" class="btn-modal-secondary">Cancel</button>';
        $html .= '</div>';

        echo $html;
    }

    function delete() {
        $this->module('members');
        $member_obj = $this->members->_get_member_custom($user_level = [6], true);

        if (!$member_obj) {
            $this->module('authorize');
            $this->authorize->restricted();
        }
        $update_id = (int) segment(3);
        
        $truck = $this->model->get_one_where('id', $update_id, 'truck_assign');
        if($truck->assigned > 0){
            redirect('trucks/edit');
        }

        $sql ='DELETE FROM truck_inv
              WHERE truck_id = :truck_id';
        $query_param['truck_id'] = $update_id;
        $this->model->query_bind($sql, $query_param);
        
        $this->model->delete($update_id, 'truck_assign');
        redirect('trucks/edit');       
    }


    function _get_data_from_db($update_id) {
        $record_obj = $this->model->get_where($update_id, 'truck_assign');

        if ($record_obj == false) {
            $this->template('error_404');
            die();
        } else {
            $data = (array) $record_obj;
            return $data;
        }
    }

    function _get_data_from_post() {
        $data['make'] = post('make', true);
        $data['plate_number'] = post('plate_number', true);
        $data['vin'] = post('vin', true);      
        return $data;
    }

}