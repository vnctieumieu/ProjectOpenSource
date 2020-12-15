<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class QrCode extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('role') || $this->session->userdata('role') != 1) {
			$this->output->set_status_header(500);
			die();
		}
	}

	public function index()
	{
		$this->load->view('admin/qrcode');
	}

}

/* End of file QrCode.php */
/* Location: ./application/controllers/QrCode.php */