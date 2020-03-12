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

	public function menu_product_counting()
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
		$this->loadViews("ppic/product_counting", $this->global, $this->data, NULL);
	}

	public function report_rejection($type_report = NULL)
	{
		if ($type_report == 'daily') {
			$this->form_validation->set_rules('pro_date', 'Date', 'trim|required');
		} else if ($type_report == 'range') {
			$this->form_validation->set_rules('start_pro_date', 'Date', 'trim|required');
			$this->form_validation->set_rules('end_pro_date', 'Date', 'trim|required');
		}

		$this->data['pro_date'] = array(
			'name' => 'pro_date',
			'id' => 'pro_date',
			'class' => 'form-control datepicker',
			'type' => 'text',
			'maxLength' => 10,
			'value' => $this->form_validation->set_value('pro_date'),
		);
		$this->data['start_pro_date'] = array(
			'name' => 'start_pro_date',
			'id' => 'start_pro_date',
			'class' => 'form-control datepicker',
			'type' => 'text',
			'maxLength' => 10,
			'value' => $this->form_validation->set_value('start_pro_date'),
		);
		$this->data['end_pro_date'] = array(
			'name' => 'end_pro_date',
			'id' => 'end_pro_date',
			'class' => 'form-control datepicker',
			'type' => 'text',
			'maxLength' => 10,
			'value' => $this->form_validation->set_value('end_pro_date'),
		);

//		$this->data['form_attribute'] = array(
//			'id' => 'FormValidation'
//		);

		if ($this->form_validation->run() === TRUE) {

			if ($type_report == 'daily') {
				$date = str_replace('/', '-', $this->input->post('pro_date'));
				$report_date = date('Y-m-d', strtotime($date));

				$this->data['report_sta'] = $this->Master_model->any_select($this->sp_list, $this->tbl_report . $this->desc_reject . $this->tbl_station, array($report_date), TRUE);
				$this->data['report_sif'] = $this->Master_model->any_select($this->sp_list, $this->tbl_report . $this->desc_reject . $this->tbl_shift, array($report_date), TRUE);
				$this->data['report_date'] = $report_date;
				$this->set_global('PPIC | Report', 'Report Rejection', 'Currently Working Schedule');
				$this->loadViews("ppic/report_rejection", $this->global, $this->data, NULL);
			} else if ($type_report == 'range') {
				$start = str_replace('/', '-', $this->input->post('start_pro_date'));
				$end = str_replace('/', '-', $this->input->post('end_pro_date'));
				$start = date('Y-m-d', strtotime($start));
				$end = date('Y-m-d', strtotime($end));

				$this->data['report_range'] = $this->Master_model->any_select($this->sp_list, $this->tbl_report . $this->desc_reject . 'AllRange', array($start, $end), TRUE);
				$this->data['report_range_sif'] = $this->Master_model->any_select($this->sp_list, $this->tbl_report . $this->desc_reject . 'ShiftRange', array($start, $end), TRUE);
				$this->data['report_range_sta'] = $this->Master_model->any_select($this->sp_list, $this->tbl_report . $this->desc_reject . 'StationRange', array($start, $end), TRUE);

				$this->data['start_report_date'] = $start;
				$this->data['end_report_date'] = $end;
				$this->set_global('PPIC | Report', 'Report Rejection', 'Currently Working Schedule');
				$this->loadViews("ppic/report_rejection", $this->global, $this->data, NULL);
			}

		} else {
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


			$this->set_global('PPIC | Report', 'Report Rejection', 'Currently Working Schedule');
			$this->loadViews("ppic/report_rejection", $this->global, $this->data, NULL);
		}


	}

	public function report_product_achievement()
	{
		$this->form_validation->set_rules('pro_date', 'Date', 'trim|required');

		$this->data['pro_date'] = array(
			'name' => 'pro_date',
			'id' => 'pro_date',
			'class' => 'form-control monthpicker',
			'type' => 'text',
			'maxLength' => 10,
			'value' => $this->form_validation->set_value('pro_date'),
		);

		if ($this->form_validation->run() === TRUE) {

			$date = explode("/", $this->input->post('pro_date'));
			$month = $date[0];
			$year = $date[1];
//			$this->data['report_sta'] = $this->Master_model->any_select($this->sp_list, $this->tbl_report . $this->desc_achievement . $this->tbl_station, array($month,$year), TRUE);
			$this->data['report_sch'] = $this->Master_model->any_select($this->sp_list, $this->tbl_report . $this->desc_achievement . $this->tbl_schedule, array($month, $year), TRUE);

			$this->set_global('PPIC | Report', 'Report Rejection', 'Currently Working Schedule');
			$this->loadViews("ppic/report_product_achievement", $this->global, $this->data, NULL);

		} else {
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->set_global('PPIC | Report', 'Report Rejection', 'Currently Working Schedule');
			$this->loadViews("ppic/report_product_achievement", $this->global, $this->data, NULL);
		}
	}

	public function report_plan_vs_actual()
	{
		$this->form_validation->set_rules('pro_date', 'Date', 'trim|required');

		$this->data['pro_date'] = array(
			'name' => 'pro_date',
			'id' => 'pro_date',
			'class' => 'form-control datepicker',
			'type' => 'text',
			'maxLength' => 10,
			'value' => $this->form_validation->set_value('pro_date'),
		);

		if ($this->form_validation->run() === TRUE) {

			$date = str_replace('/', '-', $this->input->post('pro_date'));
			$report_date = date('Y-m-d', strtotime($date));

			$this->data['report_sta'] = $this->Master_model->any_select($this->sp_list, $this->tbl_report . $this->desc_pva . $this->tbl_station, array($report_date), TRUE);

			$this->data['report_date'] = $report_date;
//			echo "<pre>";
//			print_r($this->data['report_sta']);
//			exit();

			$this->set_global('PPIC | Report', 'Report Rejection', 'Currently Working Schedule');
			$this->loadViews("ppic/report_plan_vs_actual", $this->global, $this->data, NULL);

		} else {
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->set_global('PPIC | Report', 'Report Rejection', 'Currently Working Schedule');
			$this->loadViews("ppic/report_plan_vs_actual", $this->global, $this->data, NULL);
		}
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

	public function schedule_history()
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
		$this->data['schedule_today'] = $this->Master_model->any_select($this->sp_list, $this->tbl_schedule . $this->desc_history);
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

			$this->ion_auth->set_message('Schedule Confirmed!');
			$this->session->set_flashdata('message', $this->ion_auth->messages());

			redirect('production/schedule', 'refresh');
		} else {
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


			$this->data['cycle_time'] = array(
				'name' => 'cycle_time[]',
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

	public function schedule_generate_status($prod_date, $start_date, $end_date)
	{
		$is_production_date_today = is_now_date_same($prod_date);
		$is_time_between_shift = is_now_time_between($start_date, $end_date);
		$is_pass_night = is_shift_pass_midnight($start_date, $end_date);
		$is_time_before_shift = is_time_before($start_date);
		if ($is_production_date_today) {
			if ($is_time_between_shift) {
				$time = ago($prod_date, $end_date, FALSE, FALSE, $is_pass_night);
				return ('working ' . $time . ' Left');
			} else if ($is_time_before_shift) {
				$time = ago($prod_date, $start_date);
				return ('to be worked ' . $time);
			} else {
				$time = ago($prod_date, $end_date, FALSE, FALSE, $is_pass_night);
				return ('finished ' . $time);
			}
		} else {
			$time = ago($prod_date, $start_date);
			return ('to be worked ' . $time);
		}

	}

//	public function dashboard()
//	{
//
//		$id = $this->data['productions'] = $this->Master_model->any_select($this->sp_detail, $this->tbl_schedule . $this->desc_today . 'Dashboard');
//		$this->data['productions'] = $this->Master_model->any_select($this->sp_list, $this->tbl_production, array($id), TRUE);
//		$this->data['schedule'] = $this->Master_model->any_select($this->sp_detail, $this->tbl_schedule, array($id));
//		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
//
//		$this->data['form_attribute'] = array(
//			'id' => 'FormValidation',
//			'class' => 'form-horizontal'
//		);
//		$this->set_global('PPIC | Dashboard', 'Dashboard', 'Currently Working Schedule');
//
//		$this->loadViews("ppic/dashboard", $this->global, $this->data, NULL);
//	}

	public function schedule_detail($id)
	{
		if (!$this->is_any_verified($id, $this->tbl_schedule))
			return;

		$this->data['productions'] = $this->Master_model->any_select($this->sp_list, $this->tbl_production, array($id), TRUE);
		$this->data['schedule'] = $this->Master_model->any_select($this->sp_detail, $this->tbl_schedule, array($id));
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		$this->data['form_attribute'] = array(
			'id' => 'FormValidation',
			'class' => 'form-horizontal'
		);
		$this->set_global('PPIC | Manage Master - Schedule', 'Manage Master Data Schedule', 'Detail Schedule');

		$this->loadViews("ppic/schedule_detail", $this->global, $this->data, NULL);

	}

	public function scheme_edit($id, $is_editable = TRUE)
	{

		if (!$this->is_any_verified($id, $this->tbl_scheme)) return;
		$scheme = $this->Master_model->any_select($this->sp_detail, $this->tbl_scheme, array($id));


		// validate form input
		$this->form_validation->set_rules('name', ' Name', 'required|trim|max_length[36]');
		$this->form_validation->set_rules('output', 'output', 'trim|max_length[36]');

		if (isset($_POST) && !empty($_POST)) {
			// do we have a valid request?
			if ($id != $this->input->post('id')) {
				show_error($this->lang->line('error_csrf'));
			}

			if ($this->form_validation->run() === TRUE) {

				$data = array(
					$id,
					$this->input->post('name'),
					$this->input->post('output'),
					$creaby = $this->session->userdata('username'),
				);
				$station = $this->input->post('station');
				// check to see if we are updating the user
				if ($this->Master_model->any_exec($data, $this->sp_update, $this->tbl_scheme)) {
					$this->Master_model->any_exec(array($id), $this->sp_delete, $this->tbl_scheme_detail);
					foreach ($station as $key => $value) {
						$this->Master_model->any_exec(array($this->uuid->v4(), $value, $id), $this->sp_insert, $this->tbl_scheme_detail);
					}
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->ion_auth->set_message('scheme Updated Succesfully');
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					redirect('production/scheme');
				} else {
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->ion_auth->set_message('Failed to Update');
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					redirect('production/scheme');
				}

			}
		}

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


		if ($is_editable) {
			$this->set_global('PPIC | Manage Master - scheme', 'Manage Master Data scheme', 'Edit scheme');
			$is_disabled = 'enabled';
		} else {
			$is_disabled = 'disabled';
			$this->set_global('PPIC | Manage Master - scheme', 'Manage Master Data scheme', 'Detail scheme');
			$this->data['creaby'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'output' => 'text',
				'value' => $this->form_validation->set_value('creaby', $scheme->sce_creaby)
			);
			$this->data['creadate'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'output' => 'text',
				'value' => $this->form_validation->set_value('creadate', time_elapsed_string($scheme->sce_creadate) . ' (' . print_beauty_date($scheme->sce_creadate) . ')')
			);
			$this->data['modiby'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'output' => 'text',
				'value' => $this->form_validation->set_value('modiby', is_null_modiby($scheme->sce_modiby))
			);
			$this->data['modidate'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'output' => 'text',
				'value' => $this->form_validation->set_value('modidate', is_null_modiby($scheme->sce_modidate, TRUE) . ' (' . print_beauty_date($scheme->sce_modidate) . ')')
			);
			$this->data['status'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'output' => 'text',
				'value' => $this->form_validation->set_value('status', ($scheme->sce_is_deleted) ? 'Inactive' : 'Active')
			);
		}

		foreach ($this->Master_model->any_select($this->sp_list_active, $this->tbl_station) as $row) {
			$this->data['option_station'][$row->sta_id] = $row->sta_name . ' - ' . $row->sta_type;
		}

		$this->data['schema_detail'] = $this->Master_model->any_select($this->sp_list, $this->tbl_scheme_detail, array($id), TRUE);

		foreach ($this->data['schema_detail'] as $row) {
			$this->data['station_selected'][$row->sta_id] = $row->sta_id;
		}
		$this->data['station_extra'] =
			'class="selectpicker" 
				 data-style="select-with-transition"
				 title="Choose Station"
				 data-size="7"
				 id="station"
				 ';


		// pass the user to the view
		$this->data['scheme'] = $scheme;
		$this->data['name'] = array(
			'name' => 'name',
			'id' => 'name',
			$is_disabled => $is_disabled,
			'class' => 'form-control',
			'output' => 'text',
			'required' => TRUE,
			'value' => $this->form_validation->set_value('name', $scheme->sce_name)
		);
		$this->data['output'] = array(
			'name' => 'output',
			'id' => 'output',
			$is_disabled => $is_disabled,
			'class' => 'form-control',
			'output' => 'text',
			'value' => $this->form_validation->set_value('output', $scheme->sce_output)
		);

		$this->data['form_attribute'] = array(
			'id' => 'FormValidation',
			'class' => 'form-horizontal'
		);

		if ($is_editable)
			$this->loadViews("admin/scheme_edit", $this->global, $this->data, NULL);
		else
			$this->loadViews("admin/scheme_detail", $this->global, $this->data, NULL);

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
