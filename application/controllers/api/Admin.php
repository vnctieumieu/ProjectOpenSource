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
	
	// Sản phẩm
	public function product($id = -1)
	{
		// Kiểm tra quyền
		if($this->session->userdata('role') != 1){
			$this->output->set_status_header(500);
			die();
		} else {
			$this->load->model('admin/ProductManager');
			$this->load->model('admin/GetData');
		}

		// Kiểm tra phương thức
		$method = $this->input->server('REQUEST_METHOD');

		if ($method == "GET") { // [GET] Lấy dữ liệu
			if ($id == -1) {
				$res = $this->GetData->getProduct();

				foreach ($res as $key => $value) {
					$data[$value['id']] = $value;
				}
				$res = $data;
			} else {
				$res = $this->GetData->getProduct($id);

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
			if ($id == -1) { // [POST] Tạo mới sản phẩm
				$res['status'] = true;
				$this->load->helper('Validator');
				$this->output->set_status_header(400);
				// Kiểm tra file
				if (!empty($_FILES['avt'])) {
					$duoi = explode('.', $_FILES['avt']['name']); // tách chuỗi khi gặp dấu .
					$duoi = end($duoi); //lấy ra đuôi file

					// Kiểm tra có phải file ảnh không
					if ($duoi === 'jpg' || $duoi === 'png' || $duoi === 'gif' || $duoi === 'jpeg') {

						$data['name'] = $this->input->post('name');
						$data['typeCode'] = $this->input->post('typeCode');
						$data['price'] = $this->input->post('price');
						// Kiểm tra dữ liệu
						foreach ($data as $key => $value) {
							if (isRequired($value)) {
								$res['status'] = false;
								$res['message'] = 'Vui lòng điền tất cả trường';
								break;
							}
						}
						if (checkHTML($data['name'])) {
							$res['status'] = false;
							$res['message'] = 'Tên sản phẩm chứa kí tự không hợp lệ';
						} else if (!isNumber($data['price'])) {
							$res['status'] = false;
							$res['message'] = 'Vui lòng điền <b>giá bán</b> đúng định dạng';
						}

						// Nếu dữ liệu ok hết thì tiến hành tạo sản phẩm
						if ($res['status']) {
							$id = $this->ProductManager->createProduct($data);
							if ($id) {
								$dir = 'uploads/menu/'.$data['typeCode'].'_'.$id.'.'.$duoi;
								// Tiến hành upload file
								if (move_uploaded_file($_FILES['avt']['tmp_name'], $dir)) {
									// cập nhật đường dẫn file cho sản phẩm
									if ($this->ProductManager->updateAvtProduct($id, $dir)) {
										$res['message'] = 'Thêm sản phẩm thành công';
										$this->output->set_status_header(201);
									} else {
										$res['status'] = false;
						            	$res['message'] = 'Cập nhật đường dẫn file lỗi!!';
						            }
								} else {
									// upload file lỗi thì xóa sản phẩm vừa tạo
									$this->ProductManager->deleteProduct($id);
									$res['status'] = false;
					            	$res['message'] = 'Upload file lỗi!!';
					            }
							} else {
								$res['status'] = false;
								$res['message'] = '<b>Tên sản phẩm</b> đã tồn tại!';
							}
						}
					} else { // nếu không phải file ảnh
				        $res['message'] = 'Chỉ được upload file ảnh';
				    }
				} else {
					$res['message'] = 'Lỗi file';
				}

				$this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($res));
			}
			else { // [POST] Cập nhật sản phẩm
				$data['name'] = $this->input->post('name');
				$data['price'] = $this->input->post('price');
				$data['typeCode'] = $this->input->post('typeCode');
				$data['itemsNew'] = $this->input->post('itemsNew');
				$data['bestSeller'] = $this->input->post('bestSeller');
				$data['business'] = $this->input->post('business');
				$data['discountType'] = $this->input->post('discountType');
				$data['discount'] = $this->input->post('discount');
				$data['avt'] = $this->input->post('image-src');

				$res['status'] = false;
				// Nếu thay đổi avt khác
				if ($this->input->post('image-update') != "") {
					$file_name = $_FILES['file']['name'];
					$duoi = pathinfo($file_name, PATHINFO_EXTENSION);
					if ($duoi === 'jpg' || $duoi === 'png' || $duoi === 'gif' || $duoi === 'jpeg') {

						$dir_old = $data['avt'];
						$dir_new = 'uploads/menu/'.$data['typeCode'].'_'.$id.'.'.$duoi;

						$data['avt'] = $dir_new;
						if ($this->ProductManager->updateProductById($id, $data)) {
							$res['status'] = true;
							$res['message'] = 'Cập nhật sản phẩm thành công';
							$res['data'] = $data;
							// Xóa file cũ
							unlink($dir_old);
							// Tiến hành upload file
							move_uploaded_file($_FILES['file']['tmp_name'], $dir_new);
						} else {
							$res['message'] = 'Cập nhật sản phẩm thất bại';
						}
					} else {
						$res['message'] = 'Chỉ được upload file ảnh';
					}
				} else {
					if ($this->ProductManager->updateProductById($id, $data)) {
						$res['status'] = true;
						$res['message'] = 'Cập nhật sản phẩm thành công';
						$res['data'] = $data;
					} else {
						$res['message'] = 'Cập nhật sản phẩm thất bại';
					}
				}

				$this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($res))
		        ->set_status_header(200);
			}
	    } else if ($method == "DELETE") { // [DELETE] Xóa sản phẩm
	    	$res['status'] = false;

			$data = $this->GetData->getProduct($id);
			if ($data) {
				if ($this->ProductManager->deleteProduct($id)) {
					unlink($data[0]['avt']);
					$res['status'] = true;
					$res['message'] = 'Xóa thành công';
				}
			} 

			if ($res['status'] == false) {
				$res['message'] = 'Không thể xóa sản phẩm này, đã có đơn đặt hàng sản phẩm này';
			}

			$this->output
	        ->set_content_type('application/json')
	        ->set_output(json_encode($res))
	        ->set_status_header(200);
		} else {
			$this->output->set_status_header(500);
		}
	}

	// Loại sản phẩm
	public function productType($code = "")
	{
		// Kiểm tra quyền
		if($this->session->userdata('role') != 1){
			$this->output->set_status_header(500);
			die();
		} else {
			$this->load->model('admin/ProductManager');
			$this->load->model('admin/GetData');
		}

		// Kiểm tra phương thức
		$method = $this->input->server('REQUEST_METHOD');
		if ($method == 'GET') { // [GET] Lấy dữ liệu productType
			if ($code === "") {
				$res = $this->GetData->getProductType();
			} else {
				$res = $this->GetData->getProductType($code);
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
		} else if ($method == 'POST') {
			if ($code === "") { // [POST] Tạo dữ liệu productType
				$data['code'] = $this->input->post('code');
				$data['typeName'] = $this->input->post('typeName');
				$data['business'] = $this->input->post('business');
				
				$data['code'] = str_replace(" ", "", $data['code']);
				$data['code'] = strtolower($data['code']);

				if ($this->ProductManager->createProductType($data)) {
					$res['status'] = true;
					$res['message'] = 'Thêm <b>'.$data['code'].'</b> thành công';
				} else {
					$res['status'] = false;
					$res['message'] = 'Thêm <b>'.$data['code'].'</b> thất bại';
				}

				$this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($res))
		        ->set_status_header(201);
			} else { // [POST] Update dữ liệu productType
				$data = array(
					'typeName' => $this->input->post('typeName'),
					'business' => $this->input->post('business')
				);
				$res['status'] = $this->ProductManager->updateProductType($code, $data);
				if ($res['status']) {
					$res['message'] = 'Cập nhật <b style="text-transform: uppercase;">'.$code.'</b> thành công';
				} else {
					$res['message'] = 'Cập nhật <b style="text-transform: uppercase;">'.$code.'</b> thất bại';
				}

				$this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($res))
		        ->set_status_header(200);
			}
		} else if ($method == 'DELETE') { // [DELETE] Xóa productType
			$arrAvt = $this->GetData->getProductAvtByType($code);
			if ($this->ProductManager->deleteProductType($code)) {
				foreach ($arrAvt as $value) {
				    unlink($value['avt']);
				}
				$res['status'] = true;
				$res['message'] = 'Xóa <b style="text-transform: uppercase;">'.$code.'</b> thành công';
			} else {
				$res['status'] = false;
				$res['message'] = 'Xóa <b style="text-transform: uppercase;">'.$code.'</b> thất bại, vui lòng <b>xóa toàn bộ sản phẩm</b> thuộc loại <b style="text-transform: uppercase;">'.$code.'</b> trước';
			}

			$this->output
	        ->set_content_type('application/json')
	        ->set_output(json_encode($res))
	        ->set_status_header(200);
		} else {
			$this->output->set_status_header(500);
		}
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */