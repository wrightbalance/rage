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
$config['StreamPostDelay'] 	= 10; // By minute

//Email Settings
$config['UseSMTP']			= TRUE;
$config['MailerFrom']		= 'no-reply@domain.com';
$config['MailerHost']		= 'ssl://smtp.googlemail.com';
$config['MailerPort']		= '465';
$config['MailerSMTPUsername'] = 'jingcleovil@gmail.com';
$config['MailerSMTPPassword'] = 'pancit1983';


// Include Arrays
include('itemtypes.php');
