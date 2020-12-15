<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AuthUser extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function Validate($username)
	{
		$this->db->where('userName', $username);
		return $this->db->get('admin_users', 0, 1)->row_array();
	}

	public function updatePwd($username, $data)
	{
		$this->db->where('username', $username);
		return $this->db->update('admin_users', $data);
	}
}

/* End of file AuthUser.php */
/* Location: ./application/models/AuthUser.php */