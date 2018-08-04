<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'landing';
$route['(:any)'] = 'app/url/$1';
$route['(:any)/(:any)'] = 'app/$1/$2'; // remove this for production

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
