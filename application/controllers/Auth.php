<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation $form_validation The form validation library
 */
class Auth extends BaseController
{
	public $data = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');
		$this->load->model('Master_model');
		$this->load->library('recaptcha');
//		if (!$this->ion_auth->logged_in() && $this->uri->segment(2) !== 'forgot_password')
//			$this->login();
	}


	/*
	 * Redirect to dahsboard
	 */
	public function dashboard()
	{
		if (!$this->ion_auth->logged_in()) redirect('production/login', 'refresh');
		$this->global['gContentTitle'] = 'Dashboard';
		if ($this->ion_auth->is_admin()) {
			$this->global['gPageTitle'] = 'Admin | Dashboard';
			$this->loadViews("admin/dashboard", $this->global, $this->data, NULL);

		} elseif ($this->ion_auth->is_operator()) {
			$this->global['gPageTitle'] = 'Operator | Dashboard';

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
//			$this->set_global('PPIC | Dashboard', 'Dashboard', 'Currently Working Schedule');

			$this->loadViews("operator/dashboard", $this->global, $this->data, NULL);


		} elseif ($this->ion_auth->is_ppic()) {

			$sch = $this->Master_model->any_select($this->sp_detail, $this->tbl_schedule . $this->desc_today . 'Dashboard', FALSE, FALSE, TRUE);
			$id = NULL;
			if ($sch)
				$id = $sch->sch_id;
//			else if ($this->session->has_userdata('dashboard_schedule'))
//				$id = $this->session->userdata('dashboard_schedule');

			$this->data['productions'] = $this->Master_model->any_select($this->sp_list, $this->tbl_production, array($id), TRUE);
			$this->data['schedule'] = $this->Master_model->any_select($this->sp_detail, $this->tbl_schedule, array($id));
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['form_attribute'] = array(
				'id' => 'FormValidation',
				'class' => 'form-horizontal'
			);
			$this->set_global('PPIC | Dashboard', 'Dashboard', 'Currently Working Schedule');

			$this->loadViews("ppic/dashboard", $this->global, $this->data, NULL);
		}
	}

	/**
	 * Redirect if needed, otherwise display the user list
	 *
	 */
	public function index()
	{
		if (!$this->ion_auth->logged_in())
			$this->login();
		else
			$this->dashboard();

	}

	/*
	 * redirect to crud user
	 */
	public function user()
	{
		if (!$this->ion_auth->logged_in()) redirect('production/login', 'refresh');

		if ($this->ion_auth->is_admin()) {
			//global var
			$this->global['gPageTitle'] = 'Admin | Dashboard';
			$this->global['gContentTitle'] = 'Manage Master Data User';
			$this->global['gCardTitle'] = 'User List';
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			//list the users
			$this->data['users'] = $this->ion_auth->users()->result();

			//USAGE NOTE - you can do more complicated queries like this
			//$this->data['users'] = $this->ion_auth->where('field', 'value')->users()->result();

			foreach ($this->data['users'] as $k => $user) {
				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}

			$this->global['gPageTitle'] = 'Admin | User';
			$this->loadViews("admin/user_list", $this->global, $this->data, NULL);

		} else {
			show_error('You must be an administrator to view this page.');

		}
	}

	public function verify_captcha()
	{
		$recaptcha = $this->input->post('g-recaptcha-response');
		if ($recaptcha) {
			$response = $this->recaptcha->verifyResponse($recaptcha);
			if (isset($response['success']) and $response['success'] === true) {
				return TRUE;
			} else {
				$this->form_validation->set_message('verify_captcha', '%s ' . $response['error-codes']);
				return FALSE;
			}
		} else {
			$this->form_validation->set_message('verify_captcha', 'You need to complete the %s');
			return FALSE;
		}

	}

	public function response_chaptcha($str)
	{
		$response = $this->recaptcha->verifyResponse($str);
		if ($response['success']) {
			return true;
		} else {
			$this->form_validation->set_message('response_chaptcha', '%s is required.');
			return false;
		}
	}

	/**
	 * Log the user in
	 */
	public function login()
	{
		$this->data['title'] = $this->lang->line('login_heading');

		$this->data['recaptcha_html'] = $this->recaptcha->render();
		$this->form_validation->set_rules('g-recaptcha-response', '<strong>Captcha</strong>', 'callback_response_chaptcha');
		// validate form input
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required|min_length[6]|max_length[20]|xss_clean|trim');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required|min_length[6]|max_length[32]');


		if ($this->form_validation->run() === TRUE) {
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool)$this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('production', 'refresh');
			} else {
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('production/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		} else {
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
//			$msg = trim(str_replace(array('<p>', '</p>'), '', $this->session->flashdata('message')));
//			if ($msg) {
//				$this->data['message'] = (validation_errors(printNotif('danger'), printNotif())) ? validation_errors(printNotif('danger'), printNotif()) : printNotif('danger') . $msg . printNotif();
//			} else {
//				$this->data['message'] = (validation_errors(printNotif('danger'), printNotif())) ? validation_errors(printNotif('danger'), printNotif()) : $msg;
//			}

			$this->data['identity'] = array(
				'name' => 'identity',
				'class' => 'form-control',
				'placeholder' => 'Username',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);

			$this->data['password'] = array(
				'name' => 'password',
				'class' => 'form-control',
				'placeholder' => 'Password',
				'id' => 'password',
				'type' => 'password',
			);


			$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'login', $this->data);
		}
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{
		$this->data['title'] = "Logout";

		// log the user out
		$this->ion_auth->logout();

		// redirect them to the login page
		redirect('production/login', 'refresh');
	}

	/**
	 * Change password
	 */
	public function change_password()
	{
		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required|callback_no_space');
		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|callback_no_space|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required|callback_no_space');

		if (!$this->ion_auth->logged_in()) {
			redirect('production/login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() === FALSE) {
			// display the form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data['old_password'] = array(
				'name' => 'old',
				'id' => 'old',
				'class' => 'form-control',
				'placeholder' => 'Old Password',
				'type' => 'password',
				'required' => 'required',
			);
			$this->data['new_password'] = array(
				'name' => 'new',
				'id' => 'new',
				'class' => 'form-control',
				'placeholder' => 'New Password',
				'minLength' => 8,
				'type' => 'password',
				'required' => 'required',
			);
			$this->data['new_password_confirm'] = array(
				'name' => 'new_confirm',
				'id' => 'new_confirm',
				'class' => 'form-control',
				'placeholder' => 'Confirm New Password',
				'minLength' => 8,
				'type' => 'password',
				'required' => 'required',
			);
			$this->data['user_id'] = array(
				'name' => 'user_id',
				'id' => 'user_id',
				'type' => 'hidden',
				'value' => $user->id,
			);
			$this->data['form_attribute'] = array(
				'id' => 'FormValidation',
				'class' => 'form-horizontal'
			);
			// render
//			$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'change_password', $this->data);
			$this->set_global('Admin | Change Password', 'Change Password', 'Change Password');
			$this->loadViews('auth/change_password', $this->global, $this->data, '');
		} else {
			$identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change) {
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			} else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/change_password', 'refresh');
			}
		}
	}

	/**
	 * Forgot password
	 */
	public function forgot_password()
	{
		$this->data['title'] = $this->lang->line('forgot_password_heading');

		// setting validation rules by checking whether identity is username or email
		if ($this->config->item('identity', 'ion_auth') != 'email') {
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
		} else {
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}
		$this->data['recaptcha_html'] = $this->recaptcha->render();
		$this->form_validation->set_rules('g-recaptcha-response', '<strong>Captcha</strong>', 'callback_response_chaptcha');


		if ($this->form_validation->run() === FALSE) {
			$this->data['type'] = $this->config->item('identity', 'ion_auth');
			// setup the input
			$this->data['identity'] = array(
				'name' => 'identity',
				'id' => 'identity',
				'class' => 'form-control',
				'placeholder' => 'Username',

			);

			if ($this->config->item('identity', 'ion_auth') != 'email') {
				$this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
			} else {
				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			// set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'forgot_password', $this->data);
		} else {
			$identity_column = $this->config->item('identity', 'ion_auth');
			$identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

			if (empty($identity)) {

				if ($this->config->item('identity', 'ion_auth') != 'email') {
					$this->ion_auth->set_error('forgot_password_identity_not_found');
				} else {
					$this->ion_auth->set_error('forgot_password_email_not_found');
				}

				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("production/forgot_password", 'refresh');
			}

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten) {
				// if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("production/login", 'refresh'); //we should display a confirmation page here instead of the login page
			} else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("production/forgot_password", 'refresh');
			}
		}
	}

	/**
	 * Reset password - final step for forgotten password
	 *
	 * @param string|null $code The reset code
	 */
	public function reset_password($code = NULL)
	{
		if (!$code) {
			show_404();
		}

		$this->data['title'] = $this->lang->line('reset_password_heading');

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user) {
			// if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() === FALSE) {
				// display the form

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = array(
					'name' => 'new',
					'id' => 'new',
					'class' => 'form-control',
					'placeholder' => 'New Password',
					'minLength' => 8,
					'type' => 'password',
				);
				$this->data['new_password_confirm'] = array(
					'name' => 'new_confirm',
					'class' => 'form-control',
					'placeholder' => 'Confirm New Password',
					'id' => 'new_confirm',
					'type' => 'password',
					'minLength' => 8,
				);
				$this->data['user_id'] = array(
					'name' => 'user_id',
					'id' => 'user_id',
					'type' => 'hidden',
					'value' => $user->id,
				);
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				// render
				$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'reset_password', $this->data);
			} else {
				$identity = $user->{$this->config->item('identity', 'ion_auth')};

				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {

					// something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($identity);

					show_error($this->lang->line('error_csrf'));

				} else {
					// finally change the password
					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change) {
						// if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						redirect("production/login", 'refresh');
					} else {
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		} else {
			// if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("production/forgot_password", 'refresh');
		}
	}

	/**
	 * Activate the user
	 *
	 * @param int $id The user ID
	 * @param string|bool $code The activation code
	 */
	public function activate_v1($id, $code = FALSE)
	{
		$activation = FALSE;

		if ($code !== FALSE) {
			$activation = $this->ion_auth->activate($id, $code);
		} else if ($this->ion_auth->is_admin()) {
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation) {
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		} else {
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("production/forgot_password", 'refresh');
		}
	}

	public function activate($id, $code = FALSE)
	{
		$activation = FALSE;

		if ($code !== FALSE) {
			$activation = $this->ion_auth->activate($id, $code);
		} else if ($this->ion_auth->is_admin()) {
			if (!$this->is_any_verified($id, $this->tbl_user)) return;
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation && $code) {
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("production/login", 'refresh');
		} else if ($activation && !$code) {
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("production/user", 'refresh');
		} else {
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("production/forgot_password", 'refresh');
		}
	}

	/**
	 * Deactivate the user
	 *
	 * @param int|string|null $id The user ID
	 */
	public function deactivate_v1($id = NULL)
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
			// redirect them to the home page because they must be an administrator to view this
			show_error('You must be an administrator to view this page.');
		}

		$id = (int)$id;

