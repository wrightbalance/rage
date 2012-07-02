<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');  

// Basic Settings

$config['ServerName'] 		= "Geared Control Panel";
$config['BaseURI']			= "";
$config['AdminLevel'] 		= 99;
$config['UsingGroupID'] 	= true; // If false it uses level field
$config['Birthday']  		= true; // Add birthday in registration
$config['UsingMD5']			= false;
$config['EmailConfirmation'] = true;
$config['ConfirmationExpire'] = 48; // Email confirmatione expires houres

// Site Settings
$config['EnableSite']		= true; // Disabled site
$config['StreamPostDelay'] 	= 2; // By minute

//Email Settings
$config['UseSMTP']			= TRUE;
$config['MailerFrom']		= 'no-reply@domain.com';
$config['MailerHost']		= 'ssl://smtp.googlemail.com';
$config['MailerPort']		= '465';
$config['MailerSMTPUsername'] = 'jingcleovil@gmail.com';
$config['MailerSMTPPassword'] = 'pancit1983';

//TimeZone
$config['timezone'] 		= 'Asia/Manila'; // PHP Timezones available here http://php.net/manual/en/timezones.php



// Include Arrays
include('itemtypes.php');
include('word_censor.php');
