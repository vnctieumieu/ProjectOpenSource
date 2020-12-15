<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProductManager extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}
	public function createProduct($data)
	{
		$this->db->insert('product', $data);
		return $this->db->insert_id();
	}

	public function updateAvtProduct($id, $avt)
	{
		$data = array(
			'avt' => $avt
		);
		$this->db->where('id', $id);
		return $this->db->update('product', $data);
	}

	public function deleteProduct($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('product');
	}

	public function deleteProductByTypeCode($typeCode)
	{
		$this->db->where('typeCode', $typeCode);
		return $this->db->delete('product');
	}

	public function updateProductById($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update('product', $data);
	}

	// Product Type
	public function createProductType($data)
	{
		return $this->db->insert('product_type', $data);
	}
	public function updateProductType($code, $data)
	{
		$this->db->where('code', $code);
		return $this->db->update('product_type', $data);
	}
	public function deleteProductType($code)
	{
		$this->db->where('code', $code);
		return $this->db->delete('product_type');
	}
}