//		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() === FALSE) {
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();

			$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'deactivate_user', $this->data);
		} else {
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes') {
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
					show_error($this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
					$this->ion_auth->deactivate($id);
				}
			}

			// redirect them back to the auth page
			redirect('auth', 'refresh');
		}
	}

	public function deactivate($id = NULL)
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
			// redirect them to the home page because they must be an administrator to view this
			show_error('You must be an administrator to view this page.');
		}
		if (!$this->is_any_verified($id, $this->tbl_user)) return;
		$id = (int)$id;
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$this->ion_auth->deactivate($id);
			$this->session->set_flashdata('message', $this->ion_auth->messages());

		}
		redirect('production/user', 'refresh');
	}


	public function alpha_dash_space($str)
	{
		if (!preg_match("/^([-a-z_ ])+$/i", $str)) {
			$this->form_validation->set_message('alpha_dash_space', '%s field may only contain alpha characters & White spaces');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function no_space($str)
	{
		if (preg_match('/\s/', $str)) {
			$this->form_validation->set_message('no_space', '%s field can not contain whitespace');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function phone_number_idn($str)
	{
		if (!preg_match('/^(\()?(\+62|62|08)(\d{2,3})?\)?[ .-]?\d{2,4}[ .-]?\d{2,4}[ .-]?\d{2,4}/', $str)) {
			$this->form_validation->set_message('phone_number_idn', '%s field wrong format number');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	/**
	 * Create a new user
	 */
	public function create_user()
	{
		$this->data['title'] = $this->lang->line('create_user_heading');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
			redirect('auth', 'refresh');
		}

		foreach ($this->ion_auth->groups()->result() as $row) {
			$this->data['option_group'][$row->id] = strtoupper($row->name) . ' - ' . $row->description;
		}
		$tables = $this->config->item('tables', 'ion_auth');
		$identity_column = $this->config->item('identity', 'ion_auth');
		$this->data['identity_column'] = $identity_column;

		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'trim|required|callback_alpha_dash_space');
		$this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'trim|callback_alpha_dash_space');
		if ($identity_column !== 'email') {
			$this->form_validation->set_rules('identity', 'Username', 'trim|required|alpha_dash|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');
		} else {
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');
		}
		$this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim|is_natural|callback_phone_number_idn');
		$this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim|alpha_numeric_spaces');
		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|callback_no_space|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');
		$this->form_validation->set_rules('group', 'Role', 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$email = strtolower($this->input->post('email'));
			$identity = ($identity_column === 'email') ? $email : strtolower($this->input->post('identity'));
			$password = $this->input->post('password');
			$group = $this->input->post('group');

			$additional_data = array(
				'first_name' => ucwords($this->input->post('first_name')),
				'last_name' => ucwords($this->input->post('last_name')),
				'company' => strtoupper($this->input->post('company')),
				'phone' => $this->input->post('phone'),
				'creaby' => $this->session->userdata('username'),
			);
		}
		if ($this->form_validation->run() === TRUE && $this->ion_auth->register($identity, $password, $email, $additional_data, array($group))) {
			// check to see if we are creating the user
			// redirect them back to the admin page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("production/user", 'refresh');
		} else {
			// display the create user form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['first_name'] = array(
				'name' => 'first_name',
				'id' => 'first_name',
				'required' => 'required',
				'type' => 'text',
				'autocomplete' => 'off',
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('first_name'),
			);
			$this->data['last_name'] = array(
				'name' => 'last_name',
				'id' => 'last_name',
				'autocomplete' => 'off',
				'class' => 'form-control',
				'type' => 'text',
				'value' => $this->form_validation->set_value('last_name'),
			);
			$this->data['identity'] = array(
				'name' => 'identity',
				'id' => 'identity',
				'required' => 'required',
				'autocomplete' => 'off',
				'class' => 'form-control',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['email'] = array(
				'name' => 'email',
				'id' => 'email',
				'class' => 'form-control',
				'autocomplete' => 'off',
				'required' => 'required',
				'type' => 'email',
				'value' => $this->form_validation->set_value('email'),
			);
			$this->data['company'] = array(
				'name' => 'company',
				'id' => 'company',
				'class' => 'form-control',
				'autocomplete' => 'off',
				'type' => 'text',
				'value' => $this->form_validation->set_value('company'),
			);
			$this->data['phone'] = array(
				'name' => 'phone',
				'id' => 'phone',
				'class' => 'form-control',
				'autocomplete' => 'off',
				'required' => 'required',
				'type' => 'number',
				'maxLength' => 16,
				'value' => $this->form_validation->set_value('phone'),
			);
			$this->data['password'] = array(
				'name' => 'password',
				'id' => 'password',
				'class' => 'form-control',
				'required' => 'required',
				'type' => 'password',
				'minLength' => 8,
				'autocomplete' => 'off',
				'value' => $this->form_validation->set_value('password'),
			);
			$this->data['password_confirm'] = array(
				'name' => 'password_confirm',
				'id' => 'password_confirm',
				'required' => 'required',
				'minLength' => 8,
				'class' => 'form-control',
				'type' => 'password',
				'value' => $this->form_validation->set_value('password_confirm'),
			);

			$this->data['group_extra'] =
				'class="selectpicker" 
				 data-style="select-with-transition"
				 title="Choose Role"
				 data-size="7"
				 id="group"
				 ';

			$this->data['form_attribute'] = array(
				'id' => 'FormValidation',
				'class' => 'form-horizontal'
			);
			$this->set_global('Admin | Manage Master - User', 'Manage Master Data User', 'Add User');

			$this->loadViews("admin/user_add", $this->global, $this->data, NULL);
		}
	}

	/**
	 * Redirect a user checking if is admin
	 */
	public function redirectUser()
	{
		if ($this->ion_auth->is_admin()) {
			redirect('auth', 'refresh');
		}
		redirect('/', 'refresh');
	}

	/**
	 * Edit a user
	 *
	 * @param int|string $id
	 */
	public function edit_user($id, $is_editable = TRUE)
	{
		$this->data['title'] = $this->lang->line('edit_user_heading');
		if (!$this->is_any_verified($id, $this->tbl_user)) return;


		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))) {
			redirect('auth', 'refresh');
		}

		foreach ($this->ion_auth->groups()->result() as $row) {
			$this->data['option_group'][$row->id] = strtoupper($row->name) . ' - ' . $row->description;
		}
		foreach ($this->ion_auth->get_users_groups($id)->result() as $row) {
			$this->data['group_selected'][$row->id] = $row->id;
		}
		$user = $this->ion_auth->user($id)->row();
		$identity_column = $this->config->item('identity', 'ion_auth');
		$this->data['identity_column'] = $identity_column;


		//USAGE NOTE - you can do more complicated queries like this
		//$groups = $this->ion_auth->where(['field' => 'value'])->groups()->result_array();


		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'trim|required|callback_alpha_dash_space');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'trim|callback_alpha_dash_space');
		$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'trim|is_natural|callback_phone_number_idn');
		$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'trim|alpha_numeric_spaces');
		$this->form_validation->set_rules('group', 'Role', 'trim|required');


		if (isset($_POST) && !empty($_POST)) {
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
				show_error($this->lang->line('error_csrf'));
			}

			// update the password if it was posted
			if ($this->input->post('password')) {
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|callback_no_space|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');

			}

			if ($this->form_validation->run() === TRUE) {
				$data = array(
					'first_name' => ucwords($this->input->post('first_name')),
					'last_name' => ucwords($this->input->post('last_name')),
					'company' => strtoupper($this->input->post('company')),
					'phone' => $this->input->post('phone'),
					'modiby' => $this->session->userdata('username'),
					'modified_on' => time(),
				);

				// update the password if it was posted
				if ($this->input->post('password')) {
					$data['password'] = $this->input->post('password');
				}

				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin()) {
					// Update the groups user belongs to
					$this->ion_auth->remove_from_group('', $id);

					$groupData = $this->input->post('group');
					$this->ion_auth->add_to_group($groupData, $id);
				}

				// check to see if we are updating the user
				if ($this->ion_auth->update($user->id, $data)) {
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					redirect("production/user", 'refresh');
				} else {
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					redirect("production/user", 'refresh');
				}

			}
		}

		if ($is_editable) {
			$this->set_global('Admin | Manage Master - User', 'Manage Master Data User', 'Edit User');
			$is_disabled = 'enabled';
			$this->data['password'] = array(
				'name' => 'password',
				'id' => 'password',
				'class' => 'form-control',
				'type' => 'password',
				'minLength' => 8,
				'autocomplete' => 'off',
			);
			$this->data['password_confirm'] = array(
				'name' => 'password_confirm',
				'id' => 'password_confirm',
				'minLength' => 8,
				'class' => 'form-control',
				'type' => 'password',
			);

		} else {
			$is_disabled = 'disabled';
			$this->set_global('Admin | Manage Master - User', 'Manage Master Data User', 'Detail User');
			$this->data['creaby'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'type' => 'text',
				'value' => $this->form_validation->set_value('creaby', $user->creaby)
			);
			$this->data['creadate'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'type' => 'text',
				'value' => $this->form_validation->set_value('creadate', time_elapsed_string(date("Y-m-d H:i:s", $user->created_on)) . ' (' . print_beauty_date(date("Y-m-d H:i:s", $user->created_on)) . ')')
			);
			$this->data['modiby'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'type' => 'text',
				'value' => $this->form_validation->set_value('modiby', $user->modiby)
			);
			$this->data['modidate'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'type' => 'text',
				'value' => $this->form_validation->set_value('modidate', time_elapsed_string(date("Y-m-d H:i:s", $user->modified_on)) . ' (' . print_beauty_date(date("Y-m-d H:i:s", $user->modified_on)) . ')')
			);
			$this->data['status'] = array(
				'class' => 'form-control',
				'disabled' => 'disabled',
				'type' => 'text',
				'value' => $this->form_validation->set_value('status', ($user->active) ? 'Active' : 'Inactive')
			);
		}

		// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['user'] = $user;
