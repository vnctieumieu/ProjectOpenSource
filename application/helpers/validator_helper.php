<?php
	// chuỗi rỗng => true
	function isRequired($str) {
		if ($str == '0')
			return false;
		return empty($str) ? true : false;
	}

	// có số trong chuỗi => true
	function checkNumber($str) {
		return !!preg_match("/([0-9])/",$str);
	}

	// có kí tự khác ngoài số => false
	function isNumber($number) {
		return !!preg_match("/^[0-9]*$/",$number);
	}

	// Có kí tự đặc biệt => true
	function checkKiTuDacBiet($string) {
		return preg_match('/[!@#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/', $string);
	}

	// Có kí tự cấm trong HTML => true
	function checkHTML($string) {
		return !!preg_match('/[<>{}\/\\\\]/', $string);	
	}

	function minMaxLength($str, $min, $max)
	{
		$length = strlen($str);
		return ($length < $min || $length > $max) ? true : false;
	}
?>