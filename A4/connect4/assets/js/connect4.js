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

/* form validation functions */

function validateDate(month, year){
	var now = new Date();
	if (now.getFullYear() == year && now.getMonth() > month) return false;
	else if (now.getFullYear < year) return false;
	return true;	
}

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
function validateLogin(){
	$('#login-form-error').html('');			
	
	if (foundEmpty('#login-form input')) {
		$('#login-form-error').html('Please fill in all values.');			
		return false;
	}
	
	return true;
}

function validateRegistration(){
	$('#registration-form-error').html('');			
	$('#registration-password-error').html('');			
	$('#registration-passconf-error').html('');			
	$('#registration-email-error').html('');			

	if (foundEmpty('#registration-form input')) {
		$('#registration-form-error').html('Please fill in all values.');			
		return false;
	}

	var password = $('#registration-password').val().trim();
	if (password.length < 6 ) {
		$('#registration-password-error').html('Your password must be at least 6 characters in length.');
		return false;
	}
	var passconf = $('#registration-passconf').val().trim();
	if (password != passconf) {
		$('#registration-passconf-error').html('Your password confirmation must match your password.');
		return false;
	}
	var email = $('#registration-email').val().trim();
	if (!validateEmail(email)) {
		$('#registration-email-error').html('Please input a valid e-mail address.');
		return false;
	}
	
	return true;
}
