<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OrderManager extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function applyOrderOffline($id, $user)
	{
		return $this->applyOrder($id, $user, 2);
	}

	public function applyOrderOnline($id, $user)
	{
		return $this->applyOrder($id, $user, 3);
	}

	public function applyOrderSuccess($id, $user)
	{
		return $this->applyOrder($id, $user, 4);
	}

	private function applyOrder($id, $user , $orderStatus) {
		$data = array('status' => $orderStatus);
		$order_confirm = array(
			'orderId' => $id,
			'adminId' => $user,
			'orderStatus' => $orderStatus
		);
		$this->db->trans_start();
		$this->db->insert('order_confirm', $order_confirm);
		$this->db->where('id', $id);
		$this->db->update('orders', $data);
		return $this->db->trans_complete();
	}

	public function deleteOrder($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('orders');
	}
	
	public function OrderConfirm($id)
	{
		$data = array('status' => 2);
		$this->db->select('*');
		$this->db->where('id', $id);
		if ($this->db->get('orders')->result_array()){
			$this->db->where('id', $id);
			return $this->db->update('orders', $data);
		} else {
			return false;
		}
	}

	public function orderCancel($id, $data, $user)
	{
		return $this->applyOrder($id, $user, 5);
	}
}

/* End of file OrderManager.php */
/* Location: ./application/models/OrderManager.php */