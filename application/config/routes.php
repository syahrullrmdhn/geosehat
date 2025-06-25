<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'auth/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth
$route['login']           = 'auth/login';
$route['login/submit']    = 'auth/login_submit';
$route['register']        = 'auth/register';
$route['register/submit'] = 'auth/register_submit';
$route['logout']          = 'auth/logout';

// Dashboard
$route['dashboard'] = 'dashboard';

// Input Kasus
$route['cases/input'] = 'cases/create';
$route['cases/save']  = 'cases/save';

// Settings Threshold
$route['settings/threshold']         = 'threshold/edit';
$route['settings/threshold/update']  = 'threshold/update';

$route['diseases']         = 'Diseases/index';
$route['diseases/store']   = 'Diseases/store';
$route['regions']          = 'Regions/index';
$route['regions/store']    = 'Regions/store';
// dst.
$route['settings/notifications']      = 'settings/notifications';
$route['settings/save_notifications'] = 'settings/save_notifications';
$route['faskes-staff']       = 'FaskesStaff/index';
$route['faskes-staff/store'] = 'FaskesStaff/store';
$route['faskes-staff/edit/(:num)'] = 'FaskesStaff/edit/$1';
$route['faskes-staff/update/(:num)'] = 'FaskesStaff/update/$1';
$route['faskes-staff/delete/(:num)'] = 'FaskesStaff/delete/$1';
