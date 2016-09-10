<?php
include_once('settings.php');


$bytes = 30;

if (! isset($_SESSION['CSRF']))
{
	$_SESSION['CSRF'] = bin2hex(openssl_random_pseudo_bytes($bytes));
}
$CSRF = $_SESSION['CSRF'];
?>