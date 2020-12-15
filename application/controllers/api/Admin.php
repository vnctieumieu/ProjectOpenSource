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
	
	public function orderOffline($id = -1)
	{
		// Kiểm tra quyền
		if(!$this->session->has_userdata('role')) {
			$this->output->set_status_header(500);
			die();
		} else {
			$this->load->model('admin/OrderManager');
			$this->load->model('admin/GetData');
		}

		switch ($this->input->server('REQUEST_METHOD')) {
			case 'GET':
				if ($id === -1) {
					$orders = $this->GetData->getOrderOffline();
					$order_details = $this->GetData->getOrderDetail();
					foreach ($orders as $key => $value) {
						foreach ($order_details as $key2 => $value2) {
							if ($value['id'] == $value2['orderId']) {
								$orders[$key]['product'][] = $value2;
								unset($order_details[$key2]);
							}
						}
					}
				} else {
					$orders = $this->GetData->getOrderOffline($id);
					if ($orders) {
						$orders = $orders[0];
						$orders['product'] = $this->GetData->getOrderDetail($orders['id']);
					}
				}

				if ($orders) {
					$product = $this->GetData->getProduct();
					foreach ($product as $key => $value) {
						$data[$value['id']] = $value;
					}
					$product = $data;

					foreach ($orders as $key => $value) {
						foreach ($value['product'] as $key2 => $value2) {
							$orders[$key]['product'][$key2]['product'] = $product[$value2['productId']];
						}
					}
				}

				$res = $orders;

				$this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode($res))
			        ->set_status_header(200);
				break;
			case 'POST':
				if ($id != -1) {
					if ($this->OrderManager->applyOrderOffline($id, $this->session->userdata('id'))) {
						$res['status'] = true;
						$res['message'] = 'Xác nhận đơn <b>'.$id.'</b> thành công';
					} else {
						$res['status'] = false;
						$res['message'] = 'Xác nhận đơn <b>'.$id.'</b> thất bại';
					}

					$this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode($res))
			        ->set_status_header(200);
				}
				break;
			case 'DELETE':
				if ($this->OrderManager->deleteOrder($id)) {
					$res['status'] = true;
					$res['message'] = "Xóa đơn <b>$id</b> thành công";
				} else {
					$res['status'] = false;
					$res['message'] = "Xóa đơn <b>$id</b> thất bại";
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

	public function cancelOrderOffline($id = -1)
	{
		// Kiểm tra quyền
		if(!$this->session->has_userdata('role')) {
			$this->output->set_status_header(500);
			die();
		} else {
			$this->load->model('admin/OrderManager');
		}

		switch ($this->input->server('REQUEST_METHOD')) {
			case 'POST':
				$data['cancelReason'] = $this->input->post('reason');

				if ($this->OrderManager->orderCancel($id, $data, $this->session->userdata('id'))) {
					$res['status'] = true;
					$res['message'] = 'Hủy đơn <b>'.$id.'</b> thành công';
				} else {
					$res['status'] = false;
					$res['message'] = 'Hủy đơn <b>'.$id.'</b> thất bại';
				}

				$this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode($res))
			        ->set_status_header(200);
				break;
		}
	}

	public function orderOnline($id = -1)
	{
		// Kiểm tra quyền
		if(!$this->session->has_userdata('role')) {
			$this->output->set_status_header(500);
			die();
		} else {
			$this->load->model('admin/OrderManager');
			$this->load->model('admin/GetData');
		}

		switch ($this->input->server('REQUEST_METHOD')) {
			case 'GET':
				if ($id === -1) {
					$orders = $this->GetData->getOrderOnline();
					$order_details = $this->GetData->getOrderDetail();
					foreach ($orders as $key => $value) {
						foreach ($order_details as $key2 => $value2) {
							if ($value['id'] == $value2['orderId']) {
								$orders[$key]['product'][] = $value2;
								unset($order_details[$key2]);
							}
						}
					}
				} else {
					$orders = $this->GetData->getOrderOnline($id);
					if ($orders) {
						$orders = $orders[0];
						$orders['product'] = $this->GetData->getOrderDetail($orders['id']);
					}
				}

				if ($orders) {
					$product = $this->GetData->getProduct();
					foreach ($product as $key => $value) {
						$data[$value['id']] = $value;
					}
					$product = $data;

					foreach ($orders as $key => $value) {
						foreach ($value['product'] as $key2 => $value2) {
							$orders[$key]['product'][$key2]['product'] = $product[$value2['productId']];
						}
					}
				}

				$res = $orders;

				$this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode($res))
			        ->set_status_header(200);
				break;
			case 'POST':
				if ($id != -1) {
					if ($this->OrderManager->applyOrderOnline($id, $this->session->userdata('id'))) {
						$res['status'] = true;
						$res['message'] = 'Duyệt đơn <b>'.$id.'</b> thành công';
					} else {
						$res['status'] = false;
						$res['message'] = 'Duyệt đơn <b>'.$id.'</b> thất bại';
					}

					$this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode($res))
			        ->set_status_header(200);
				}
				break;
			default:
				$this->output->set_status_header(500);
				break;
		}
	}

	public function orderSuccess($id = -1)
	{
		// Kiểm tra quyền
		if(!$this->session->has_userdata('role')) {
				$this->output->set_status_header(500);
				die();
		} else {
			$this->load->model('admin/OrderManager');
			$this->load->model('admin/GetData');
		}

		switch ($this->input->server('REQUEST_METHOD')) {
			case 'GET':
				if ($id === -1) {
					$orders = $this->GetData->getOrderSuccess();
					$order_details = $this->GetData->getOrderDetail();
					foreach ($orders as $key => $value) {
						foreach ($order_details as $key2 => $value2) {
							if ($value['id'] == $value2['orderId']) {
								$orders[$key]['product'][] = $value2;
								unset($order_details[$key2]);
							}
						}
					}
				} else {
					$orders = $this->GetData->getOrderSuccess($id);
					if ($orders) {
						$orders = $orders[0];
						$orders['product'] = $this->GetData->getOrderDetail($orders['id']);
					}
				}

				if ($orders) {
					$product = $this->GetData->getProduct();
					foreach ($product as $key => $value) {
						$data[$value['id']] = $value;
					}
					$product = $data;

					foreach ($orders as $key => $value) {
						foreach ($value['product'] as $key2 => $value2) {
							$orders[$key]['product'][$key2]['product'] = $product[$value2['productId']];
						}
					}
				}

				$res = $orders;

				$this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode($res))
			        ->set_status_header(200);
				break;
			case 'POST':
				if ($id != -1) {
					if ($this->OrderManager->applyOrderSuccess($id, $this->session->userdata('id'))) {
						$res['status'] = true;
						$res['message'] = 'Hoàn thành đơn <b>'.$id.'</b> thành công';
					} else {
						$res['status'] = false;
						$res['message'] = 'Lỗi hoàn thành, vui lòng reload lại trang';
					}

					$this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode($res))
			        ->set_status_header(200);
				}
				break;
			case 'DELETE':
				if ($this->OrderManager->deleteOrder($id)) {
					$res['status'] = true;
					$res['message'] = "Xóa đơn <b>$id</b> thành công";
				} else {
					$res['status'] = false;
					$res['message'] = "Xóa đơn <b>$id</b> thất bại";
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