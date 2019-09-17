<?php
//Start Session
session_start();

//Include configuration
require_once('config/config.php');

//Autoload Classes-PHP Magic method
//The classes will automatically be loaded, we don't have to call them
function __autoload($class_name){
  require_once('classes/'.$class_name. '.php');
}



if(!isset($_SESSION['username']) and isset($_COOKIE['username'], $_COOKIE['password']))
{
	$cnn = mysql_query('select password,id from users where username="'.mysql_real_escape_string($_COOKIE['username']).'"');
	$dn_cnn = mysql_fetch_array($cnn);
	if(sha1($dn_cnn['password'])==$_COOKIE['password'] and mysql_num_rows($cnn)>0) {
		$_SESSION['username'] = $_COOKIE['username'];
		$_SESSION['userid'] = $dn_cnn['id'];
	}
}

?> 