<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetData extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}
	
	public function getOrderHistory($start = -1, $end = -1)
	{
		if ($start !== -1 && $end !== -1)
			$sql = "SELECT * FROM orders where (status = '4' or status = '5') and id > ".$start." and id < ".$end;
		else
			$sql = "SELECT * FROM orders where status = '4' or status = '5'";
		return $this->db->query($sql)->result_array();
	}
}

/* End of file GetData.php */
/* Location: ./application/models/GetData.php */