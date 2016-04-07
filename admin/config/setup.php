<?php
//Setup File:

#error reporting:
error_reporting(0);

#Database Connection:
include('../config/connection.php');

#Constants:
DEFINE('D_TEMPLATE', 'template');

#Functions:
include('functions/data.php');
include('functions/template.php');
include('functions/sandbox.php');

#Site Setup:
$debug = data_setting_value($dbc, 'debug-status');

$site_title = 'DASS CMS';

if(isset($_GET['page'])) {
	$page = $_GET['page']; //set pageid equal to the value defined in the url
}
else {
	$page = 'dashboard'; //set page equal to the home page pageid when the page is not present in the url 
}

#Page Setup:
include('config/queries.php');


# User Setup:

$user = data_user($dbc, $_SESSION['username']);

?>