<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_modal extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function onlinePayment($data)
	{
		return $this->insertOrder($data, 0);
	}
	
	public function online($data)
	{
		return $this->insertOrder($data, 2);
	}

	public function offline($data)
	{
		return $this->insertOrder($data, 1);
	}

	function insertOrder($data, $status)
	{
		foreach ($data as $key => $value) {
			if ($key != 'productList') {
				$order[$key] = $value;
			}
		}
		$order['status'] = $status;
		$this->db->trans_start();
		$this->db->insert('orders', $order);
		foreach ($data['productList'] as $value) {
			$order_details = array(
				'orderId' => $data['id'],
				'productId' => $value['id'],
				'productAmount' => $value['amount']
			);
			$this->db->insert('order_details', $order_details);
		}
		return $this->db->trans_complete();
	}
}

/* End of file Order.php */
/* Location: ./application/models/Order.php */