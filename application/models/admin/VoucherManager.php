<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VoucherManager extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function createVoucher($data)
	{
		$this->db->insert('vouchers', $data);
		return $this->db->insert_id();
	}

	public function updateVoucher($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update('vouchers', $data);
	}

	public function useVoucherCount($id)
	{
		$this->db->where('id', $id);
		$voucher = $this->db->get('vouchers')->row_array();
		$data = array('count' => ($voucher['count'] - 1));
		$this->db->where('id', $id);
		return $this->db->update('vouchers', $data);
	}
}

/* End of file VoucherManager.php */
/* Location: ./application/models/VoucherManager.php */