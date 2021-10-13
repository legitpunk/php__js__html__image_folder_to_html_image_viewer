<?php

//checks ajax post value whether http or https
if($_POST['value'] === 'http')
{
	$value  = '1;';		//http
}
else
{
	$value  = '2;';		//https
}

//write to "config.cfg" file
$filename = $_SESSION['drive_site_dir'] . 'config.cfg';
$line_i_am_looking_for = 0;
$lines = file( $filename , FILE_IGNORE_NEW_LINES );
$lines[$line_i_am_looking_for] = $value;
file_put_contents( $filename , implode( "\n", $lines ) );






?>