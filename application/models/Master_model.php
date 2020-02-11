<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_model extends CI_Model
{

	function any_select($action, $table, $params = FALSE, $is_list = FALSE)
	{
		if ($params) {
			$n = "";
			for ($i = 1; $i <= count($params); $i++) {
				$n .= "?,";
			}
			$n = substr($n, 0, -1);
			$sp = 'prod_' . $action . $table . ' ' . $n;
			$result = $this->db->query($sp, $params);
			if (!$is_list)
				return $result->row();
			else
				return $result->result();
		} else {
			$sp = 'prod_' . $action . $table;
			$result = $this->db->query($sp);
			return $result->result();
		}
	}


	function any_exec($params, $action, $table)
	{
		$n = "";
		for ($i = 1; $i <= count($params); $i++) {
			$n .= "?,";
		}
		$n = substr($n, 0, -1);
		$sp = 'prod_' . $action . $table . ' ' . $n;

		sqlsrv_configure('WarningsReturnAsErrors', 0);
		$this->db->trans_start();
		$this->db->query($sp, $params);
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
}
