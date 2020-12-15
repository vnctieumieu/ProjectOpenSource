<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('userName')){
			$this->output->set_status_header(400);
			die();
		}
	}

	public function index()
	{
		$this->output->set_status_header(500);
	}
	public function admin()
	{
		$method = $this->input->server('REQUEST_METHOD');
		if ($method == "POST") {

			$username = $this->input->post('username');
			$password = $this->input->post('password');

			$this->load->model('admin/AuthUser');
			$check = $this->AuthUser->Validate($username);
			$checkPwd = false;
			if ($check) {
				if ($check['active'] == 0) {
					$status['status'] = false;
					$status['message'] = "Tài khoản đã bị khóa, vui lòng liên hệ Chủ cửa hàng";
				} else
					$checkPwd = password_verify($password, $check['password']);
			}

			if ($check && $checkPwd){
				unset($check['password']);
				$dulieu = $check;
				
				foreach ($dulieu as $key => $value) {
					$data[$key] = $value;
				}

				$this->load->model('admin/GetData');
				$data['roleName'] = $this->GetData->getRole($data['role'])[0]["name"];


				$this->session->set_userdata($data);

				$status['status'] = true;
				$status['message'] = "Đăng nhập thành công";
			} else {
				if (!isset($status['status'])) {
					$status['status'] = false;
					$status['message'] = "Sai tài khoản hoặc mật khẩu";
				}
			}
			$this->output
	        ->set_content_type('application/json')
	        ->set_output(json_encode($status))
	        ->set_status_header(200);	
		} else {
			$this->output->set_status_header(500);
		}
	}

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */