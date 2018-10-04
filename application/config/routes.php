<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'landing';

$route['test'] = 'app/test';

$route['login'] = 'app/login';
$route['logout'] = 'app/logout';
$route['dash'] = 'app/dash';
$route['save'] = 'app/save';
$route['update'] = 'app/update';
$route['delete'] = 'app/delete';
$route['(:any)'] = 'app/url/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
