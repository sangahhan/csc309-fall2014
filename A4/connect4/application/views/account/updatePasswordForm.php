
	<h1>Change Password</h1>
<?php 
	echo form_open('account/updatePassword', array('onSubmit' => 'return validatePasswordUpdate()', 'id'=> 'passwordUpdate-form'));
	
// area for error messages to show form JS form validation
	echo '<p class="error" id="passwordUpdate-form-error">';
	if (isset($errorMsg)) echo $errorMsg;
	echo '</p>';

	echo form_label('Current Password'); 
	echo form_error('oldPassword');
	echo form_password(array(
		'name' => 'oldPassword',
		'required' => 'required',
	));

	echo form_label('New Password'); 
	echo form_error('newPassword');
	echo form_password(array(
		'name' => 'newPassword',
		'required' => 'required',
		'id' => 'passwordUpdate-password'
	));

	echo form_label('Password Confirmation'); 
	echo form_error('passconf');
	echo '<p class="error" id="passwordUpdate-passconf-error"></p>';
	echo form_password(array(
		'name' => 'passconf',
		'required' => 'required',
		'id' => 'passwordUpdate-passconf',
		'oninput'=> 'checkUpdatePassword();'
	));

	echo form_submit('submit', 'Change Password');
	echo form_close();
?>	
