<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$saveQueries = TRUE;
$dbDebug = TRUE;
if (ENVIRONMENT == 'production')
{
    $saveQueries = FALSE;
    $dbDebug = FALSE;
}

$active_group = 'default';
$query_builder = TRUE;


$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'monitor',
	'password' => 'monitor@98116015',
	'database' => 'monitordb',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => $dbDebug,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => $saveQueries
);

$db['monitor'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'monitordb',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => $dbDebug,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => $saveQueries
);
