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

	public function getProduct($id = -1)
	{
		$this->db->select('*');
		if ($id != -1) {
			$this->db->where('id', $id);
		}
		return $this->db->get('product')->result_array();
	}

	public function getProductAvtByType($type)
	{
		$this->db->select('avt');
		$this->db->where('typeCode', $type);
		return $this->db->get('product')->result_array();
	}

	public function getProductType($code = "")
	{
		$this->db->select('*');
		if ($code != "") {
			$this->db->where('code', $code);
		}
		return $this->db->get('product_type')->result_array();
	}

	public function getOrderOffline($id = -1)
	{
		$this->db->select('*');
		if ($id !== -1)
			$this->db->where('id', $id);
		$this->db->where('status', 1);
		return $this->db->get('orders')->result_array();
	}
	
	public function getOrderOnline($id = -1)
	{
		$this->db->select('*');
		if ($id !== -1)
			$this->db->where('id', $id);
		$this->db->where('status', 2);
		return $this->db->get('orders')->result_array();
	}

	public function getOrderSuccess($id = -1)
	{
		$this->db->select('*');
		if ($id !== -1)
			$this->db->where('id', $id);
		$this->db->where('status', 3);
		return $this->db->get('orders')->result_array();
	}

	public function getOrderHistory($start = -1, $end = -1)
	{
		if ($start !== -1 && $end !== -1)
			$sql = "SELECT * FROM orders where (status = '4' or status = '5') and id > ".$start." and id < ".$end;
		else
			$sql = "SELECT * FROM orders where status = '4' or status = '5'";
		return $this->db->query($sql)->result_array();
	}

	public function getOrderDetail($orderId = -1)
	{
		$this->db->select('*');
		if ($orderId !== -1)
			$this->db->where('orderId', $orderId);
		return $this->db->get('order_details')->result_array();
	}

	public function getVoucher($id = -1)
	{
		$this->db->select('*');
		if ($id !== -1)
			$this->db->where('id', $id);
		return $this->db->get('vouchers')->result_array();
	}

	public function getVoucherByCode($code)
	{
		$this->db->select('*');
		$this->db->where('code', $code);
		return $this->db->get('vouchers')->row_array();
	}

	public function getPaymentMethod($id = -1)
	{
		$this->db->select('*');
		if ($id !== -1) {
			$this->db->where('id', $id);
			return $this->db->get('payment_method')->row_array();
		}
		return $this->db->get('payment_method')->result_array();
	}
}

/* End of file GetData.php */
/* Location: ./application/models/GetData.php */