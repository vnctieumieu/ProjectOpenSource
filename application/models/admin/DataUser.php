<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DataUser extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function getData($userName)
	{
		// $sql = "SELECT admins.* , admin_duty_level.duty
		// 		FROM admins, admin_duty_level
		// 		WHERE admins.userName='$userName' AND admins.level=admin_duty_level.level";

		$sql = "SELECT *
				FROM admins
				INNER JOIN admin_duty_level
				ON admins.userName='$userName' AND admins.level=admin_duty_level.level";
		
		return $this->db->query($sql)->row_array();
	}
}

/* End of file DataUser.php */
/* Location: ./application/models/DataUser.php */