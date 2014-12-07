 <h1>New Account</h1>
<?php 
	echo form_open('account/createNew', array('onSubmit' => 'return validateRegistration()', 'id'=> 'registration-form'));
	
	// area for error messages to show form JS form validation
	echo '<p class="error" id="registration-form-error">';
	if (isset($errormsg)) echo $errormsg;
	echo '</p>';

	echo form_label('Username'); 
	echo form_error('username');
	echo form_input(array(
		'name' => 'username',
		'required' => 'required'
	));
	

	echo form_label('Password'); 
	echo form_error('password');
	echo form_password(array(
		'name' => 'password',
		'required' => 'required',
		'id' => 'registration-password'
	));

	echo form_label('Password Confirmation'); 
	echo form_error('passconf');
	echo '<p class="error" id="registration-passconf-error"></p>';
	echo form_password(array(
		'name' => 'passconf',
		'required' => 'required',
		'id' => 'registration-passconf',
		'oninput' => 'checkRegistrationPassword();'
	));


	echo form_label('First');
	echo form_error('first');
	echo form_input(array (
		'name' => 'first',
		'required' => 'required'
	));


	echo form_label('Last');
	echo form_error('last');
	echo form_input( array(
		'name' => 'last',
		'required' => 'required'
	));

	echo form_label('E-mail address');
	echo form_error('email');
	echo '<p class="error" id="registration-email-error"></p>';
	echo form_input(array (
		'name' => 'email',
		'type' => 'email',
		'required' => 'required',
		'id' => 'registration-email',
	));

        $this->load->helper('html');

	echo img("account/showCaptchaImage", TRUE);
	echo form_input("verifycode", "", "id='verifycode' required");
	echo form_error('verifycode');

	echo form_submit('submit', 'Register');
	echo form_close();
?>	
