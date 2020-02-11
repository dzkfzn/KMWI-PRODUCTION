<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Portal extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		//Do your magic here

	}

	public function index()
	{
		$this->load->view('portal');
	}

}


/* End of file filename.php */
