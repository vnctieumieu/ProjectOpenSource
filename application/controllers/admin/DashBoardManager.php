<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DashBoardManager extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('role')) {
			$this->output->set_status_header(500);
			die();
		}
	}

	public function index()
	{
		$this->load->model('admin/GetData');

		$dayNow = date('d');
		// $monthNow = date('m');
		// $yearNow = date('Y');
		// $timeDayNow = strtotime(date('y-m-d'));

		$startTime = strtotime(date('y-m-d'))*1000;
		$endTime = strtotime(date('y-m-'.($dayNow+1)))*1000;
		$data = $this->GetData->getOrderHistory($startTime, $endTime);

		$resultPrice = [];
		$resultOrder = [];
		for ($i = 1; $i < 25; $i++) {
			$resultPrice[$i] = ['full' => 0, 'discount' => 0, 'price' => 0];
			$resultOrder[$i] = ['success' => 0, 'fail' => 0];
		}

		foreach ($data as $key => $value) {
			$hour = (int)date('H', $value['id']/1000);

			switch ($value['status']) {
				case '4':
					$resultPrice[$hour]['full'] += $value['priceOrder'];
					$resultPrice[$hour]['discount'] += $value['priceDiscount'];
					$resultPrice[$hour]['price'] += $value['pricePayment'];
					$resultOrder[$hour]['success'] += 1;
					break;
				case '5':
					$resultOrder[$hour]['fail'] += 1;
					break;
			}
		}

		$data = array('dataPrice' => $resultPrice, 'dataOrder' => $resultOrder);
		$this->load->view('admin/DashBoardManager/main', $data, false);
	}

}