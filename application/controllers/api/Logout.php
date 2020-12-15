<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$method = $this->input->server('REQUEST_METHOD');
		if ($method == "POST") {
			if ($this->session->userdata('userName')) {
				$this->session->sess_destroy();
				$data['status'] = true;
				$data['message'] = "Đăng xuất thành công";

				$this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($data))
		        ->set_status_header(200);
	        } else {
	        	$this->session->sess_destroy();
				$data['status'] = false;
				$data['message'] = "Đăng xuất thất bại";

				$this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($data))
		        ->set_status_header(200);
	        }
		} else {
			$this->output->set_status_header(500);
		}
	}

}

/* End of file Logout.php */
/* Location: ./application/controllers/Logout.php */