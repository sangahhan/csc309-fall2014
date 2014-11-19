function validateDate(month, year){
	var now = new Date();
	if (now.getFullYear() == year && now.getMonth() > month) return false;
	else if (now.getFullYear < year) return false;
	return true;	
}

function validateCreditCardExpiryDate(form){
	var year = parseInt($('#creditcard-year').val());
	var month = parseInt($('#creditcard-month').val());
	if (!validateDate(month, year)){
		$('#creditcard-expiry-error').html('Please provide a non-expired credit card.');			
		return false;
	}
	
	$('#creditcard-expiry-error').html('');			
	return true;
}
