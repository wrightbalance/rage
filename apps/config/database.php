<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$active_group = 'server';
$active_record = TRUE;

if(strpos(config_item('base_url'),'ragnagears.com')) $active_group = "demo";

$db['demo']['hostname'] = 'localhost';
$db['demo']['username'] = 'jingcleo';
$db['demo']['password'] = 'pancit1983';
$db['demo']['database'] = 'jingcleo_ragnagear';
$db['demo']['dbdriver'] = 'mysql';
$db['demo']['dbprefix'] = '';
$db['demo']['pconnect'] = FALSE;
$db['demo']['db_debug'] = TRUE;
$db['demo']['cache_on'] = FALSE;
$db['demo']['cachedir'] = '';
$db['demo']['char_set'] = 'utf8';
$db['demo']['dbcollat'] = 'utf8_general_ci';
$db['demo']['swap_pre'] = '';
$db['demo']['autoinit'] = TRUE;
$db['demo']['stricton'] = FALSE;

$db['server']['hostname'] = 'localhost';
$db['server']['username'] = 'root';
$db['server']['password'] = '1234';
$db['server']['database'] = 'ragnagear';
$db['server']['dbdriver'] = 'mysql';
$db['server']['dbprefix'] = '';
$db['server']['pconnect'] = FALSE;
$db['server']['db_debug'] = TRUE;
$db['server']['cache_on'] = FALSE;
$db['server']['cachedir'] = '';
$db['server']['char_set'] = 'utf8';
$db['server']['dbcollat'] = 'utf8_general_ci';
$db['server']['swap_pre'] = '';
$db['server']['autoinit'] = TRUE;
$db['server']['stricton'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */

