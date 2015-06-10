<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "main";
$route['404_override'] = '';
$route['/'] = "main";
$route['register'] = "main/register";
$route['signin'] = "main/sign_in";
$route['dashboard'] = "main/user_dashboard";
$route['admin/dashboard'] = "main/admin_dashboard";
$route['users/info/(:any)'] = "main/user_info/$1";
$route['users/edit/(:any)'] = "main/edit_user/$1";
$route['users/remove/(:any)'] = "main/remove/$1";
$route['user/profile'] = "main/profile";
$route['users/new'] = "main/user_new";
$route['add_user'] = "main/add_user";
$route['edit/profile'] = "main/edit_profile";
//end of routes.php