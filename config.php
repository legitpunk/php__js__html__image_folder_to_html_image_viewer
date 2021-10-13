<?php


//need to create an apache_alias to the folder that holds the file files you want the explorer to navigate

//start a session for $_SESSION vars to work
session_start();

//make the browser cache last a long time
header("Cache-Control: max-age=2592000");

//reads the config.cfg file where the site's settings are stored and puts the contents into an array, each line being an element. This is editable by opening config.php file in a browser.
//defaults to the "drive_site_dir" variable's location, for example: "C:/wamp/www/domain_name.com/LegitPunk.com/templates/file_explorer_iterator/config.cfg".
$lines = file('config.cfg');	

$_SESSION['basename_file']		=	pathinfo(__FILE__, PATHINFO_FILENAME);
$_SESSION['drive_site_dir'] 			=	str_replace($_SESSION["basename_file"].".php", "", $_SERVER["SCRIPT_FILENAME"]);		//example  				C:/wamp/www/LegitPunk.com/templates/file_explorer_iterator/
$_SESSION["site_dir"]						=	str_replace($_SESSION["basename_file"].".php", "", $_SERVER["SCRIPT_NAME"]);				//example           		/LegitPunk.com/templates/file_explorer_iterator/
$_SESSION['http_dir']						=	$_SESSION['http'].$_SESSION['domain'].$_SESSION["site_dir"].'updates/'.$_SESSION['version'].'/';
$_SESSION['http_site_dir']			=	$_SESSION['http'].$_SESSION['domain'].$_SESSION["site_dir"];

//clears the whitespace from each line and creates an array via the ";" as a node pointer.
foreach($lines as $line)
{
	$linee						=	preg_replace('/\s+/', '', $line);
	$array_of_lines[]	=	str_replace(";", "", $linee);
}

//assigns http encryption protocol in use.
if($array_of_lines[0] === '1')
{
	$_SESSION['http']							=	'http://';
}
else
{
	$_SESSION['http']							=	'https://';
}

//assign session vars for use with index.php
$_SESSION['version']						=	$array_of_lines[1];
$_SESSION['domain']						=	$array_of_lines[2];
$_SESSION['images_logo']			=	$array_of_lines[3];
$_SESSION['apache_alias']			=	$array_of_lines[4];  	 //		'http://domain_name_or_host_name/alias_made_in_apache2/';
$_SESSION['original_dir']				=	$array_of_lines[5];  	//		'C:/folder/subfolder_with_folders_and_files_to_use_for_browsing/'

include('config_page.php');











