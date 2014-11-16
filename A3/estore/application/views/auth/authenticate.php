<h2>Login</h2>

<style>
    input { display: block;}
</style>


<div>
    <?php if ( $failed_attempt) {?>
        <p> Login failed, please try again </p>
    <?php } ?>
</div>

<?php

    echo form_open("auth/login");

    echo form_label('Username');
    echo form_error('username');
    echo form_input('username', set_value(''), "required");

    echo form_label('Passowrd');
    echo form_error('description');
    echo form_password('password', set_value(''),"required");
    echo "<br>";

    echo form_submit('submit', 'Login');
    echo form_close();

    echo "<p> Don't have an account? " . anchor('auth/registration_form','Register') . "</p>";
?>
