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
function validateCreditCard(){
	$('#checkout-form-error').html('');			
	$('#creditcard-expiry-error').html('');			
	$('#creditcard-number-error').html('');			
	
	if (foundEmpty('#checkout-form input, #checkout-form select')) {
		$('#checkout-form-error').html('Please fill in all values.');			
		return false;
	}
	var year = parseInt($('#creditcard-year').val().trim());
	var month = parseInt($('#creditcard-month').val().trim());
	var number = $('#creditcard-number').val().trim();
	if (number.length != 16 || !number.match(/\d{16}/)){
		$('#creditcard-number-error').html('Please provide a valid credit card number.');			
		return false;
	} 
	if (!validateDate(month, year)){
		$('#creditcard-expiry-error').html('Please provide a non-expired credit card.');			
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
function validateProduct(){
	$('#product-form-error').html('');			
	$('#product-price-error').html('');	

	if (foundEmpty('#product-form input, #product-form textarea')) {
		$('#product-form-error').html('Please fill in all values.');			
		return false;
	}

	var price = $('#product-price').val();

	if (!$.isNumeric(price)){
		$('#product-price-error').html('Please enter a numeric value for price.');			
		return false;
	}
	return true; 
}
