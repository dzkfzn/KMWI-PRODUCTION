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


	public function tes()
	{
		$now = new DateTime(date("H:i"));

		$start = new DateTime('16:00');
		$end = new DateTime('01:00');
		echo '<pre>';

		print_r($start);
		print_r($end);
//	$end = DateTime::createFromFormat('H:i', $end_date);
		if ($start > $end) {
			echo 'True';
			$end->modify('+1 day');
		} else
			echo 'FALSE';
		echo '<pre>';

		print_r($start);
		print_r($end);
		exit();
		return FALSE;
	}

	public function index()
	{
//		print_r($first_date = new DateTime("2020-02-12" . "17:03"));
////		echo DateTime::createFromFormat('H:i', '');
//		$ago = new DateTime('16:30:00.0000000');
//		print_r($ago);
//		echo is_now_time_between('16:30', '17:02');
//		exit();
		print_r(new DateTime("2020-02-12              " . "         17:03"));

		echo ago("2020-02-12", "19:30");
		exit();
		echo '<pre>';
//		echo $current_time = date("H:i:s");
		echo $current_time = '07:00';
		$start = DateTime::createFromFormat('H:i', "07:00");
		$start = DateTime::createFromFormat('H:i', "07:00");
		$end = DateTime::createFromFormat('H:i', "16:30");
		print_r($now = new DateTime($current_time));
		if ($start <= $now && $now <= $end) {
			echo 'true';
		}
		$noww = new DateTime(date("H:i"));
		$since_start = $noww->diff($start);
		echo $since_start->days . ' days total<br>';
		echo $since_start->y . ' years<br>';
		echo $since_start->m . ' months<br>';
		echo $since_start->d . ' days<br>';
		echo $since_start->h . ' hours<br>';
		echo $since_start->i . ' minutes<br>';
		echo $since_start->s . ' seconds<br>';
		exit();
		echo date_default_timezone_get();
		echo '<br/>';
//		echo now();

//		echo date('m/d/Y H:i:s', 1580779263);
		echo date('H:i', strtotime('16:27:54.5533333'));
//		$date = new DateTime('@'.time());
//		echo $date->format('Y-m-d H:i:sP') . "\n";
		exit();
//		echo $this->uuid->v4();

		$this->MPlay->tes($this->uuid->v4(), getBrowserAgent(), get_client_ip());
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
