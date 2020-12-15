<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetData extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function getAccountAdmin($id = -1)
	{
		$sql = "SELECT admin_users.id, admin_users.username, admin_users.email, admin_users.phoneNumber, admin_users.firstName, admin_users.lastName, admin_users.role AS 'roleId', admin_role.name AS 'role', admin_users.createBy, admin_users.dateCreate, admin_users.active FROM admin_users INNER JOIN admin_role ON admin_users.role = admin_role.id";
		if ($id != -1) {
			$sql .= " WHERE admin_users.id = $id LIMIT 1";
			return $this->db->query($sql)->row_array();
		}
		return $this->db->query($sql)->result_array();
	}

	public function getRole($id = -1)
	{
		$this->db->select('*');
		if ($id !== -1)
			$this->db->where('id', $id);
		return $this->db->get('admin_role')->result_array();
	}
}

/* End of file GetData.php */
/* Location: ./application/models/GetData.php */