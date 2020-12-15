<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VoucherManager extends CI_Controller {

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
		$this->load->model('admin/GetData');
		$data = array('data' => $this->GetData->getVoucher());
		$this->load->view('admin/VoucherManager/main', $data, false);
	}

}

/* End of file DiscountCodeManager.php */
/* Location: ./application/controllers/DiscountCodeManager.php */