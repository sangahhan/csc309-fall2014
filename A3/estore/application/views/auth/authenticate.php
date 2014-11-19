<?php if ($this->session->flashdata('redirect')) {?>
    <p> Sorry! You need to be logged in to view store content </p>
<?php } ?>

<h1>Login</h1>

    <?php if ( $failed_attempt) {?>
        <p> Login failed, please try again </p>
    <?php } ?>

<?php

echo form_open("auth/login", array('onSubmit' => 'return validateLogin()', 'id'=> 'login-form'));
echo '<p class="error" id="login-form-error"></p>';

    echo form_label('Username');
    echo form_error('username');
    echo form_input(array (
	    'name' => 'username', 
	    'required' => 'required'
    ));

    echo form_label('Password');
    echo form_error('description');
    echo form_password(array(
	    'name' => 'password',
	    'required' => 'required'
    ));

    echo form_submit(array(
	    'name' => 'submit', 
	    'value' => 'Login',
	    'class' => 'button'
    ));
    echo form_close();

    echo "<p> Don't have an account? " . anchor('auth/registration_form','Register') . "</p>";
?>
