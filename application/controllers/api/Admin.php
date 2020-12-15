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
	
<<<<<<< HEAD
	// Tài khoản
	public function accountAdmin($id = -1)
	{
		// Kiểm tra quyền
		if($this->session->userdata('role') != 1){
			$this->output->set_status_header(500);
			die();
		} else {
			$this->load->model('admin/GetData');
		}

		// Kiểm tra phương thức
		$method = $this->input->server('REQUEST_METHOD');
		if ($method == "GET") { // [GET] Lấy dữ liệu account
			if ($id === -1) {
				$res = $this->GetData->getAccountAdmin();
			} else {
				$res = $this->GetData->getAccountAdmin($id);
				if (!$res) {
					$res['status'] = false;
					$res['message'] = 'Không tìm thấy thông tin';
				}
			}

			$this->output
	        ->set_content_type('application/json')
	        ->set_output(json_encode($res))
	        ->set_status_header(200);

		} else if ($method == "POST") {
			if ($id == -1) { // [POST] Tạo account
				$data['userName'] = $this->input->post('userName');
				$data['password'] = $this->input->post('password');
				$data['firstName'] = $this->input->post('firstName');
				$data['lastName'] = $this->input->post('lastName');
				$data['email'] = $this->input->post('email');
				$data['phoneNumber'] = $this->input->post('phoneNumber');
				$data['role'] = $this->input->post('level');

				$res['status'] = true;

				$this->load->helper('Validator');

				foreach ($data as $key => $value) {
					if (isRequired($value)) {
						$res['status'] = false;
						$res['message'] = "Vui lòng điền vào tất cả các trường";
						break;
					} else if (checkKiTuDacBiet($value)) {
						if ($key != 'password' && $key != 'email') {
							$res['status'] = false;
							$res['message'] = "Vui lòng không điền các kí tự không hợp lệ";
							break;
						}
					}
				}
				if ($res['status'] != false) {
					if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
						$res['status'] = false;
						$res['message'] = "Vui lòng nhập <b>Email</b> đúng định dạng";
					}
					else if (checkHTML($data['email'])) {
						$res['status'] = false;
						$res['message'] = "Vui lòng không điền các kí tự không hợp lệ";
					}
					else if (checkNumber($data['firstName'])) {
						$res['status'] = false;
						$res['message'] = "Vui lòng nhập <b>Họ và tên lót</b> đúng định dạng";
					}
					else if (checkNumber($data['lastName'])) {
						$res['status'] = false;
						$res['message'] = "Vui lòng nhập <b>Tên</b> đúng định dạng";
					}
					else if (!isNumber($data['phoneNumber'])) {
						$res['status'] = false;
						$res['message'] = "Vui lòng nhập <b>Số điện thoại</b> đúng định dạng";
					}
					else if (minMaxLength($data['phoneNumber'], 10, 10)) {
						$res['status'] = false;
						$res['message'] = "Số điện thoại 10 số";
					}
					else if (minMaxLength($data['password'], 6, 18)) {
						$res['status'] = false;
						$res['message'] = "Mật khẩu phải từ 6-18 kí tự";
					}
				}
				if ($res['status'] == true) {
					$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
					$data['createBy'] = $this->session->userdata('username');
					$this->load->model('admin/CreateUser');
					if ($this->CreateUser->AddData($data)) {
						$res['message'] = "Tạo tài khoản thành công";
					} else {
						$res['status'] = false;
						$res['message'] = "Tên đăng nhập đã tồn tại";
					}
				}
				$this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($res))
		        ->set_status_header(201);
			} else { // [POST] Sửa account
				$data['email'] = $this->input->post('email');
				$data['phoneNumber'] = $this->input->post('phoneNumber');
				$data['firstName'] = $this->input->post('firstName');
				$data['lastName'] = $this->input->post('lastName');
				$data['role'] = $this->input->post('role');
				$data['active'] = $this->input->post('active');

				$res['status'] = true;

				$this->load->helper('Validator');

				foreach ($data as $key => $value) {
					if (isRequired($value)) {
						$res['status'] = false;
						$res['message'] = "Vui lòng điền vào tất cả các trường";
						break;
					} else if (checkKiTuDacBiet($value)) {
						if ($key != 'email') {
							$res['status'] = false;
							$res['message'] = "Vui lòng không điền các kí tự không hợp lệ";
							break;
						}
					}
				}
				if ($res['status'] != false) {
					if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
						$res['status'] = false;
						$res['message'] = "Vui lòng nhập <b>Email</b> đúng định dạng";
					}
					else if (checkHTML($data['email'])) {
						$res['status'] = false;
						$res['message'] = "Vui lòng không điền các kí tự không hợp lệ";
					}
					else if (checkNumber($data['firstName'])) {
						$res['status'] = false;
						$res['message'] = "Vui lòng nhập <b>Họ và tên lót</b> đúng định dạng";
					}
					else if (checkNumber($data['lastName'])) {
						$res['status'] = false;
						$res['message'] = "Vui lòng nhập <b>Tên</b> đúng định dạng";
					}
					else if (!isNumber($data['phoneNumber'])) {
						$res['status'] = false;
						$res['message'] = "Vui lòng nhập <b>Số điện thoại</b> đúng định dạng";
					}
					else if (minMaxLength($data['phoneNumber'], 10, 10)) {
						$res['status'] = false;
						$res['message'] = "Số điện thoại 10 số";
					}
				}

				if ($res['status']) {
					$this->load->model('admin/AccountManager');
					if ($this->AccountManager->updateAccount($id, $data)){
						$res['message'] = "Cập nhật tài khoản <b>".$this->input->post('username')."</b> thành công";
						$res['data'] = $data;
					}
				}

				$this->output->set_content_type('application/json')->set_output(json_encode($res));
			}
		} else if ($method == "DELETE") { // [DELETE] Xóa account

		} else {
			$this->output->set_status_header(500);
		}
	}

	public function changePwdAdmin()
	{
		if(!$this->session->has_userdata('role')){
			$this->output->set_status_header(500);
			die();
		}

		if ($this->input->server('REQUEST_METHOD') == 'POST') {

			$password_old = $this->input->post('password_old');
			$data['password'] = $this->input->post('password_new');

			$this->load->helper('validator');
			if (minMaxLength($data['password'], 6, 18)) {
				$res['status'] = false;
				$res['message'] = "Mật khẩu phải từ 6-18 kí tự";
			} else
				$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

			if (!isset($res['status'])) {
				$this->load->model('admin/AuthUser');
				$check = $this->AuthUser->Validate($this->session->userdata('username'));
				$checkPwd = false;
				if ($check) {
					$checkPwd = password_verify($password_old, $check['password']);
				}

				if ($check && $checkPwd) {
					if ($this->AuthUser->updatePwd($this->session->userdata('username'), $data)) {
						$res['status'] = true;
						$res['message'] = "Đổi mật khẩu mới thành công";
					} else {
						$res['status'] = false;
						$res['message'] = "Cập nhật mật khẩu thất bại";
					}
				} else {
					$res['status'] = false;
					$res['message'] = "Sai mật khẩu cũ";
				}
			}

			$this->output->set_content_type('application/json')->set_output(json_encode($res));
		}
	}
	
	public function voucher($id = -1)
	{
		// Kiểm tra quyền
		if($this->session->userdata('role') != 1) {
			$this->output->set_status_header(500);
			die();
		} else {
			$this->load->model('admin/VoucherManager');
			$this->load->model('admin/GetData');	
		}

		// Kiểm tra phương thức
		$method = $this->input->server('REQUEST_METHOD');

		if ($method == "GET") { // [GET] Lấy dữ liệu
			if ($id == -1) {
				$res = $this->GetData->getVoucher();

				foreach ($res as $key => $value) {
					$data[$value['id']] = $value;
				}
				$res = $data;
			} else {
				$res = $this->GetData->getVoucher($id);

				if (!$res) {
					$res['status'] = false;
					$res['message'] = 'Không tìm thấy thông tin';
				} else {
					$res = $res[0];
				}
			}
			$this->output
	        ->set_content_type('application/json')
	        ->set_output(json_encode($res))
	        ->set_status_header(200);
		} else if ($method == "POST") {
			$res['status'] = true;
			$this->load->helper('Validator');
			
			$data['code'] = strtoupper($this->input->post('code'));
			$data['content'] = $this->input->post('content');
			$data['count'] = $this->input->post('count');
			$data['discountType'] = $this->input->post('discountType');
			$data['discountValue'] = $this->input->post('discountValue');
			$data['timeStart'] = strtotime($this->input->post('timeStart'));
			$data['timeEnd'] = strtotime($this->input->post('timeEnd'));

			// check dữ liệu
			foreach ($data as $key => $value) {
				if (isRequired($value) && $key != 'discountType'){
					$res['status'] = false;
					$res['message'] = 'Vui lòng điền đủ thông tin';
					break;
				}
			}
			if (!isNumber($data['count'])) {
				$res['status'] = false;
				$res['message'] = 'Số lượng sai định dạng';
			} else if (!isNumber($data['discountValue'])) {
				$res['status'] = false;
				$res['message'] = 'Giá trị giảm giá sai định dạng';
			} else if ($data['discountType'] != 0 && $data['discountType'] != 1) {
				$res['status'] = false;
				$res['message'] = 'Loại giảm giá sai định dạng';
			}
			if ($id == -1) { // [POST] Tạo mới
				
				// thêm dữ liệu
				if ($res['status']) {
					$insert_id = $this->VoucherManager->createVoucher($data);
					if ($insert_id) {
						$res['message'] = 'Thêm voucher <b>'.$data['code'].'</b> thành công';
						$res['id'] = $insert_id;
					} else {
						$res['status'] = false;
						$res['message'] = 'Voucher <b>'.$data['code'].'</b> đã tồn tại';
					}
				}
				
				$this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($res))
		        ->set_status_header(201);
			}
			else { // [POST] Cập nhật mã

				// cập nhật dữ liệu
				if ($res['status']) {
					if ($this->VoucherManager->updateVoucher($id, $data)) {
						$res['message'] = 'Cập nhật voucher <b>'.$data['code'].'</b> thành công';
					} else {
						$res['status'] = false;
						$res['message'] = 'Voucher <b>'.$data['code'].'</b> đã tồn tại';
					}
				}

				$this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($res))
		        ->set_status_header(200);
			}
		} else {
			$this->output->set_status_header(500);
=======
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
>>>>>>> OrderPageManage
		}
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */