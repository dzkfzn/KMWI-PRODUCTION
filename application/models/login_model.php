<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{

	/**
	 * This function used to check the login credentials of the user
	 * @param string $username : This is email of the user
	 * @param string $password : This is encrypted password of the user
	 */

	function loginMe($username, $password)
	{
		$sp = "prod_checkLogin ?"; //No exec or call needed
		$params = array('p1' => $username);
		sqlsrv_configure('WarningsReturnAsErrors', 0);
		$user = $this->db->query($sp, $params);

		if ($user->num_rows() > 0) {
			foreach ($user->result_array() as $row) {
				if (verifyHashedPassword($password, $row['stf_password'])) {
					return $row;
				} else {
					return array();
				}
			}
		} else {
			return array();
		}
	}


	function recordLogin($params)
	{
		$sp = "prod_createUserLog ?,?,?,?,?,?,?,?,?,?"; //No exec or call needed
		sqlsrv_configure('WarningsReturnAsErrors', 0);
		$this->db->trans_start();
		$result = $this->db->query($sp, $params);
		$this->db->trans_complete();

	}

	/**
	 * This function used to check email exists or not
	 * @param {string} $username : This is users email id
	 * @return {boolean} $result : TRUE/FALSE
	 */
	function checkEmailExist($username)
	{
		$this->db->select('userId');
		$this->db->where('email', $username);
		$this->db->where('isDeleted', 0);
		$query = $this->db->get('tbl_users');

		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}


	/**
	 * This function used to insert reset password data
	 * @param {array} $data : This is reset password data
	 * @return {boolean} $result : TRUE/FALSE
	 */
	function resetPasswordUser($data)
	{
		$result = $this->db->insert('tbl_reset_password', $data);

		if ($result) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * This function is used to get customer information by email-id for forget password email
	 * @param string $username : Email id of customer
	 * @return object $result : Information of customer
	 */
	function getCustomerInfoByEmail($username)
	{
		$this->db->select('userId, email, name');
		$this->db->from('tbl_users');
		$this->db->where('isDeleted', 0);
		$this->db->where('email', $username);
		$query = $this->db->get();

		return $query->result();
	}

	/*
	 * This function used to check correct activation deatails for forget password.
	 * @param string $username : Email id of user
	 * @param string $activation_id : This is activation string
	 */
	function checkActivationDetails($username, $activation_id)
	{
		$this->db->select('id');
		$this->db->from('tbl_reset_password');
		$this->db->where('email', $username);
		$this->db->where('activation_id', $activation_id);
		$query = $this->db->get();
		return $query->num_rows;
	}

	// This function used to create new password by reset link
	function createPasswordUser($username, $password)
	{
		$this->db->where('email', $username);
		$this->db->where('isDeleted', 0);
		$this->db->update('tbl_users', array('password' => getHashedPassword($password)));
		$this->db->delete('tbl_reset_password', array('email' => $username));
	}
}

?>
