<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MPlay extends CI_Model
{

	/*
	 $sp = "MOBILE_COM_SP_GetCallXXX ?,?,?,?,?,?,?,?,?,? "; //No exec or call needed

	 //No @ needed.  Codeigniter gets it right either way
	 $params = array(
				'PARAM_1' => NULL,
				'PARAM_2' => NULL,
				'PARAM_3' => NULL,
				'PARAM_4' => NULL,
				'PARAM_5' => NULL,
				'PARAM_6' => NULL,
				'PARAM_7' => NULL,
				'PARAM_8' => NULL,
				'PARAM_9' => NULL,
				'PARAM_10' =>NULL);

	 //Here's the magic...
	 sqlsrv_configure('WarningsReturnAsErrors', 0);

	 //Even if I don't make the connect explicitly, I can configure sqlsrv
	 //and get it running using $this->db->query....

	 $result = $this->db->query($sp,$params);
	 */

	function tes($p1,$p2,$p3)
	{
		$sp = "prod_createUserLog ?,?,? "; //No exec or call needed

		//No @ needed.  Codeigniter gets it right either way
		$params = array(
			'p1' => $p1,
			'p2' => $p2,
			'p3' => $p3);

		//Here's the magic...
		sqlsrv_configure('WarningsReturnAsErrors', 0);

		//Even if I don't make the connect explicitly, I can configure sqlsrv
		//and get it running using $this->db->query....

		echo $result = $this->db->query($sp,$params);


	}


	/*
	 $sp = "prod_checkLogin"; //No exec or call needed
		$params = array('p1' => $username);
		sqlsrv_configure('WarningsReturnAsErrors', 0);
		$user = $this->db->query($sp);
//		print_r( sqlsrv_errors());
		foreach ($user->result_array() as $row)
		{
			print_r($row);
			exit();
		}
	 */




}
