<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Play extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('MPlay');
//		$this->MPlay->tes();
//		$this->load->view('includes/header');
	}

	public function index()
	{

		echo date_default_timezone_get();
		echo '<br/>';
//		echo now();

//		echo date('m/d/Y H:i:s', 1580779263);
		echo date ('H:i',strtotime('16:27:54.5533333'));
//		$date = new DateTime('@'.time());
//		echo $date->format('Y-m-d H:i:sP') . "\n";
		exit();
//		echo $this->uuid->v4();

		$this->MPlay->tes($this->uuid->v4(),getBrowserAgent(),get_client_ip());
//		$this->load->library('encryption');
//
//		$plain_text = 'This is a plain-text message!';
//		echo $ciphertext = $this->encryption->encrypt($plain_text);
//		echo '<br/>';
//
//		// Outputs: This is a plain-text message!
//		echo $this->encryption->decrypt($ciphertext);
	}
}
