<?php

$ci =& get_instance();
$action = $ci->input->post('action');

if($action == "changepass")
{
	$config['account/update'] = array(
		array(
				'field' => 'old_password',
				'label' => 'Old Password',
				'rules' => 'trim|required|callback__check_password'
			 ),
		array(
				'field' => 'new_password',
				'label' => 'New Password',
				'rules' => 'trim|required'
			 ),
		array(
				'field' => 'confirm_password',
				'label' => 'Confirm Password',
				'rules' => 'trim|required|matches[new_password]'
			 )
			 
		);
}
else if($action == "changeemail")
{
	$config['account/update'] = array(
		array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'trim|required|md5|callback__check_password'
			 ),
		array(
				'field' => 'current_email',
				'label' => 'Current Email Address',
				'rules' => 'trim|required|valid_email|callback__check_email'
			 ),
		array(
				'field' => 'new_email',
				'label' => 'New Email',
				'rules' => 'trim|required|valid_email|callback__check_email_exists'
			 )
			 
		);
}
else if($action == "update_account")
{
	$config['account/update'] = array(
		array(
				'field' => 'nickname',
				'label' => 'Nickname',
				'rules' => 'trim|required|callback_checkNickname'
			 ),
		array(
				'field' => 'email',
				'label' => 'E-mail Address',
				'rules' => 'trim|required|valid_email|callback__check_email_exists'
			 ),
		array(
			'field' => 'group_id',
			'label' => 'Account Level',
			'rules' => 'trim|required|integer'
		 )
			 
		);
}
