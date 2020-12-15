<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// check có phải admin không
		if (!$this->session->userdata('role')) {
			$this->output->set_status_header(500);
			die();
		}
	}

	function index()
	{
		
	}
	public function orderHistory()
	{
		// Kiểm tra quyền
		if(!$this->session->has_userdata('role')) {
			$this->output->set_status_header(500);
			die();
		} else {
			$this->load->model('admin/GetData');
		}

		switch ($this->input->server('REQUEST_METHOD')) {
			case 'GET':
				if ($this->input->get('startTime') && $this->input->get('endTime')) {
					$res = $this->GetData->getOrderHistory($this->input->get('startTime'), $this->input->get('endTime'));
				} else {
					$res = $this->GetData->getOrderHistory();
				}
				if ($this->input->get('details')) {
					$this->load->model('GetData');
					$data = $this->GetData->getVoucher();
					$arrVoucher = [];
					foreach ($data as $value) {
					    $arrVoucher[$value['id']] = $value['code'];
					}
					$data = $this->GetData->getPaymentMethod();
					$arrPayment = [];
					foreach ($data as $value) {
					    $arrPayment[$value['id']] = $value['name'];
					}
					foreach ($res as $key => $value) {
						if ($value['voucher'] == null)
							$res[$key]['voucher'] = '';
						else
							$res[$key]['voucher'] = $arrVoucher[$value['voucher']];
						$res[$key]['payment'] = $arrPayment[$value['payment']];
					}
				}
				$this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode($res))
			        ->set_status_header(200);
				break;
			default:
				$this->output->set_status_header(500);
				break;
		}
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */