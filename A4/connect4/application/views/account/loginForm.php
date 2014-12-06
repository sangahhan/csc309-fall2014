
	<h1>Login</h1>
<?php 
	if (isset($errorMsg)) {
		echo "<p>" . $errorMsg . "</p>";
	}


	echo form_open('account/login', array('onSubmit' => 'return validateLogin()', 'id'=> 'login-form'));
	// area for error messages to show from JS form validation
	echo '<p class="error" id="login-form-error">';
	if (isset($errorMsg)) echo $errorMsg;
	echo '</p>';

	echo form_label('Username'); 
	echo form_error('username');
	echo form_input(array (
		'name' => 'username', 
		'required' => 'required'	
	));
	echo form_label('Password'); 
	echo form_error('password');
	echo form_password(array(
		'name' => 'password',
		'required' => 'required'
	));
	
	echo form_submit('submit', 'Login');
	
	echo "<p>Don't have an account? " . anchor('account/newForm','Create one!') . "</p>";

	echo "<p>Forgot your password? " . anchor('account/recoverPasswordForm','Let\'s send you a new one.') . "</p>";
	
	
	echo form_close();
?>	

