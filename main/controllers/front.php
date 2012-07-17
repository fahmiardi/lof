<?php if ( ! defined ('BASEPATH')) exit('No direct script access allowed');

class Front extends CI_Controller {	
	function index() {
		$this->load->helper(array('html','url'));
		$data_h['myrobots'] = '<meta name="robots" content="noindex,nofollow">';
		$data_h['mywebtitle'] = 'lofable.com';
		$data['header'] = $this->load->view('header_view', $data_h, TRUE);
		$data['mytitle'] = "This LOFABLE.COM";
		$data['mytext'] = "sale your product.";
		$this->load->view('basic_view', $data);
	}
}

/* end of file front.php */
/* Location: ./store/controllers/front.php */
