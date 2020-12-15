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
		}
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */