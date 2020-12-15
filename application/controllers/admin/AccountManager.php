<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AccountManager extends CI_Controller {

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
		$data = $this->GetData->getRole();

		$data = array('role' => $data);
		$this->load->view('admin/AccountManager/main', $data, FALSE);
	}

	public function CreateAccount()
	{
		$this->load->model('admin/GetData');
		$data = $this->GetData->getRole();

		$data = array('role' => $data);
		$this->load->view('admin/AccountManager/createAccount', $data, FALSE);
	}

	public function ShowAccount()
	{
		$this->load->model('admin/GetData');
		
		$data = array(
			'dataAccount' => $this->GetData->getAccountAdmin(),
			'role' => $this->GetData->getRole()
		);
		$this->load->view('admin/AccountManager/showAccount', $data, FALSE);
	}

}