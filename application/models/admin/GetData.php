<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetData extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
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
}

/* End of file GetData.php */
/* Location: ./application/models/GetData.php */