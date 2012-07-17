<?php
class Administrator_model extends CI_Model
{
	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	function create($data)	{
		if($this->db->insert('users', $data)) {
			return TRUE;
		}
		return FALSE;
	}

	function login() {
		$data = array(
		'username' => $this->input->post('username'),
		'logged_in' => TRUE
		);
		$this->session->set_userdata($data);
	}

	function logged_in() {
		if($this->session->userdata('logged_in') === TRUE) {
			return TRUE;
		}
		return FALSE;
	}
}

/* end of file administrator_model.php */
/* Location: ./store/model/administrator_model.php */
