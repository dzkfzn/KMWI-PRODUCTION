<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'portal';
$route['404_override'] = 'auth/show404';
$route['translate_uri_dashes'] = FALSE;

/*********** USER DEFINED ROUTES *******************/
//application
$route['production/dashboard'] = 'auth/dashboard';
$route['production'] = 'auth';

//user
$route['production/logout'] = 'auth/logout';
$route['production/login'] = 'auth';
$route['production/forgot_password'] = 'auth/forgot_password';
$route['production/change_password'] = 'auth/change_password';

//admin - user
$route['production/user'] = 'auth/user';
$route['production/user/add'] = 'auth/create_user';
$route['production/user/edit/(:any)'] = 'auth/edit_user/$1';
$route['production/user/detail/(:any)'] = 'auth/edit_user/$1/0';
$route['production/user/active/(:any)'] = 'auth/activate/$1';
$route['production/user/active/(:any)/(:any)'] = 'auth/activate/$1/$2';
$route['production/user/inactive/(:any)'] = 'auth/deactivate/$1';

//admin - station
$route['production/station'] = 'master/station';
$route['production/station/add'] = 'master/station_create';
$route['production/station/edit/(:any)'] = 'master/station_edit/$1';
$route['production/station/detail/(:any)'] = 'master/station_edit/$1/0';
$route['production/station/active/(:any)'] = 'master/station_activate/$1';
$route['production/station/inactive/(:any)'] = 'master/station_inactive/$1';

//admin - scheme
$route['production/scheme'] = 'master/scheme';
$route['production/scheme/add'] = 'master/scheme_create';
$route['production/scheme/edit/(:any)'] = 'master/scheme_edit/$1';
$route['production/scheme/detail/(:any)'] = 'master/scheme_edit/$1/0';
$route['production/scheme/active/(:any)'] = 'master/scheme_activate/$1';
$route['production/scheme/inactive/(:any)'] = 'master/scheme_inactive/$1';

//admin - product
$route['production/product'] = 'master/product';
$route['production/product/add'] = 'master/product_create';
$route['production/product/edit/(:any)'] = 'master/product_edit/$1';
$route['production/product/detail/(:any)'] = 'master/product_edit/$1/0';
$route['production/product/active/(:any)'] = 'master/product_activate/$1';
$route['production/product/inactive/(:any)'] = 'master/product_inactive/$1';

//admin - shift
$route['production/shift'] = 'master/shift';
$route['production/shift/add'] = 'master/shift_create';
$route['production/shift/edit/(:any)'] = 'master/shift_edit/$1';
$route['production/shift/detail/(:any)'] = 'master/shift_edit/$1/0';
$route['production/shift/active/(:any)'] = 'master/shift_activate/$1';
$route['production/shift/inactive/(:any)'] = 'master/shift_inactive/$1';

//ppic - schedule
$route['production/schedule'] = 'ppic/schedule_today';
$route['production/schedule/add/1'] = 'ppic/schedule_create/1';
$route['production/schedule/add/2/(:any)/(:any)'] = 'ppic/schedule_create/2/$1/$2';
$route['production/schedule/add/3/(:any)'] = 'ppic/schedule_create/3/$1';
$route['production/schedule/add/3/(:any)/(:any)'] = 'ppic/schedule_create_step3/$1/1';
$route['production/schedule/inactive/(:any)'] = 'ppic/schedule_inactive/$1';


$route['production/shift/edit/(:any)'] = 'master/shift_edit/$1';
$route['production/shift/detail/(:any)'] = 'master/shift_edit/$1/0';
$route['production/shift/active/(:any)'] = 'master/shift_activate/$1';
$route['production/shift/inactive/(:any)'] = 'master/shift_inactive/$1';
