<h2>Registration</h2>

<style>
    input { display: block;}

</style>

<?php
    echo "<p>" . anchor('auth','Back') . "</p>";
    
    echo form_open('auth/register');

    echo form_label('Username');
    echo form_error('username');
    echo form_input('username',set_value('username'),"required");

    echo form_label('Password');
    echo form_error('password');
    echo form_password('password',set_value(''),"required");

    echo form_label('First Name');
    echo form_error('first');
    echo form_input('first',set_value('first'),"required");

    echo form_label('Last Name');
    echo form_error('last');
    echo form_input('last',set_value('last'),"required");

    echo form_label('Email');
    echo form_error('email');
    echo form_input('email',set_value('email'),"required");

    echo "<br>";

    echo form_submit('submit', 'Register');
    echo form_close();
?>
