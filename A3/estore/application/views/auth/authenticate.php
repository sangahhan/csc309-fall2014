<?php if ($this->session->flashdata('redirect')) {?>
    <p> Sorry! You need to be logged in to view store content </p>
<?php } ?>

<h1>Login</h1>

    <?php if ( $failed_attempt) {?>
        <p> Login failed, please try again </p>
    <?php } ?>

<?php

    echo form_open("auth/login");

    echo form_label('Username');
    echo form_error('username');
    echo form_input('username', set_value(''), "required");

    echo form_label('Password');
    echo form_error('description');
    echo form_password('password', set_value(''),"required");

    echo form_submit('submit', 'Login', 'class="button"');
    echo form_close();

    echo "<p> Don't have an account? " . anchor('auth/registration_form','Register') . "</p>";
?>
