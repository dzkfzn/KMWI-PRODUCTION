<?php defined('BASEPATH') or exit ('No direct script access allowed');

/**
 * Class : BaseController
 * Base Class to control over all the classes
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class BaseController extends CI_Controller
{
	protected $role = '';
	protected $vendorId = '';
	protected $name = '';
	protected $roleText = '';
	protected $global = array();

	protected $sp_insert = 'create';
	protected $sp_update = 'edit';
	protected $sp_delete = 'delete';
	protected $sp_active = 'setActive';
	protected $sp_inactive = 'setInactive';
	protected $sp_list = 'getList';
	protected $sp_list_active = 'getListActive';
	protected $sp_detail = 'getDetail';
	protected $sp_check = 'check';

	protected $tbl_product = 'Product';
	protected $tbl_report = 'Report';
	protected $tbl_station = 'Station';
	protected $tbl_scheme = 'Scheme';
	protected $tbl_shift = 'Shift';
	protected $tbl_user = 'User';
	protected $tbl_schedule = 'Schedule';
	protected $tbl_scheme_detail = 'SchemeDetail';
	protected $tbl_production = 'Production';

	protected $desc_today = 'Today';
	protected $desc_history = 'History';
	protected $desc_reject = 'Reject';
	protected $desc_pva = 'PlanVsActual';
	protected $desc_achievement = 'ProductAchievement';
	/**
	 * Takes mixed data and optionally a status code, then creates the response
	 *
	 * @access public
	 * @param array|NULL $data
	 *            Data to output to the user
	 *            running the script; otherwise, exit
	 */
	public function response($data = NULL)
	{
		$this->output->set_status_header(200)->set_content_type('application/json', 'utf-8')->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))->_display();
		exit ();
	}

	/**
	 * This function used to check the user is logged in or not
	 */
	function isLoggedIn()
	{
		$isLoggedIn = $this->session->userdata('isLoggedIn');

		if (!isset ($isLoggedIn) || $isLoggedIn != TRUE) {
			redirect('login');
		} else {


//			$session_data = array(
//				'identity' => $user->{$this->identity_column},
//				$this->identity_column => $user->{$this->identity_column},
//				'email' => $user->email,
//				'user_id' => $user->id, //everyone likes to overwrite id so we'll use user_id
//				'old_last_login' => $user->last_login,
//				'last_check' => time(),
//			);


			$this->role = $this->session->userdata('role');
			$this->vendorId = $this->session->userdata('userId');
			$this->name = $this->session->userdata('name');
			$this->roleText = $this->session->userdata('roleText');

			$this->global ['name'] = $this->name;
			$this->global ['role'] = $this->role;
			$this->global ['role_text'] = $this->roleText;
		}
	}

	/**
	 * This function is used to check the access
	 */
	function isAdmin()
	{
		if ($this->role != ROLE_ADMIN) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * This function is used to check the access
	 */
	function isTicketter()
	{
		if ($this->role != ROLE_ADMIN || $this->role != ROLE_MANAGER) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * This function is used to load the set of views
	 */
	function loadThis()
	{
		$this->global ['pageTitle'] = 'CodeInsect : Access Denied';

		$this->load->view('includes/header', $this->global);
		$this->load->view('access');
		$this->load->view('includes/footer');
	}

	/**
	 * This function is used to logged out user from system
	 */
	function logout()
	{
		$this->session->sess_destroy();

		redirect('login');
	}

	/**
	 * This function used to load views
	 * @param {string} $viewName : This is view name
	 * @param {mixed} $headerInfo : This is array of header information
	 * @param {mixed} $pageInfo : This is array of page information
	 * @param {mixed} $footerInfo : This is array of footer information
	 * @return {null} $result : null
	 */
	function loadViews($viewName = "", $headerInfo = NULL, $pageInfo = NULL, $footerInfo = NULL)
	{

		$this->load->view('includes/header', $headerInfo);
		$this->load->view($viewName, $pageInfo);
		$this->load->view('includes/footer', $footerInfo);
	}

	/**
	 * This function used provide the pagination resources
	 * @param {string} $link : This is page link
	 * @param {number} $count : This is page count
	 * @param {number} $perPage : This is records per page limit
	 * @return {mixed} $result : This is array of records and pagination data
	 */
	function paginationCompress($link, $count, $perPage = 10)
	{
		$this->load->library('pagination');

		$config ['base_url'] = base_url() . $link;
		$config ['total_rows'] = $count;
		$config ['uri_segment'] = SEGMENT;
		$config ['per_page'] = $perPage;
		$config ['num_links'] = 5;
		$config ['full_tag_open'] = '<nav><ul class="pagination">';
		$config ['full_tag_close'] = '</ul></nav>';
		$config ['first_tag_open'] = '<li class="arrow">';
		$config ['first_link'] = 'First';
		$config ['first_tag_close'] = '</li>';
		$config ['prev_link'] = 'Previous';
		$config ['prev_tag_open'] = '<li class="arrow">';
		$config ['prev_tag_close'] = '</li>';
		$config ['next_link'] = 'Next';
		$config ['next_tag_open'] = '<li class="arrow">';
		$config ['next_tag_close'] = '</li>';
		$config ['cur_tag_open'] = '<li class="active"><a href="#">';
		$config ['cur_tag_close'] = '</a></li>';
		$config ['num_tag_open'] = '<li>';
		$config ['num_tag_close'] = '</li>';
		$config ['last_tag_open'] = '<li class="arrow">';
		$config ['last_link'] = 'Last';
		$config ['last_tag_close'] = '</li>';

		$this->pagination->initialize($config);
		$page = $config ['per_page'];
		$segment = $this->uri->segment(SEGMENT);

		return array(
			"page" => $page,
			"segment" => $segment
		);
	}

	public function set_global($pageTitle = 'KMWI - Production', $contentTitle = 'Not Set', $cardTitle = 'Not Set')
	{
		$this->global['gPageTitle'] = $pageTitle;
		$this->global['gContentTitle'] = $contentTitle;
		$this->global['gCardTitle'] = $cardTitle;
	}
}