//		$this->data['groups'] = $groups;
//		$this->data['currentGroups'] = $currentGroups;
		$this->data['first_name'] = array(
			'name' => 'first_name',
			'id' => 'first_name',
			$is_disabled => $is_disabled,
			'required' => 'required',
			'type' => 'text',
			'autocomplete' => 'off',
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
		);
		$this->data['last_name'] = array(
			'name' => 'last_name',
			$is_disabled => $is_disabled,
			'id' => 'last_name',
			'autocomplete' => 'off',
			'class' => 'form-control',
			'type' => 'text',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
		);
		$this->data['company'] = array(
			'name' => 'company',
			'id' => 'company',
			$is_disabled => $is_disabled,
			'class' => 'form-control',
			'autocomplete' => 'off',
			'type' => 'text',
			'value' => $this->form_validation->set_value('company', $user->company),
		);
		$this->data['phone'] = array(
			'name' => 'phone',
			'id' => 'phone',
			$is_disabled => $is_disabled,
			'class' => 'form-control',
			'autocomplete' => 'off',
			'required' => 'required',
			'type' => 'number',
			'maxLength' => 16,
			'value' => $this->form_validation->set_value('phone', $user->phone),
		);

		$this->data['identity'] = array(
			'name' => 'identity',
			'id' => 'identity',
			'autocomplete' => 'off',
			'class' => 'form-control',
			'type' => 'text',
			'disabled' => 'disabled',
			'value' => $this->form_validation->set_value('identity', $user->username),
		);

		$this->data['email'] = array(
			'name' => 'email',
			'id' => 'email',
			'class' => 'form-control',
			'disabled' => 'disabled',
			'autocomplete' => 'off',
			'type' => 'email',
			'value' => $this->form_validation->set_value('email', $user->email),
		);
		$this->data['group_extra'] =
			'class="selectpicker" 
				 data-style="select-with-transition"
				 title="Choose Role"
				 data-size="7"
				 id="group"
				  ' . $is_disabled;
		$this->data['form_attribute'] = array(
			'id' => 'FormValidation',
			'class' => 'form-horizontal'
		);
		if ($is_editable)
			$this->loadViews("admin/user_edit", $this->global, $this->data, NULL);
		else
			$this->loadViews("admin/user_detail", $this->global, $this->data, NULL);

	}

	/**
	 * Create a new group
	 */
	public function create_group()
	{
		$this->data['title'] = $this->lang->line('create_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
			redirect('auth', 'refresh');
		}

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'trim|required|alpha_dash');

		if ($this->form_validation->run() === TRUE) {
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if ($new_group_id) {
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth", 'refresh');
			} else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
			}
		}

		// display the create group form
		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		$this->data['group_name'] = array(
			'name' => 'group_name',
			'id' => 'group_name',
			'type' => 'text',
			'value' => $this->form_validation->set_value('group_name'),
		);
		$this->data['description'] = array(
			'name' => 'description',
			'id' => 'description',
			'type' => 'text',
			'value' => $this->form_validation->set_value('description'),
		);

		$this->_render_page('auth/create_group', $this->data);

	}

	/**
	 * Edit a group
	 *
	 * @param int|string $id
	 */
	public function edit_group($id)
	{
		// bail if no group id given
		if (!$id || empty($id)) {
			redirect('auth', 'refresh');
		}

		$this->data['title'] = $this->lang->line('edit_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
			redirect('auth', 'refresh');
		}

		$group = $this->ion_auth->group($id)->row();

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'trim|required|alpha_dash');

		if (isset($_POST) && !empty($_POST)) {
			if ($this->form_validation->run() === TRUE) {
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], array(
					'description' => $_POST['group_description']
				));

				if ($group_update) {
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
					redirect("auth", 'refresh');
				} else {
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
			}
		}

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['group'] = $group;

		$this->data['group_name'] = array(
			'name' => 'group_name',
			'id' => 'group_name',
			'type' => 'text',
			'value' => $this->form_validation->set_value('group_name', $group->name),
		);
		if ($this->config->item('admin_group', 'ion_auth') === $group->name) {
			$this->data['group_name']['readonly'] = 'readonly';
		}

		$this->data['group_description'] = array(
			'name' => 'group_description',
			'id' => 'group_description',
			'type' => 'text',
			'value' => $this->form_validation->set_value('group_description', $group->description),
		);

		$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'edit_group', $this->data);
	}

	/**
	 * @return array A CSRF key-value pair
	 */
	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	/**
	 * @return bool Whether the posted CSRF token matches
	 */
	public function _valid_csrf_nonce()
	{
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
		if ($csrfkey && $csrfkey === $this->session->flashdata('csrfvalue')) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * @param string $view
	 * @param array|null $data
	 * @param bool $returnhtml
	 *
	 * @return mixed
	 */
	public function _render_page($view, $data = NULL, $returnhtml = FALSE)//I think this makes more sense
	{

		$viewdata = (empty($data)) ? $this->data : $data;

		$view_html = $this->load->view($view, $viewdata, $returnhtml);

		// This will return html on 3rd argument being true
		if ($returnhtml) {
			return $view_html;
		}
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

	public function show404()
	{
		$this->set_global('Error', 'Error');
		$this->loadViews("errors/custom/404", $this->global, NULL, NULL);

	}

}
