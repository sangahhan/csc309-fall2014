<h1>Registration</h1>

<?php
// View for registration page

echo "<p>" . anchor(site_url('auth'),'Back') . "</p>";

echo form_open('auth/register', array('onSubmit' => 'return validateRegistration()', 'id'=> 'registration-form'));
// area for error messages to show form JS form validation
echo '<p class="error" id="registration-form-error"></p>';

echo form_label('Username');
echo form_error('username');
echo form_input(array(
	'name' => 'username',
	'required' => 'required'
));

echo form_label('Password');
echo form_error('password');
echo '<p class="error" id="registration-password-error"></p>';
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
	'id' => 'registration-passconf'
));


echo form_label('First Name');
echo form_error('first');
echo form_input(array (
	'name' => 'first',
	'required' => 'required'
));

echo form_label('Last Name');
echo form_error('last');
echo form_input( array(
	'name' => 'last',
	'required' => 'required'
));

echo form_label('E-mail Address');
echo form_error('email');
echo '<p class="error" id="registration-email-error"></p>';
echo form_input(array (
	'name' => 'email',
	'type' => 'email',
	'required' => 'required',
	'id' => 'registration-email'
));


echo form_submit(array (
	'name' => 'submit',
	'value' => 'Register',
	'class' => 'button'
));
echo form_close();
?>
