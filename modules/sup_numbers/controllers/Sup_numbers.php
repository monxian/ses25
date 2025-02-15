<?php
class Sup_numbers extends Trongate {

    function index () {   

        $data['numbers'] = $this->model->get('name', 'support_numbers');
     
        $data['view_module'] = 'sup_numbers';
        $data['view_file'] = 'display';
        $this->template('ses', $data);
    }

}