<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProductManager extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('role') || $this->session->userdata('role') != 1) {
			$this->output->set_status_header(500);
			die();
		} else {
			$this->load->model('admin/GetData');
		}
	}

	public function index()
	{			
		$data = $this->GetData->getProductType();

		$data = array('productType' => $data);
		$this->load->view('admin/ProductManager/main', $data, FALSE);
	}

	public function CreateProduct()
	{
		$data = $this->GetData->getProductType();

		$data = array('productType' => $data);
		$this->load->view('admin/ProductManager/createProduct', $data, FALSE);
	}

	public function ShowProduct()
	{
		$data = $this->GetData->getProduct();
		// -- sắp xếp typeCode
		// foreach ($data as $key => $value) {
		// 	$typeCode[$key] = $value['typeCode'];
		// }
		// array_multisort($typeCode, SORT_ASC, $data);

		$data = array(
			'menuData' => $data,
			'productType' => $this->GetData->getProductType()
		);
		$this->load->view('admin/ProductManager/showProduct', $data, FALSE);
	}

	public function ShowProductType()
	{
		$data = array(
			'productType' => $this->GetData->getProductType()
		);
		$this->load->view('admin/ProductManager/showProductType', $data, FALSE);
	}
}