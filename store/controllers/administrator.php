<?php if ( ! defined ('BASEPATH')) exit ('No direct scripts allowed');
class Administrator extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library(array('form_validation', 'session'));
		$this->load->helper(array('url', 'form'));
		$this->load->model('administrator_model');

		$this->_salt = "123456789987654321";
	}
	
	function index() {	
		if($this->administrator_model->logged_in() === TRUE) {
			$this->dashboard(TRUE);
		}
		else {
			$this->load->view('administrator/details_view');
		}
	}

	function dashboard($condition = FALSE) {			
		if($condition === TRUE OR $this->administrator_model->logged_in() === TRUE) {
			$this->load->view('administrator/dashboard_view');
		}
		else {
			$this->load->view('administrator/details_view');
		}
	}
	
	function login() {
		$this->form_validation->set_rules('username', 'Username', 'xss_clean|required|callback_username_check');
		$this->form_validation->set_rules('password', 'Password', 'xss_clean|required|min_length[4]|max_length[12]|sha1|callback_password_check');
		$this->_username = $this->input->post('username');
		$this->_password = sha1($this->_salt . $this->input->post('password'));
		
		if($this->form_validation->run() === FALSE) {
			$this->load->view('administrator/login_view');
		}
		else {
			$this->administrator_model->login();
			$data['message'] = "You are logged in! Now go take a look at the "
					.anchor('administrator/dashboard', 'Dashboard');
			$this->load->view('administrator/success_view', $data);

		}
	}

	function logout() {
		$this->session->sess_destroy();
		$this->load->view('administrator/logout_view');
	}
	
	function username_check() {
		$this->db->where('username', $this->_username);
		$query = $this->db->get('users');
		$result = $query->row_array();	
		
		if($query->num_rows() == 0) {
			$this->form_validation->set_message('username_check', 'There was an error!');
			return FALSE;
		}
		else {
			if($result['username'] == $this->_username) {
				return TRUE;
			}
		}
	}

	function password_check() {
		$this->db->where('username', $this->_username);
		$query = $this->db->get('users');
		$result = $query->row_array();

		if($result['password'] == $this->_password) {
			return TRUE;
		}
		
		if($query->num_rows() == 0) {
			$this->form_validation->set_message('password_check', 'There was an error!');
			return FALSE;
		}
	}

	function register() {
		$this->form_validation->set_rules('username', 'Username', 'xss_clean|required');
		$this->form_validation->set_rules('email', 'Email Address', 'xss_clean|required|valid_email|callback_email_exists');
		$this->form_validation->set_rules('password', 'Password', 'xss_clean|required|min_length[4]|max_length[12]|matches[password_conf]|sha1');
		$this->form_validation->set_rules('password_conf', 'Password Confirmation', 'xss_clean|required|matches[password]|sha1');
		
		if($this->form_validation->run() == FALSE) {
			$this->load->view('administrator/register_view');
		}
		else {
			$data['username'] = $this->input->post('username');
			$data['email'] = $this->input->post('email');
			$data['password'] = sha1($this->_salt . $this->input->post('password'));
			if($this->administrator_model->create($data) === TRUE) {
				$data['message'] = "The user account has now been created! You can login " . anchor('administrator/login', 'here') . ".";
				$this->load->view('administrator/success_view', $data);
			}
			else {
				$data['error'] = "There was a problem when adding your account to the database.";
				$this->load->view('administrator/error_view', $data);
			}

		}

	}
	
	function user_exists($user) {
		$query = $this->db->get_where('users', array('username' => $user));
		if($query->num_rows() > 0) {
			$this->form_validation->set_message('user_exists', 'The %s already exists in our database, please use a different one.');
			return FALSE;
		}
		$query->free_result();
		return TRUE;
	}
	
	function email_exists($email) {
		$query = $this->db->get_where('users', array('email' => $email));
		if($query->num_rows() > 0) {
			$this->form_validation->set_message('email_exists', 'The %s already exists in our database, please use a different one.');
			return FALSE;
		}
		$query->free_result();
		return TRUE;
	}

}
/* end of file administrator.php */
/* Location: ./store/controllers/administrator.php */
