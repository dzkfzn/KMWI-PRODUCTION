<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//// To use reCAPTCHA, you need to sign up for an API key pair for your site.
//// link: http://www.google.com/recaptcha/admin
//$config['recaptcha_site_key'] = '6LffINMUAAAAAL3uEMezcrS5eBvRd8FEvSk7B3f0';
//$config['recaptcha_secret_key'] = '6LffINMUAAAAAEfmtTi9PZgi_WN1FG4IaJVpmfdF';
//
//// reCAPTCHA supported 40+ languages listed here:
//// https://developers.google.com/recaptcha/docs/language
//$config['recaptcha_lang'] = 'en';
///* End of file recaptcha.php */
///* Location: ./application/config/recaptcha.php */

/**
 * Recaptcha configuration settings
 *
 * recaptcha_sitekey: Recaptcha site key to use in the widget
 * recaptcha_secretkey: Recaptcha secret key which is used for communicating between your server to Google's
 * lang: Language code, if blank "en" will be used
 *
 * recaptcha_sitekey and recaptcha_secretkey can be obtained from https://www.google.com/recaptcha/admin/
 * Language code can be obtained from https://developers.google.com/recaptcha/docs/language
 *
 * @author Damar Riyadi <damar@tahutek.net-->
 */
$config['recaptcha_sitekey'] = '6LcTeNcUAAAAAB4K5vnHXIzVrg27qU6YAeGa0p2G';

$config['recaptcha_secretkey'] = '6LcTeNcUAAAAAFBiBbkqTrj61LlrDHhvcLDFSzZu';

$config['lang'] = "id";
