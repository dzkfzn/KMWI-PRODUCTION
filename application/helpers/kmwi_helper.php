<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * This function is used to print the content of any data
 */
function pre($data)
{
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}


// Function to get the client IP address
function get_client_ip()
{
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if (getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if (getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if (getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if (getenv('HTTP_FORWARDED'))
		$ipaddress = getenv('HTTP_FORWARDED');
	else if (getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
		$ipaddress = 'UNKNOWN';
	return $ipaddress;
}

/**
 * This function used to get the CI instance
 */
if (!function_exists('get_instance')) {
	function get_instance()
	{
		$CI = &get_instance();
	}
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 */
if (!function_exists('getHashedPassword')) {
	function getHashedPassword($plainPassword)
	{
		return password_hash($plainPassword, PASSWORD_DEFAULT);
	}
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 * @param {string} $hashedPassword : This is hashed password
 */
if (!function_exists('verifyHashedPassword')) {
	function verifyHashedPassword($plainPassword, $hashedPassword)
	{
		return password_verify($plainPassword, $hashedPassword) ? true : false;
	}
}

/**
 * This method used to get current browser agent
 */
if (!function_exists('getBrowserAgent')) {
	function getBrowserAgent()
	{
		$CI = get_instance();
		$CI->load->library('user_agent');

		$agent = '';

		if ($CI->agent->is_browser()) {
			$agent = $CI->agent->browser() . ' ' . $CI->agent->version();
		} else if ($CI->agent->is_robot()) {
			$agent = $CI->agent->robot();
		} else if ($CI->agent->is_mobile()) {
			$agent = $CI->agent->mobile();
		} else {
			$agent = 'Unidentified User Agent';
		}

		return $agent;
	}
}
if (!function_exists('getPlatformAgent')) {
	function getPlatformAgent()
	{
		$CI = get_instance();
		$CI->load->library('user_agent');

		return $CI->agent->platform();
	}
}

if (!function_exists('setProtocol')) {
	function setProtocol()
	{
		$CI = &get_instance();

		$CI->load->library('email');

		$config['protocol'] = 'smtp';
//        $config['mailpath'] = MAIL_PATH;
		$config['smtp_host'] = 'mail.dzakifauzaan.com';
		$config['smtp_port'] = '465';
		$config['smtp_user'] = 'dzkfzn@dzakifauzaan.com';
		$config['smtp_pass'] = 'DROPDEAd1230';
		$config['charset'] = "utf-8";
		$config['mailtype'] = "html";
		$config['newline'] = "\r\n";

		$CI->email->initialize($config);

		return $CI;
	}
}

if (!function_exists('emailConfig')) {
	function emailConfig()
	{
		$CI->load->library('email');
		$config['protocol'] = PROTOCOL;
		$config['smtp_host'] = SMTP_HOST;
		$config['smtp_port'] = SMTP_PORT;
		$config['mailpath'] = MAIL_PATH;
		$config['charset'] = 'UTF-8';
		$config['mailtype'] = "html";
		$config['newline'] = "\r\n";
		$config['wordwrap'] = TRUE;
	}
}

if (!function_exists('resetPasswordEmail')) {
	function resetPasswordEmail($detail)
	{
		$data["data"] = $detail;
		// pre($detail);
		// die;

		$CI = setProtocol();

		$CI->email->from('dzkfzn@dzakifauzaan.com', 'Dzaki Fauzaan');
		$CI->email->subject("Reset Password");
		$CI->email->message($CI->load->view('email/resetPassword', $data, TRUE));
		$CI->email->to($detail["email"]);
		$status = $CI->email->send();

		return $status;
	}
}

if (!function_exists('setFlashData')) {
	function setFlashData($status, $flashMsg)
	{
		$CI = get_instance();
		$CI->session->set_flashdata($status, $flashMsg);
	}
}

function time_elapsed_string($datetime, $full = false)
{
	date_default_timezone_set('Asia/Jakarta');
	$now = new DateTime('now');
//                                $now = new DateTime;
	$ago = new DateTime($datetime);
	$diff = $now->diff($ago);

	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;

	$string = array(
		'y' => 'year',
		'm' => 'month',
		'w' => 'week',
		'd' => 'day',
		'h' => 'hour',
		'i' => 'minute',
		's' => 'second',
	);
	foreach ($string as $k => &$v) {
		if ($diff->$k) {
			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
		} else {
			unset($string[$k]);
		}
	}

	if (!$full)
		$string = array_slice($string, 0, 1);
	return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function time_future_string($datetime)
{
	// The event date
	$eventdate = strtotime($datetime);

// Today's date
	$today = strtotime('now');

// Tomorrow's date
	$tomorrow = strtotime('tomorrow');

// If event date is equal to today's date, show TODAY
	if (date('m-d-Y', $today) == date('m-d-Y', $eventdate)) {
		return 'Today';
	}

// If event date is equal to tomorrow's date, show TOMORROW
	if (date('m-d-Y', $tomorrow) == date('m-d-Y', $eventdate)) {
		return 'Tomorrow';
	}

// If event date is not equal to today's or tomorrow's date, print the date
	if ((date('m-d-Y', $today) != date('m-d-Y', $eventdate)) && (date('m-d-Y', $tomorrow) != date('m-d-Y', $eventdate))) {
		return date('M j', $eventdate);
	}
}

function secondsToTime($inputSeconds)
{

	$secondsInAMinute = 60;
	$secondsInAnHour = 60 * $secondsInAMinute;
	$secondsInADay = 24 * $secondsInAnHour;

	// extract days
	$days = floor($inputSeconds / $secondsInADay);

	// extract hours
	$hourSeconds = $inputSeconds % $secondsInADay;
	$hours = floor($hourSeconds / $secondsInAnHour);

	// extract minutes
	$minuteSeconds = $hourSeconds % $secondsInAnHour;
	$minutes = floor($minuteSeconds / $secondsInAMinute);

	// extract the remaining seconds
	$remainingSeconds = $minuteSeconds % $secondsInAMinute;
	$seconds = ceil($remainingSeconds);

	// return the final array
	$timeParts = array();
	$obj = array(
		'day' => (int)$days,
		'hour' => (int)$hours,
		'minute' => (int)$minutes,
		'second' => (int)$seconds,
	);
	foreach ($obj as $name => $value) {
		if ($value > 0) {
			$timeParts[] = $value . ' ' . $name;
		}
	}
	return implode(' ', $timeParts);
}

function timeToSeconds($str_time)
{
	sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
	$time_seconds = isset($hours) ? $hours * 3600 + $minutes * 60 + $seconds : $minutes * 60 + $seconds;
	return $time_seconds;
}


function is_active_navigation($uri, $menu = array())
{
//	$menu_master = array('user', 'station', 'scheme', 'product', 'shift');
	if (in_array($uri, $menu))
		return 'class="active"';
	else
		return '';
}

function is_expanded_navigation($uri, $menu = array())
{
//	$menu_master = array('user', 'station', 'scheme', 'product', 'shift');
	if (in_array($uri, $menu))
		return 'aria-expanded="true"';
	else
		return '';
}

function is_collapse_navigation($uri, $menu = array())
{
//	$menu_master = array('user', 'station', 'scheme', 'product', 'shift');
	if (in_array($uri, $menu))
		return 'collapse in';
	else
		return 'collapse';
}

function is_null_modiby($var, $is_date_format = FALSE)
{
	if (is_null($var))
		return 'never have been edited before';
	else if ($is_date_format)
		return time_elapsed_string($var);
	else
		return $var;
}

function print_beauty_status($deleted, $active_format = FALSE)
{
	if (!$active_format)
		$status = 1;
	else
		$status = 0;
	$text = ($deleted == $status) ? 'Inactive' : 'Active';
	$label = ($deleted == $status) ? 'default' : 'primary';
	return '<span class="label label-' . $label . '">' . $text . '</span>';
}

function print_beauty_statusv2($text, $status)
{
	//0 = default - past
	//1 = success - working in
	//2 = warning - future
	return '<span class="label label-' . $status . '">' . $text . '</span>';
}


function empty_object($obj)
{
	$arr = (array)$obj;
	if (empty($arr)) {
		return TRUE;
	}
	return FALSE;
}

function is_null_station($station)
{
	if (is_null($station)) {
		return TRUE;
	} else {
		return FALSE;
	}
}

function print_beauty_date($timestamp)
{
	return date("j F Y", strtotime($timestamp));
}

function print_beauty_time($timestamp)
{
	return date('H:i', strtotime($timestamp));
}

function is_shift_pass_midnight($start_date, $end_date)
{
	$start = new DateTime($start_date);
	$end = new DateTime($end_date);

	//in case kalo shift malem contoh 18:00-02:00
	if ($start > $end)
		return TRUE;
	return FALSE;

}

function is_now_time_between($start_date, $end_date, $is_prod_date_pass_night = FALSE)
{
	$now = new DateTime(date("H:i"));

	$start = new DateTime($start_date);
	$end = new DateTime($end_date);

	//in case kalo shift malem contoh 18:00-02:00
	if ($start > $end && $is_prod_date_pass_night)
		$start->modify('-1 day');
	else if ($start > $end)
		$start->modify('+1 day');

//	$end = DateTime::createFromFormat('H:i', $end_date);
	if ($start <= $now && $now <= $end) {
		return TRUE;
	}
	return FALSE;
}

function is_time_before($start_shift)
{
	$now = new DateTime(date("H:i"));

	$start = new DateTime($start_shift);
//	$end = new DateTime($end_date);

	//in case kalo shift malem contoh 18:00-02:00
	if ($now < $start)
		return TRUE;
	return FALSE;
}

function is_now_date_same($datetime)
{
	$eventdate = strtotime($datetime);

	$today = strtotime('now');
	if (date('m-d-Y', $today) == date('m-d-Y', $eventdate)) {
		return TRUE;
	}
	return FALSE;
}

function is_now_date_same_night_shift($datetime)
{
	$eventdate = strtotime($datetime);

	$today = strtotime('yesterday');
	if (date('m-d-Y', $today) == date('m-d-Y', $eventdate)) {
		return TRUE;
	}
	return FALSE;
}

function is_now_date_history($datetime)
{
	$eventdate = strtotime($datetime);

	$today = strtotime('now');
	if (date('m-d-Y', $today) > date('m-d-Y', $eventdate)) {
		return TRUE;
	}
	return FALSE;
}


function pluralize($count, $text)
{
	return $count . (($count == 1) ? (" $text") : (" ${text}s"));
}

function ago($date, $time, $suffix_ovveride = FALSE, $prefix_ovveride = FALSE, $is_pass_night = FALSE)
{
//	$first_date = new DateTime("2020-02-12" . "17:03");
	$date = new DateTime($date . $time);
	if ($is_pass_night)
		$date->modify('+1 day');

//	$start = DateTime::createFromFormat('Y-m-d', "2020-02-22");
//	$start = DateTime::createFromFormat('H:i', "19:00");

	$interval = date_create('now')->diff($date);
	$suffix = '';
	$prefix = '';
	if ($interval->invert)
		$suffix = ($suffix_ovveride) ? $suffix_ovveride : ' ago';
	else
		$prefix = ($prefix_ovveride) ? $prefix_ovveride : 'in ';
	if ($v = $interval->y >= 1)
		return $prefix . pluralize($interval->y, 'year') . $suffix;
	if ($v = $interval->m >= 1)
		return $prefix . pluralize($interval->m, 'month') . $suffix;
	if ($v = $interval->d >= 1)
		return $prefix . pluralize($interval->d, 'day') . $suffix;
	if ($v = $interval->h >= 1)
		return $prefix . pluralize($interval->h, 'hour') . $suffix;
	if ($v = $interval->i >= 1)
		return $prefix . pluralize($interval->i, 'minute') . $suffix;
	return $prefix . pluralize($interval->s, 'second') . $suffix;
}


//
//function pluralize( $count, $text )
//{
//	return $count . ( ( $count == 1 ) ? ( " $text" ) : ( " ${text}s" ) );
//}
//
//function ago( $datetime )
//{
//	$interval = date_create('now')->diff( $datetime );
//	$suffix = ( $interval->invert ? ' ago' : '' );
//	if ( $v = $interval->y >= 1 ) return pluralize( $interval->y, 'year' ) . $suffix;
//	if ( $v = $interval->m >= 1 ) return pluralize( $interval->m, 'month' ) . $suffix;
//	if ( $v = $interval->d >= 1 ) return pluralize( $interval->d, 'day' ) . $suffix;
//	if ( $v = $interval->h >= 1 ) return pluralize( $interval->h, 'hour' ) . $suffix;
//	if ( $v = $interval->i >= 1 ) return pluralize( $interval->i, 'minute' ) . $suffix;
//	return pluralize( $interval->s, 'second' ) . $suffix;
//}
?>
