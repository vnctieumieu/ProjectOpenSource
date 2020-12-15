<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CreateUser extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}
	public function AddData($data)
	{
		$this->db->insert('admin_users', $data);
		return $this->db->insert_id();
	}
}

/* End of file CreateUser.php */
/* Location: ./application/models/CreateUser.php */