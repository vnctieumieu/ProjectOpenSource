<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AccountManager extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function updateAccount($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update('admin_users', $data);
	}
}

/* End of file AccountManager.php */
/* Location: ./application/models/AccountManager.php */