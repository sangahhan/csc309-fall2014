function validateDate(month, year){
	var now = new Date();
	if (now.getFullYear() == year && now.getMonth() > month) return false;
	else if (now.getFullYear < year) return false;
	return true;	
}

function validateEmail(email){
	return !!email.match(/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/);	
}

function validateCreditCard(){
	var year = parseInt($('#creditcard-year').val());
	var month = parseInt($('#creditcard-month').val());
	var number = $('#creditcard-number').val();

	$('#creditcard-expiry-error').html('');			
	$('#creditcard-number-error').html('');			
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
	var password = $('#registration-password').val();
	var passconf = $('#registration-passconf').val();
	var email = $('#registration-email').val();

	$('#registration-password-error').html('');			
	$('#registration-passconf-error').html('');			
	$('#registration-email-error').html('');			
	if (password.length < 6 ) {
		$('#registration-password-error').html('Your password must be at least 6 characters in length.');
		return false;
	}
	if (password != passconf) {
		$('#registration-passconf-error').html('Your password confirmation must match your password.');
		return false;
	}
	if (!validateEmail(email)) {
		$('#registration-email-error').html('Please input a valid e-mail address.');
		return false;
	}
	
	return true;
}
function validateProduct(){
	var price = $('#product-price').val();
	var photo = $('input[type="file"]');

	$('#product-price-error').html('');			
	if (!$.isNumeric(price)){
		$('#product-price-error').html('Please enter a numeric value for price.');			
		return false;
	}
	if (photo.length) {
		$('#product-photo-error').html('');			
		if (!photo.val()) {
			$('#product-photo-error').html('Please upload a file.');
			return false;		
		}
	}
	return true; 
}
