<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Master extends BaseController
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
		if (!$this->ion_auth->is_admin()) {
			show_error('You must be an administrator to view this page.');
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


	public function station()
	{
		//global var
		$this->global['gPageTitle'] = 'Admin | Manage Master - Station';
		$this->global['gContentTitle'] = 'Manage Master Data Station';
		$this->global['gCardTitle'] = 'Station List';
		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

		//list the stations
		$this->data['stations'] = $this->Master_model->any_select($this->sp_list, $this->tbl_station);
		$this->loadViews("admin/station_list", $this->global, $this->data, NULL);
	}

	public function scheme()
	{
		//global var
		$this->global['gPageTitle'] = 'Admin | Manage Master - Scheme';
		$this->global['gContentTitle'] = 'Manage Master Data Scheme';
		$this->global['gCardTitle'] = 'Scheme List';
		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

		//list the stations
		$this->data['schemes'] = $this->Master_model->any_select($this->sp_list, $this->tbl_scheme);
		$this->loadViews("admin/scheme_list", $this->global, $this->data, NULL);
	}

	public function product()
	{
		//global var
		$this->global['gPageTitle'] = 'Admin | Manage Master - Product';
		$this->global['gContentTitle'] = 'Manage Master Data Product';
		$this->global['gCardTitle'] = 'Product List';
		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

		//list the stations
		$this->data['products'] = $this->Master_model->any_select($this->sp_list, $this->tbl_product);
		$this->loadViews("admin/product_list", $this->global, $this->data, NULL);
	}

	public function shift()
	{
		//global var
		$this->global['gPageTitle'] = 'Admin | Manage Master - Shift';
		$this->global['gContentTitle'] = 'Manage Master Data Shift';
		$this->global['gCardTitle'] = 'Shift List';
		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

		//list the stations
		$this->data['shifts'] = $this->Master_model->any_select($this->sp_list, $this->tbl_shift);
		$this->loadViews("admin/shift_list", $this->global, $this->data, NULL);
	}


	public function station_activate($id)
	{
		if (!$this->is_any_verified($id, 'Station')) return;
		$this->Master_model->any_exec(array($id, $this->session->userdata('username')), $this->sp_active, $this->tbl_station);
		$this->ion_auth->set_message('Station Set to Active');
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect("production/station", 'refresh');
	}

	public function product_activate($id)
	{
		if (!$this->is_any_verified($id, $this->tbl_product)) return;
		$this->Master_model->any_exec(array($id, $this->session->userdata('username')), $this->sp_active, $this->tbl_product);
		$this->ion_auth->set_message('Station Set to Active');
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect("production/product", 'refresh');
	}

	public function scheme_activate($id)
	{
		if (!$this->is_any_verified($id, $this->tbl_scheme)) return;
		$this->Master_model->any_exec(array($id, $this->session->userdata('username')), $this->sp_active, $this->tbl_scheme);
		$this->ion_auth->set_message('Scheme Set to Active');
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect("production/scheme", 'refresh');
	}

	public function shift_activate($id)
	{
		if (!$this->is_any_verified($id, $this->tbl_shift)) return;
		$this->Master_model->any_exec(array($id, $this->session->userdata('username')), $this->sp_active, $this->tbl_shift);
		$this->ion_auth->set_message('Shift Set to Active');
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect("production/shift", 'refresh');
	}


	public function station_inactive($id)
	{
		if (!$this->is_any_verified($id, $this->tbl_station)) return;
		$this->Master_model->any_exec(array($id, $this->session->userdata('username')), $this->sp_inactive, $this->tbl_station);
		$this->ion_auth->set_message('Shift Set to Inactive');
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect("production/station", 'refresh');
	}


	public function product_inactive($id)
	{
		if (!$this->is_any_verified($id, $this->tbl_product)) return;
		$this->Master_model->any_exec(array($id, $this->session->userdata('username')), $this->sp_inactive, $this->tbl_product);
		$this->ion_auth->set_message('Shift Set to Inactive');
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect("production/product", 'refresh');
	}

	public function scheme_inactive($id)
	{
		if (!$this->is_any_verified($id, $this->tbl_scheme)) return;
		$this->Master_model->any_exec(array($id, $this->session->userdata('username')), $this->sp_inactive, $this->tbl_scheme);
		$this->ion_auth->set_message('Shift Set to Inactive');
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect("production/scheme", 'refresh');
	}

	public function shift_inactive($id)
	{
		if (!$this->is_any_verified($id, $this->tbl_shift)) return;
		$this->Master_model->any_exec(array($id, $this->session->userdata('username')), $this->sp_inactive, $this->tbl_shift);
		$this->ion_auth->set_message('Shift Set to Inactive');
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect("production/shift", 'refresh');
	}


	public function station_create()
	{
		$this->form_validation->set_rules('frame_uid', 'Frame UID', 'required|min_length[17]|max_length[17]|trim');
		$this->form_validation->set_rules('engine_uid', 'Engine UID', 'required|min_length[17]|max_length[17]|trim');
		$this->form_validation->set_rules('name', ' Name', 'required|trim|max_length[20]|is_unique[prd_msstation.sta_name]');
		$this->form_validation->set_rules('type', 'Type', 'trim|max_length[20]');
		$this->form_validation->set_rules('desc', 'Description', 'trim|max_length[1600]');

		if ($this->form_validation->run() === TRUE) {
			$id = $this->uuid->v4();
			$frame_id = $this->input->post('frame_uid');
			$engine_uid = $this->input->post('engine_uid');
			$name = ucwords($this->input->post('name'));
			$type = ucwords($this->input->post('type'));
			$desc = $this->input->post('desc');
			$creaby = $this->session->userdata('username');
			$creadate = date('m/d/Y h:i:s a', time());
			$data = array($id, $engine_uid, $frame_id, $name, $type, $creaby, $creadate, 0, $desc);
		}
		if ($this->form_validation->run() === TRUE && $this->Master_model->any_exec($data, $this->sp_insert, $this->tbl_station)) {
			{
				$this->ion_auth->set_message('Station Inserted Succesfully');
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('master/station', 'refresh');
			}
		} else {
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['frame_uid'] = array(
				'name' => 'frame_uid',
				'id' => 'frame_uid',
				'class' => 'form-control',
				'required' => TRUE,
				'type' => 'text',
				'minLength' => 17,
				'maxLength' => 17,
				'value' => $this->form_validation->set_value('frame_uid'),
			);

			$this->data['engine_uid'] = array(
				'name' => 'engine_uid',
				'id' => 'engine_uid',
				'class' => 'form-control',
				'type' => 'text',
				'required' => TRUE,
				'minLength' => 17,
				'maxLength' => 17,
				'value' => $this->form_validation->set_value('engine_uid'),
			);
			$this->data['name'] = array(
				'name' => 'name',
				'id' => 'name',
				'class' => 'form-control',
				'type' => 'text',
				'required' => TRUE,
				'value' => $this->form_validation->set_value('name'),
			);
			$this->data['type'] = array(
				'name' => 'type',
				'id' => 'type',
				'class' => 'form-control',
				'type' => 'text',
				'value' => $this->form_validation->set_value('type'),
			);
			$this->data['desc'] = array(
				'name' => 'desc',
				'id' => 'desc',
				'class' => 'form-control',
				'rows' => 3,
				'value' => $this->form_validation->set_value('desc'),
			);

			$this->data['form_attribute'] = array(
				'id' => 'FormValidation',
				'class' => 'form-horizontal'
			);
			$this->global['gPageTitle'] = 'Admin | Manage Master - Station';
			$this->global['gContentTitle'] = 'Manage Master Data Station';
			$this->global['gCardTitle'] = 'Add Station';
			$this->loadViews("admin/station_add", $this->global, $this->data, NULL);

		}


	}

	public function product_create()
	{
		$this->form_validation->set_rules('name', ' Name', 'required|trim|max_length[20]|is_unique[prd_msproduct.pro_name]');
		$this->form_validation->set_rules('type', 'Type', 'trim|max_length[20]');

		if ($this->form_validation->run() === TRUE) {
			$id = $this->uuid->v4();
			$name = ucwords($this->input->post('name'));
			$type = ucwords($this->input->post('type'));
			$creaby = $this->session->userdata('username');
			$creadate = date('m/d/Y h:i:s a', time());
			$data = array($id, $name, $type, $creaby, $creadate, 0);
		}
		if ($this->form_validation->run() === TRUE && $this->Master_model->any_exec($data, $this->sp_insert, $this->tbl_product)) {
			{
				$this->ion_auth->set_message('product Inserted Succesfully');
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('master/product', 'refresh');
			}
		} else {
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['name'] = array(
				'name' => 'name',
				'id' => 'name',
				'class' => 'form-control',
				'type' => 'text',
				'required' => TRUE,
				'value' => $this->form_validation->set_value('name'),
			);
			$this->data['type'] = array(
				'name' => 'type',
				'id' => 'type',
				'class' => 'form-control',
				'type' => 'text',
				'required' => TRUE,
				'value' => $this->form_validation->set_value('type'),
			);

			$this->data['form_attribute'] = array(
				'id' => 'FormValidation',
				'class' => 'form-horizontal'
			);

			$this->global['gPageTitle'] = 'Admin | Manage Master - product';
			$this->global['gContentTitle'] = 'Manage Master Data product';
			$this->global['gCardTitle'] = 'Add product';
			$this->loadViews("admin/product_add", $this->global, $this->data, NULL);

		}


	}

	public function scheme_create()
	{
		$this->form_validation->set_rules('name', ' Name', 'required|trim|max_length[20]|is_unique[prd_msscheme.sce_name]');
		$this->form_validation->set_rules('output', 'Output', 'trim|max_length[25]');
		$this->form_validation->set_rules('station[]', 'Station', 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$id = $this->uuid->v4();
			$name = ucwords($this->input->post('name'));
			$output = ucwords($this->input->post('output'));
			$station = $this->input->post('station');
			$creaby = $this->session->userdata('username');
			$creadate = date('m/d/Y h:i:s a', time());
			$data = array($id, $name, $output, $creaby, $creadate, 0);
		}
		if ($this->form_validation->run() === TRUE && $this->Master_model->any_exec($data, $this->sp_insert, $this->tbl_scheme)) {
			{
				foreach ($station as $key => $value) {
					$this->Master_model->any_exec(array($this->uuid->v4(), $value, $id), $this->sp_insert, $this->tbl_scheme_detail);
				}
				$this->ion_auth->set_message('scheme Inserted Succesfully');
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('master/scheme', 'refresh');
			}
		} else {
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			foreach ($this->Master_model->any_select($this->sp_list, $this->tbl_station) as $row) {
				$this->data['option_station'][$row->sta_id] = $row->sta_name . ' - ' . $row->sta_type;
			}
			$this->data['station_extra'] =
				'class="selectpicker" 
				 data-style="select-with-transition"
				 title="Choose Station"
				 data-size="7"
				 id="station"
				 ';

			$this->data['name'] = array(
				'name' => 'name',
				'id' => 'name',
				'class' => 'form-control',
				'type' => 'text',
				'required' => TRUE,
				'value' => $this->form_validation->set_value('name'),
			);
			$this->data['output'] = array(
				'name' => 'output',
				'id' => 'output',
				'class' => 'form-control',
				'type' => 'text',
				'required' => TRUE,
				'value' => $this->form_validation->set_value('output'),
			);

			$this->data['form_attribute'] = array(
				'id' => 'FormValidation',
				'class' => 'form-horizontal'
			);

			$this->global['gPageTitle'] = 'Admin | Manage Master - scheme';
			$this->global['gContentTitle'] = 'Manage Master Data scheme';
			$this->global['gCardTitle'] = 'Add scheme';
			$this->loadViews("admin/scheme_add", $this->global, $this->data, NULL);

		}


	}

	public function shift_create()
	{
		$this->form_validation->set_rules('name', 'Name', 'required|trim|max_length[20]|is_unique[prd_msshift.sif_name]');
		$this->form_validation->set_rules('start', 'Start Time', 'trim|max_length[8]|callback_is_time_format');
		$this->form_validation->set_rules('end', 'End Time', 'trim|max_length[8]|callback_is_time_format');

		if ($this->form_validation->run() === TRUE) {
			$id = $this->uuid->v4();
			$name = ucwords($this->input->post('name'));
			$start = date("G:i", strtotime($this->input->post('start')));
			$end = date("G:i", strtotime($this->input->post('end')));
			$creaby = $this->session->userdata('username');
			$creadate = date('m/d/Y h:i:s a', time());
			$data = array($id, $name, $start, $end, $creaby, $creadate, 0);
		}
		if ($this->form_validation->run() === TRUE && $this->Master_model->any_exec($data, $this->sp_insert, $this->tbl_shift)) {
			{
				$this->ion_auth->set_message('shift Inserted Succesfully');
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('master/shift', 'refresh');
			}
		} else {
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['name'] = array(
				'name' => 'name',
				'id' => 'name',
				'class' => 'form-control ',
				'type' => 'text',
				'required' => TRUE,
				'value' => $this->form_validation->set_value('name'),
			);
			$this->data['start'] = array(
				'name' => 'start',
				'id' => 'start',
				'class' => 'form-control timepicker',
				'maxLength' => 8,
				'type' => 'text',
				'required' => TRUE,
				'value' => $this->form_validation->set_value('start'),
			);

			$this->data['end'] = array(
				'name' => 'end',
				'id' => 'end',
				'maxLength' => 8,
				'class' => 'form-control timepicker',
				'type' => 'text',
				'required' => TRUE,
				'value' => $this->form_validation->set_value('end'),
			);

			$this->data['form_attribute'] = array(
				'id' => 'FormValidation',
				'class' => 'form-horizontal'
			);

			$this->global['gPageTitle'] = 'Admin | Manage Master - shift';
			$this->global['gContentTitle'] = 'Manage Master Data shift';
			$this->global['gCardTitle'] = 'Add shift';
			$this->loadViews("admin/shift_add", $this->global, $this->data, NULL);

		}


	}


	public function station_edit($id, $is_editable = TRUE)
	{

		if (!$this->is_any_verified($id, 'Station')) return;
		$station = $this->Master_model->any_select($this->sp_detail, $this->tbl_station, array($id));


		// validate form input
		$this->form_validation->set_rules('frame_uid', 'Frame UID', 'required|min_length[17]|max_length[17]|trim');
		$this->form_validation->set_rules('engine_uid', 'Engine UID', 'required|min_length[17]|max_length[17]|trim');
		$this->form_validation->set_rules('name', ' Name', 'required|trim|max_length[20]');
		$this->form_validation->set_rules('type', 'Type', 'trim|max_length[20]');
		$this->form_validation->set_rules('desc', 'Description', 'trim|max_length[1600]');

		if (isset($_POST) && !empty($_POST)) {
			// do we have a valid request?
			if ($id != $this->input->post('id')) {
				show_error($this->lang->line('error_csrf'));
			}

			if ($this->form_validation->run() === TRUE) {

				$data = array(
					$id,
					$this->input->post('engine_uid'),
					$this->input->post('frame_uid'),
					$this->input->post('name'),
					$this->input->post('type'),
					$creaby = $this->session->userdata('username'),
					$this->input->post('desc')
				);
				// check to see if we are updating the user
				if ($this->Master_model->any_exec($data, $this->sp_update, $this->tbl_station)) {
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->ion_auth->set_message('Station Updated Succesfully');
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					redirect('production/station');
				} else {
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->ion_auth->set_message('Failed to Update');
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					redirect('production/station');
				}

			}
		}

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


		if ($is_editable) {
			$this->set_global('Admin | Manage Master - Station', 'Manage Master Data Station', 'Edit Station');
			$is_disabled = 'enabled';
		} else {
			$is_disabled = 'disabled';
			$this->set_global('Admin | Manage Master - Station', 'Manage Master Data Station', 'Detail Station');
			$this->data['creaby'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'type' => 'text',
				'value' => $this->form_validation->set_value('creaby', $station->sta_creaby)
			);
			$this->data['creadate'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'type' => 'text',
				'value' => $this->form_validation->set_value('creadate', time_elapsed_string($station->sta_creadate) . ' (' . print_beauty_date($station->sta_creadate) . ')')
			);
			$this->data['modiby'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'type' => 'text',
				'value' => $this->form_validation->set_value('modiby', $station->sta_modiby)
			);
			$this->data['modidate'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'type' => 'text',
				'value' => $this->form_validation->set_value('modidate', time_elapsed_string($station->sta_modidate) . ' (' . print_beauty_date($station->sta_modidate) . ')')
			);
			$this->data['status'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'type' => 'text',
				'value' => $this->form_validation->set_value('status', ($station->sta_is_deleted) ? 'Inactive' : 'Active')
			);
		}
		// pass the user to the view
		$this->data['station'] = $station;
		$this->data['engine_uid'] = array(
			'name' => 'engine_uid',
			'id' => 'engine_uid',
			'class' => 'form-control',
			$is_disabled => $is_disabled,
			'type' => 'text',
			'required' => TRUE,
			'minLength' => 17,
			'maxLength' => 17,
			'value' => $this->form_validation->set_value('engine_uid', $station->sta_engine_uid)
		);
		$this->data['frame_uid'] = array(
			'name' => 'frame_uid',
			'id' => 'frame_uid',
			'class' => 'form-control',
			$is_disabled => $is_disabled,
			'required' => TRUE,
			'type' => 'text',
			'minLength' => 17,
			'maxLength' => 17,
			'value' => $this->form_validation->set_value('frame_uid', $station->sta_frame_uid)
		);

		$this->data['name'] = array(
			'name' => 'name',
			'id' => 'name',
			$is_disabled => $is_disabled,
			'class' => 'form-control',
			'type' => 'text',
			'required' => TRUE,
			'value' => $this->form_validation->set_value('name', $station->sta_name)
		);
		$this->data['type'] = array(
			'name' => 'type',
			'id' => 'type',
			$is_disabled => $is_disabled,
			'class' => 'form-control',
			'type' => 'text',
			'value' => $this->form_validation->set_value('type', $station->sta_type)
		);
		$this->data['desc'] = array(
			'name' => 'desc',
			'id' => 'desc',
			$is_disabled => $is_disabled,
			'class' => 'form-control',
			'rows' => 3,
			'value' => $this->form_validation->set_value('desc', $station->sta_desc)
		);

		$this->data['form_attribute'] = array(
			'id' => 'FormValidation',
			'class' => 'form-horizontal'
		);

		if ($is_editable)
			$this->loadViews("admin/station_edit", $this->global, $this->data, NULL);
		else
			$this->loadViews("admin/station_detail", $this->global, $this->data, NULL);

	}

	public function product_edit($id, $is_editable = TRUE)
	{

		if (!$this->is_any_verified($id, $this->tbl_product)) return;
		$product = $this->Master_model->any_select($this->sp_detail, $this->tbl_product, array($id));


		// validate form input
		$this->form_validation->set_rules('name', ' Name', 'required|trim|max_length[36]');
		$this->form_validation->set_rules('type', 'Type', 'trim|max_length[36]');

		if (isset($_POST) && !empty($_POST)) {
			// do we have a valid request?
			if ($id != $this->input->post('id')) {
				show_error($this->lang->line('error_csrf'));
			}

			if ($this->form_validation->run() === TRUE) {

				$data = array(
					$id,
					$this->input->post('name'),
					$this->input->post('type'),
					$creaby = $this->session->userdata('username'),
				);
				// check to see if we are updating the user
				if ($this->Master_model->any_exec($data, $this->sp_update, $this->tbl_product)) {
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->ion_auth->set_message('product Updated Succesfully');
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					redirect('production/product');
				} else {
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->ion_auth->set_message('Failed to Update');
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					redirect('production/product');
				}

			}
		}

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


		if ($is_editable) {
			$this->set_global('Admin | Manage Master - Product', 'Manage Master Data Product', 'Edit Product');
			$is_disabled = 'enabled';
		} else {
			$is_disabled = 'disabled';
			$this->set_global('Admin | Manage Master - Product', 'Manage Master Data Product', 'Detail Product');
			$this->data['creaby'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'type' => 'text',
				'value' => $this->form_validation->set_value('creaby', $product->pro_creaby)
			);
			$this->data['creadate'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'type' => 'text',
				'value' => $this->form_validation->set_value('creadate', time_elapsed_string($product->pro_creadate) . ' (' . print_beauty_date($product->pro_creadate) . ')')
			);
			$this->data['modiby'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'type' => 'text',
				'value' => $this->form_validation->set_value('modiby', $product->pro_modiby)
			);
			$this->data['modidate'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'type' => 'text',
				'value' => $this->form_validation->set_value('modidate', time_elapsed_string($product->pro_modidate) . ' (' . print_beauty_date($product->pro_modidate) . ')')
			);
			$this->data['status'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'type' => 'text',
				'value' => $this->form_validation->set_value('status', ($product->pro_is_deleted) ? 'Inactive' : 'Active')
			);
		}

		// pass the user to the view
		$this->data['product'] = $product;
		$this->data['name'] = array(
			'name' => 'name',
			'id' => 'name',
			$is_disabled => $is_disabled,
			'class' => 'form-control',
			'type' => 'text',
			'required' => TRUE,
			'value' => $this->form_validation->set_value('name', $product->pro_name)
		);
		$this->data['type'] = array(
			'name' => 'type',
			'id' => 'type',
			$is_disabled => $is_disabled,
			'class' => 'form-control',
			'type' => 'text',
			'value' => $this->form_validation->set_value('type', $product->pro_type)
		);

		$this->data['form_attribute'] = array(
			'id' => 'FormValidation',
			'class' => 'form-horizontal'
		);

		if ($is_editable)
			$this->loadViews("admin/product_edit", $this->global, $this->data, NULL);
		else
			$this->loadViews("admin/product_detail", $this->global, $this->data, NULL);

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
			$this->set_global('Admin | Manage Master - scheme', 'Manage Master Data scheme', 'Edit scheme');
			$is_disabled = 'enabled';
		} else {
			$is_disabled = 'disabled';
			$this->set_global('Admin | Manage Master - scheme', 'Manage Master Data scheme', 'Detail scheme');
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

		foreach ($this->Master_model->any_select($this->sp_list, $this->tbl_station) as $row) {
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

	public function shift_edit($id, $is_editable = TRUE)
	{

		if (!$this->is_any_verified($id, $this->tbl_shift)) return;
		$shift = $this->Master_model->any_select($this->sp_detail, $this->tbl_shift, array($id));

		// validate form input
		$this->form_validation->set_rules('name', ' Name', 'required|trim|max_length[20]');
		$this->form_validation->set_rules('start', 'Start Time', 'trim|max_length[8]|callback_is_time_format');
		$this->form_validation->set_rules('end', 'End Time', 'trim|max_length[8]|callback_is_time_format');
		if (isset($_POST) && !empty($_POST)) {
			// do we have a valid request?
			if ($id != $this->input->post('id')) {
				show_error($this->lang->line('error_csrf'));
			}

			if ($this->form_validation->run() === TRUE) {

				$data = array(
					$id,
					$this->input->post('name'),
					date("G:i", strtotime($this->input->post('start'))),
					date("G:i", strtotime($this->input->post('end'))),
					$creaby = $this->session->userdata('username'),
				);
				// check to see if we are updating the user
				if ($this->Master_model->any_exec($data, $this->sp_update, $this->tbl_shift)) {
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->ion_auth->set_message('shift Updated Succesfully');
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					redirect('production/shift');
				} else {
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->ion_auth->set_message('Failed to Update');
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					redirect('production/shift');
				}

			}
		}

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


		if ($is_editable) {
			$this->set_global('Admin | Manage Master - Shift', 'Manage Master Data Shift', 'Edit Shift');
			$is_disabled = 'enabled';
		} else {
			$is_disabled = 'disabled';
			$this->set_global('Admin | Manage Master - Shift', 'Manage Master Data Shift', 'Detail Shift');
			$this->data['creaby'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'output' => 'text',
				'value' => $this->form_validation->set_value('creaby', $shift->sif_creaby)
			);
			$this->data['creadate'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'output' => 'text',
				'value' => $this->form_validation->set_value('creadate', time_elapsed_string($shift->sif_creadate) . ' (' . print_beauty_date($shift->sif_creadate) . ')')
			);
			$this->data['modiby'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'output' => 'text',
				'value' => $this->form_validation->set_value('modiby', $shift->sif_modiby)
			);
			$this->data['modidate'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'output' => 'text',
				'value' => $this->form_validation->set_value('modidate', time_elapsed_string($shift->sif_modidate) . ' (' . print_beauty_date($shift->sif_modidate) . ')')
			);
			$this->data['status'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'output' => 'text',
				'value' => $this->form_validation->set_value('status', ($shift->sif_is_deleted) ? 'Inactive' : 'Active')
			);
		}

		// pass the user to the view
		$this->data['shift'] = $shift;
		$this->data['name'] = array(
			'name' => 'name',
			'id' => 'name',
			$is_disabled => $is_disabled,
			'class' => 'form-control',
			'output' => 'text',
			'required' => TRUE,
			'value' => $this->form_validation->set_value('name', $shift->sif_name)
		);
		$this->data['start'] = array(
			'name' => 'start',
			'id' => 'start',
			'class' => 'form-control timepicker',
			$is_disabled => $is_disabled,
			'maxLength' => 8,
			'type' => 'text',
			'required' => TRUE,
			'value' => $this->form_validation->set_value('start', $shift->sif_start_date)
		);
		$this->data['end'] = array(
			'name' => 'end',
			'id' => 'end',
			'class' => 'form-control timepicker',
			$is_disabled => $is_disabled,
			'maxLength' => 8,
			'type' => 'text',
			'required' => TRUE,
			'value' => $this->form_validation->set_value('start', $shift->sif_end_date)
		);


		$this->data['form_attribute'] = array(
			'id' => 'FormValidation',
			'class' => 'form-horizontal'
		);

		if ($is_editable)
			$this->loadViews("admin/shift_edit", $this->global, $this->data, NULL);
		else
			$this->loadViews("admin/shift_detail", $this->global, $this->data, NULL);

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
}

/* End of file Master.php */
