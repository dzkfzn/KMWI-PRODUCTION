<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Ppic extends BaseController
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
		if (!$this->ion_auth->is_ppic()) {
			show_error('You must be a Ppic to view this page.');
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
			$this->set_global('Admin | Manage Master - ' . $table, 'Manage Master Data ' . $table);
			$this->loadViews("errors/custom/404", $this->global, NULL, NULL);
			return FALSE;
		}
		return TRUE;
	}

	public function index()
	{
		redirect('production', 'refresh');
	}


	public function schedule_today()
	{
		//remove failed schedule
		if ($this->session->has_userdata('id_schedule')) {
			$this->Master_model->any_exec(array($this->session->userdata('id_schedule')), $this->sp_delete, $this->tbl_schedule);
			$this->session->unset_userdata('id_schedule');
		}

		//global var
		$this->global['gPageTitle'] = 'PPIC | Manage Schedule - Schedule Today View';
		$this->global['gContentTitle'] = 'Manage Schedule';
		$this->global['gCardTitle'] = 'Schedule Today List';
		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

		//list the stations
		$this->data['schedule_today'] = $this->Master_model->any_select($this->sp_list, $this->tbl_schedule . $this->desc_today);
		$this->loadViews("ppic/schedule_list_today", $this->global, $this->data, NULL);
	}


	public function schedule_create_step1()
	{
		$this->form_validation->set_rules('pro_date', 'Production Date', 'trim|required|callback_is_greater_today');
		$this->form_validation->set_rules('shift', ' Shift', 'required|trim');
		$this->form_validation->set_rules('product', 'Product', 'trim|required');
		$this->form_validation->set_rules('scheme', 'Schema', 'trim|required');
		$this->form_validation->set_rules('plan', 'Plan', 'trim|required|is_natural_no_zero');


		if ($this->form_validation->run() === TRUE) {
			$id = $this->uuid->v4();
			$date = str_replace('/', '-', $this->input->post('pro_date'));
			$pro_date = date('Y-m-d', strtotime($date));
			$shift = $this->input->post('shift');
			$product = $this->input->post('product');
			$scheme = $this->input->post('scheme');
			$plan = $this->input->post('plan');;
			$creadate = date('m/d/Y h:i:s a', time());
			$creaby = $this->session->userdata('username');

			$check_schedule = $this->Master_model->any_select($this->sp_check, $this->tbl_schedule, array($shift, $pro_date), TRUE);
			$data = array($id, $shift, $scheme, $product, $pro_date, $plan, $creaby, $creadate);
		}

		if ($this->form_validation->run() === TRUE && !$check_schedule) {
			{
				$this->Master_model->any_exec($data, $this->sp_insert, $this->tbl_schedule);
				$token = bin2hex(random_bytes(40 / 2));
				$this->session->set_userdata('token_schedule1', $token);
				$this->session->set_userdata('id_schedule', $id);
				redirect('production/schedule/add/2/' . $id . '/' . $scheme, 'refresh');
			}
		} else {

			if (isset($check_schedule)) {
				$this->ion_auth->set_error('the schedule on ' . print_beauty_date($pro_date) . ' and chosen shift already exists');
				$this->session->set_flashdata('message', $this->ion_auth->errors());
			}
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			foreach ($this->Master_model->any_select($this->sp_list_active, $this->tbl_shift) as $row) {
				$this->data['option_shift'][$row->sif_id] = $row->sif_name . ' (' . print_beauty_time($row->sif_start_date) . ' - ' . print_beauty_time($row->sif_end_date) . ')';
			}
			foreach ($this->Master_model->any_select($this->sp_list_active, $this->tbl_product) as $row) {
				$this->data['option_product'][$row->pro_id] = $row->pro_name . ' - ' . $row->pro_type;
			}
			foreach ($this->Master_model->any_select($this->sp_list_active, $this->tbl_scheme) as $row) {
				$this->data['option_scheme'][$row->sce_id] = $row->sce_name;
			}

			$this->data['dropdown_extra'] =
				'class="selectpicker" 
				 data-style="select-with-transition"
				 title="Choose"
				 data-size="7"
				 ';

			$this->data['pro_date'] = array(
				'name' => 'pro_date',
				'id' => 'pro_date',
				'class' => 'form-control datepicker',
				'type' => 'text',
				'maxLength' => 10,
				'required' => TRUE,
				'value' => $this->form_validation->set_value('pro_date'),
			);
			$this->data['plan'] = array(
				'name' => 'plan',
				'id' => 'plan',
				'class' => 'form-control',
				'type' => 'number',
				'required' => TRUE,
				'value' => $this->form_validation->set_value('plan'),
			);

			$this->data['form_attribute'] = array(
				'id' => 'FormValidation',
				'class' => 'form-horizontal'
			);

			$this->global['gPageTitle'] = 'PPIC | Schedule';
			$this->global['gContentTitle'] = 'Manage Schedule';
			$this->global['gCardTitle'] = 'Add Schedule';
			$this->loadViews("ppic/schedule_add", $this->global, $this->data, NULL);

		}
	}

	public function schedule_create_step2($id = NULL, $id_schema = NULL)
	{
		if (!$this->is_any_verified($id, $this->tbl_schedule) || !$this->is_any_verified($id_schema, $this->tbl_scheme))
			return;

		if (!$this->session->has_userdata('token_schedule1'))
			show_error('You must input from beginning.');

		$this->form_validation->set_rules('cycle_time[]', 'Cycle Time', 'trim|required|max_length[8]|callback_no_zero_second');
		$this->data['stations'] = $this->Master_model->any_select($this->sp_list, $this->tbl_scheme_detail, array($id_schema), TRUE);
		$this->data['schema'] = $this->Master_model->any_select($this->sp_detail, $this->tbl_scheme, array($id_schema));

		if ($this->form_validation->run() === TRUE) {
			$this->session->unset_userdata('token_schedule1');
			$cycle_time = $this->input->post('cycle_time');

			$i = 0;
			foreach ($this->data['stations'] as $row) {
				$this->Master_model->any_exec(array($this->uuid->v4(), $id, $row->sta_id, $cycle_time[$i]), $this->sp_insert, $this->tbl_production);
				$i++;
			}
			$token = bin2hex(random_bytes(40 / 2));
			$this->session->set_userdata('token_schedule2', $token);
			$this->session->set_userdata('id_schedule', $id);

			redirect('production/schedule/add/3/' . $id, 'refresh');
		} else {
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['cycle_time'] = array(
				'name' => 'cycle_time[]',
				'id' => 'cycle_time',
				'class' => 'form-control timepickersecond',
				'type' => 'text',
				'required' => 'required',
				'maxLength' => 8
			);

			$this->data['form_attribute'] = array(
				'id' => 'FormValidation',
				'class' => 'form-horizontal'
			);

			$this->global['gPageTitle'] = 'PPIC | Schedule';
			$this->global['gContentTitle'] = 'Manage Schedule';
			$this->global['gCardTitle'] = 'Add Cycle Time Each Station';
			$this->loadViews("ppic/schedule_add2", $this->global, $this->data, NULL);

		}
	}

	public function schedule_create_step3($id, $submit = FALSE)
	{

		if (!$this->is_any_verified($id, $this->tbl_schedule))
			return;

		if (!$this->session->has_userdata('token_schedule2'))
			show_error('You must input from beginning.');

		$this->data['productions'] = $this->Master_model->any_select($this->sp_list, $this->tbl_production, array($id), TRUE);
		$this->data['schedule'] = $this->Master_model->any_select($this->sp_detail, $this->tbl_schedule, array($id));

		if ($submit) {

			$this->Master_model->any_exec(array($id, $this->session->userdata('username')), $this->sp_active, $this->tbl_schedule);
			$this->session->unset_userdata('token_schedule2');
			$this->session->unset_userdata('id_schedule');

			$this->ion_auth->set_message('Schedule Confirmed! You can still update it while it still not started yet!');
			$this->session->set_flashdata('message', $this->ion_auth->messages());

			redirect('production/schedule', 'refresh');
		} else {
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


			$this->data['cycle_time'] = array(
				'name' => '',
				'id' => 'cycle_time',
				'type' => 'text',
				'class' => 'form-control',
				'readonly' => 'readonly',
				'required' => 'required',
			);

			$this->data['pro_date'] = array(
				'name' => 'pro_date',
				'id' => 'pro_date',
				'class' => 'form-control',
				'readonly' => 'readonly',
				'required' => TRUE,
				'value' => $this->form_validation->set_value('pro_date', print_beauty_date($this->data['schedule']->sch_production_date)),
			);
			$this->data['plan'] = array(
				'name' => 'plan',
				'id' => 'plan',
				'readonly' => 'readonly',
				'class' => 'form-control',
				'required' => TRUE,
				'value' => $this->form_validation->set_value('plan', $this->data['schedule']->sch_plan . ' Unit'),
			);
			$this->data['shift'] = array(
				'name' => 'shift',
				'id' => 'shift',
				'readonly' => 'readonly',
				'class' => 'form-control',
				'required' => TRUE,
				'value' => $this->form_validation->set_value('shift', $this->data['schedule']->sif_name . ' (' . print_beauty_time($this->data['schedule']->sif_start_date) . ' - ' . print_beauty_time($this->data['schedule']->sif_end_date) . ')'),
			);
			$this->data['product'] = array(
				'name' => 'product',
				'id' => 'product',
				'readonly' => 'readonly',
				'class' => 'form-control',
				'required' => TRUE,
				'value' => $this->form_validation->set_value('product', $this->data['schedule']->pro_name),
			);
			$this->data['scheme'] = array(
				'name' => 'scheme',
				'id' => 'scheme',
				'readonly' => 'readonly',
				'class' => 'form-control',
				'required' => TRUE,
				'value' => $this->form_validation->set_value('scheme', $this->data['schedule']->sce_name),
			);

			$this->data['form_attribute'] = array(
				'id' => 'FormValidation',
				'class' => 'form-horizontal'
			);

			$this->global['gPageTitle'] = 'PPIC | Schedule';
			$this->global['gContentTitle'] = 'Manage Schedule';
			$this->global['gCardTitle'] = 'Confirm Add Schedule';
			$this->loadViews("ppic/schedule_add3", $this->global, $this->data, NULL);

		}

	}

	public function schedule_detail($id){
		
	}

	public function schedule_create($step, $id = NULL, $id_schema = NULL)
	{
		if ($step == 1)
			$this->schedule_create_step1();
		else if ($step == 2)
			$this->schedule_create_step2($id, $id_schema);
		else if ($step == 3)
			$this->schedule_create_step3($id);
		else
			redirect('production/schedule', 'refresh');

	}


	public function schedule_inactive($id)
	{
		if (!$this->is_any_verified($id, $this->tbl_schedule)) return;
		$this->Master_model->any_exec(array($id, $this->session->userdata('username')), $this->sp_inactive, $this->tbl_schedule);
		$this->ion_auth->set_message('Schedule Deleted');
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect("production/schedule", 'refresh');

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
