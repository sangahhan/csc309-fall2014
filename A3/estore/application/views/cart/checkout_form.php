<h1>Payment</h1>

<?php
echo "<p>" . anchor(site_url('cart'),'Back to cart') . "</p>";

echo form_open('cart/checkout_summary', array('onSubmit' => 'return validateCreditCardExpiryDate()'));

echo form_label('Credit card number');
echo form_error('creditcard_number');
echo form_input( array(
	'name' => 'creditcard_number',
	'pattern' => '\d{16}',
	'title' => 'A card number must consist of 16 digits.',
	'x-moz-errormessage' => 'A card number must consist of 16 digits.',
	'required' => 'required'
));

echo "<p id=\"creditcard-expiry-error\"></p>";

$months = array(
	'01' => 'January',
	'02' => 'February',
	'03' => 'March',
	'04' => 'April',
	'05' => 'May',
	'06' => 'June',
	'07' => 'July',
	'08' => 'August',
	'09' => 'September',
	'10' => 'October',
	'11' => 'November',
	'12' => 'December',
);

$now = new DateTime("now");
$current_year = $now->format('Y');
echo form_label('Expiration month');
echo form_error('creditcard_month');
echo form_dropdown('month', $months, '01', 'id="creditcard-month"');

$years = array($current_year => $current_year);
for ($i = 1; $i <= 12; $i ++){
	$y = $current_year + $i;
	$years[$y] = $y;
}

echo form_label('Expiration year');
echo form_error('creditcard_year');
echo form_dropdown('year', $years, '2014', 'id="creditcard-year"');


echo form_submit(array(
	'name' => 'submit', 
	'value' => 'Proceed', 
	'class' => 'button'
));
echo form_close();
?>
