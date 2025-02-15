<?php
class On_call extends Trongate {

    function index() {
        $this->module('members');
        $allowed_levels = [3, 4];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            redirect(BASE_URL);
        }
        $member_id = $member_obj->id;

        $claim_info = $this->_get_claim_status($member_id);

        $members_claim = $claim_info['claimed_by_member'];
        $claimed = $claim_info['claimed'];

        $data['claim_status'] = $this->_render_claim($claimed, $members_claim);
        $data['claim_history'] = $this->_get_claim_history();

        $data['member_obj'] = $member_obj;
        $data['view_module'] = 'on_call';
        $data['view_file'] = 'display';
        $this->template('ses', $data);
    }




    function submit_claim() {
        $this->module('members');
        $allowed_levels = [3, 4];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            redirect(BASE_URL);
        }
        $member_id = $member_obj->id;

        $currentWeekNumber = date('W');

        //already claimed
        $week_in_db = $this->model->get_one_where('week_of', $currentWeekNumber, 'on_call');
        if ($week_in_db) {
            redirect($this->display);
            die();
        }

        $data['timestamp'] = time();
        $data['week_of'] = $currentWeekNumber;
        $data['member_id'] = $member_id;
        $data['member_name'] = $member_obj->first_name;

        $this->model->insert($data, 'on_call');

        redirect('on_call');
    }

    function submit_unclaim() {
        $this->module('members');
        $allowed_levels = [3, 4];
        $member_obj = $this->members->_get_member_custom($allowed_levels, true);
        if (!$member_obj) {
            redirect(BASE_URL);
        }
        $member_id = $member_obj->id;

        $currentWeekNumber = date('W');

        $sql = 'SELECT * 
                FROM on_call
                WHERE week_of = :week_of 
                AND member_id = :member_id';
        $query_data['week_of'] = $currentWeekNumber;
        $query_data['member_id'] = $member_id;
        $row = $this->model->query_bind($sql, $query_data, 'object');

        if ($row) {
            $this->model->delete($row[0]->id, 'on_call');
        }

        redirect('on_call');
    }


    function _get_claim_status($member_id) {
        $currentYear = date('Y');
        $currentWeekNumber = date('W');
        $data['startDateOfWeek'] = date('M j, Y', strtotime($currentYear . 'W' . $currentWeekNumber . '1'));
        $data['endDateOfWeek'] = date('M j, Y', strtotime($currentYear . 'W' . $currentWeekNumber . '7'));


        // Is there and on call claim yet
        $sql = 'SELECT * 
                FROM on_call
                WHERE week_of = :week_of';
        $query_data['week_of'] = $currentWeekNumber;
        $result = $this->model->query_bind($sql, $query_data, 'object');

        // nobody claimed this week
        $claimed = $result ? true : false;
        $message = "This week has not been claimed";


        $members_claim = false;
        if ($claimed) {
            if ($result[0]->member_id == $member_id) {
                $members_claim = true;
                $message = "You have claim this week.";
            } else {
                $members_claim = false;
                $message = $result[0]->member_name . "has claimed this week";
            }
            $data['name'] = $result[0]->member_name;
        }
        $data['message'] = $message;
        $data['claimed_by_member'] = $members_claim;
        $data['claimed'] = $claimed;

        return $data;
    }

    function _render_claim($claimed, $members_claim) {       
        $html = '';
        if ($claimed && $members_claim) {
            $html .= '<a href="on_call/submit_unclaim" class="flex align-center text-white no-decoration round-sm p8 alert-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m4.475 6.1l.84 12.077c.094 1.16.967 3.377 3.204 3.625s6.731.193 7.55.193c.82 0 2.944-.581 2.944-2.99c0-2.43-2.03-3.063-3.305-3.041h-3.653m0 0a.8.8 0 0 1 .273-.581l2.159-1.89m-2.432 2.47a.8.8 0 0 0 .275.623l2.157 1.875M19.47 5.824l-.468 7.655M3 5.496h18m-4.945 0l-.682-1.407c-.454-.934-.68-1.401-1.071-1.693a2 2 0 0 0-.275-.172C13.594 2 13.074 2 12.034 2c-1.065 0-1.598 0-2.039.234q-.146.078-.278.179c-.396.303-.617.787-1.059 1.756l-.605 1.327" color="currentColor" />
                    </svg>&nbsp;Un-Claim</a>';
        } elseif ($claimed && !$members_claim) {
            $html .= '<p class="text-danger">This week is Taken.</p>';
        } else {
            $html .= '<a href="on_call/submit_claim" class="flex align-center text-white no-decoration round-sm p8 bg-primary">
                       <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7v14m7.758-17.091c-3.306-1.684-5.907-.698-7.204.31c-.234.182-.35.273-.452.48C4 4.909 4 5.102 4 5.49v9.243c.97-1.098 3.879-2.8 7.758-.823c3.466 1.765 6.416 1.033 7.812.27c.193-.105.29-.158.36-.276s.07-.246.07-.502V5.874c0-.829 0-1.243-.197-1.393c-.198-.15-.66-.022-1.583.234c-1.58.438-3.878.51-6.462-.806" color="currentColor" />
                      </svg>&nbsp;Claim</a>';
        }
        return $html;
    }

    function _get_claim_history() {
        $currentYear = date('Y');
        $currentWeekNumber = date('W');

        $sql2 = 'SELECT * FROM on_call ORDER BY id DESC LIMIT 8;';
        $oc_history = $this->model->query($sql2, 'object');

        foreach ($oc_history as $item) {
            // Calculate the start date (Monday) of the given week number
            $startDateOfWeek = date('M j, Y', strtotime($currentYear . 'W' . str_pad($item->week_of, 2, '0', STR_PAD_LEFT) . '1'));
            $endDateOfWeek = date('M j, Y', strtotime($currentYear . 'W' . str_pad($item->week_of, 2, '0', STR_PAD_LEFT) . '7'));

            $item->start_date = $startDateOfWeek;
            $item->end_date = $endDateOfWeek;

            if($currentWeekNumber == $item->week_of){
                $item->cur_week = true;
            }
        }

        $data['oc_history'] = $oc_history;

        $html = '';      
        foreach ($oc_history as $item) {
            if($item->cur_week){
                $active = "cur-week";
            } else {
                $active = '';
            }
            $html .= '<div class="bg-secondary p8 round-sm m8-block '.$active.' "><div class="flex align-center"';
            $html .= '<p>' . $item->start_date . ' - '.$item->end_date.'</p>';
            $html .= '<p class="pl16">' . ucfirst($item->member_name) . '</p>';
            $html .= '</div>';
            $html .= '</div>';           
        }

        return $html;
    }
}
