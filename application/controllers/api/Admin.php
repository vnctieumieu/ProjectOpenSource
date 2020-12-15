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
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */