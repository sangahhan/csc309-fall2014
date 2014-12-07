
<h1>Recover Password</h1>
<?php 
	
	echo form_open('account/recoverPassword', array('onSubmit' => 'return validateRecovery()', 'id'=> 'recovery-form'));
	echo '<p class="error" id="recovery-form-error">';
	if (isset($errorMsg)) echo $errorMsg;
	echo '</p>';

	echo form_label('E-mail address'); 
	echo form_error('email');

	echo '<p class="error" id="recovery-email-error"></p>';
	echo form_input(array (
		'name' => 'email',
		'type' => 'email',
		'required' => 'required',
		'id' => 'recovery-email',
	));
	echo form_submit('submit', 'Recover Password');
	echo form_close();
?>	


