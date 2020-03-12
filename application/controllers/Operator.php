<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Operator extends BaseController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');
		$this->load->model('Master_model');
		if (!$this->ion_auth->logged_in()) {
			redirect('production/login', 'refresh');
		}
		if (!$this->ion_auth->is_operator()) {
			show_error('You must be a Operator to view this page.');
		}
	}

	public function show404()
	{
		$this->set_global('Error', 'Error');
		$this->loadViews("errors/custom/404", $this->global, NULL, NULL);

	}

	public function is_any_verified($id, $table)
	{
		if (is_null_station($this->Master_model->any_select($this->sp_detail, $table, array($id)))) {
			$this->set_global('PPIC | Manage Master - ' . $table, 'Manage Master Data ' . $table);
			$this->loadViews("errors/custom/404", $this->global, NULL, NULL);
			return FALSE;
		}
		return TRUE;
	}

	public function index()
	{
		redirect('production', 'refresh');
	}

	public function menu_line_overview()
	{
		$sch = $this->Master_model->any_select($this->sp_detail, $this->tbl_schedule . $this->desc_today . 'Dashboard', FALSE, FALSE, TRUE);
		$id = NULL;
		if ($sch)
			$id = $sch->sch_id;

		$this->data['productions'] = $this->Master_model->any_select($this->sp_list, $this->tbl_production, array($id), TRUE);
		$this->data['schedule'] = $this->Master_model->any_select($this->sp_detail, $this->tbl_schedule, array($id));
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		$this->data['form_attribute'] = array(
			'id' => 'FormValidation',
			'class' => 'form-horizontal'
		);
		$this->set_global('PPIC | Dashboard', 'Dashboard', 'Currently Working Schedule');

		$this->loadViews("ppic/line_overview", $this->global, $this->data, NULL);
	}



	function is_time_format($time)
	{
		//if time is invalid, it will return false and error message
		if (!DateTime::createFromFormat('g:i A', $time)) {
			$this->form_validation->set_message('is_time_format', '%s invalid format');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function is_greater_today($date)
	{
		$date_now = date("d/m/Y", strtotime("-1 days"));
		if ($date_now >= $date) {
			$this->form_validation->set_message('is_greater_today', '%s field must greater than today');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function no_zero_second($time)
	{
		if (timeToSeconds($time) <= 0) {
			$this->form_validation->set_message('no_zero_second', '%s field must greater than zero second');
			return FALSE;
		} else {
			return TRUE;
		}
	}
}

/* End of file Master.php */
