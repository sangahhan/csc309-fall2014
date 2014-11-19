<h1>Registration</h1>

<?php
    echo "<p>" . anchor('auth','Back') . "</p>";
    
    echo form_open('auth/register');
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
	    'required' => 'required'
    ));
    
    echo form_label('Password Confirmation');
    echo form_error('passconf');
    echo form_password(array(
	    'name' => 'passconf',
	    'required' => 'required'
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
    echo form_input(array (
	    'name' => 'email',
	    'type' => 'email',
	    'required' => 'required'
    ));


    echo form_submit(array (
	    'name' => 'submit',
	    'value' => 'Register',
	    'class' => 'button'
    ));
    echo form_close();
?>
