var ERR_FOUND_EMPTY = "Please fill in all values.";
var ERR_PASSWORD_MISMATCH = "Please enter matching passwords.";
var ERR_INVALID_EMAIL = "Please enter a valid e-mail address."

/* responsive menu functions */
$(function(){
	$(window).resize(function() {
		if ($(document).width() > 600){
			$('#dropdown').hide();
		}
	});
	$('#menu-button').click(function() {
		$('#dropdown').toggle();
	});
});

/* form validation helpers */

function validateEmail(email){
	return !!email.match(/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/);	
}

function foundEmpty(query) {
	var found = false; 
	$(query).each(function(){
		    if(!$(this).val().trim()){
			    found = true;
			    return;
		    }
	 });
	return found;
}

/* using jquery to set custom HTML5 validation messages */

function checkPassword(password, passconf) {
	var password = $(password);
	var passconf = $(passconf);
	if (password.val().trim() == passconf.val().trim()) {
		passconf.get(0).setCustomValidity("");  // All is well, clear error message
		return true;
	} else {
		passconf.get(0).setCustomValidity(ERR_PASSWORD_MISMATCH);
		return false;
	}
}

function checkRegistrationPassword() {
	return checkPassword("#registration-password", "#registration-passconf");
}

function checkUpdatePassword() {
	return checkPassword("#passwordUpdate-password", "#passwordUpdate-passconf");
}


/* manual form validation functions */

function validateLogin(){
	$('#login-form-error').html('');			
	
	if (foundEmpty('#login-form input')) {
		$('#login-form-error').html(ERR_FOUND_EMPTY);			
		return false;
	}
	
	return true;
}


function validateRegistration(){
	$('#registration-form-error').html('');			
	$('#registration-passconf-error').html('');			
	$('#registration-email-error').html('');			


	if (foundEmpty('#registration-form input')) {
		$('#registration-form-error').html(ERR_FOUND_EMPTY);			
		return false;
	}
	var passconf = $('#registration-passconf').val().trim();
	var password = $('#registration-password').val().trim();
	if (password != passconf) {
		$('#registration-passconf-error').html(ERR_PASSWORD_MISMATCH);
		return false;
	}
	var email = $('#registration-email').val().trim();
	if (!validateEmail(email)) {
		$('#registration-email-error').html(ERR_INVALID_EMAIL);
		return false;
	}
	
	return true;
}

function validateRecovery() {
	$('#recovery-form-error').html('');		
	$('#recovery-email-error').html('');	

	if (foundEmpty('#recovery-form input')) {
		$('#recovery-form-error').html(ERR_FOUND_EMPTY);			
		return false;
	}
	var email = $('#recovery-email').val().trim();
	if (!validateEmail(email)) {
		$('#recovery-email-error').html(ERR_INVALID_EMAIL);
		return false;
	}
	return true;
}

function validatePasswordUpdate() {
	$('#passwordUpdate-form-error').html('');		
	$('#passwordUpdate-passconf-error').html('');	
	
	if (foundEmpty('#passwordUpdate-form input')) {
		$('#passwordUpdate-form-error').html(ERR_FOUND_EMPTY);			
		return false;
	}

	var passconf = $('#passwordUpdate-passconf').val().trim();
	if (password != passconf) {
		$('#passwordUpdate-passconf-error').html(ERR_PASSWORD_MISMATCH);
		return false;
	}
	return true;
}

