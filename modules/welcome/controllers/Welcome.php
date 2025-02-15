<?php
class Welcome extends Trongate {

	/**
	 * Renders the (default) homepage for public access.
	 *
	 * @return void
	 */
	public function index(): void {

		$data['view_module'] = 'welcome';		
		$this->view('welcome', $data);
	}

	public function admin_welcome(){
		$this->module('members');
		$allowed_levels = [5, 6];
		$member_obj = $this->members->_get_member_custom($allowed_levels, true);
		if (!$member_obj) {
			redirect(BASE_URL);
		}

		$data['member_obj'] = $member_obj;

		$data['view_file'] = 'admin';
		$this->template('ses', $data);
	}

}