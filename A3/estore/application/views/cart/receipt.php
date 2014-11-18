<?php
$printable_content = "";
$printable_content .= "<h1>Receipt for Order #" . $order_details->id . "</h1>";
$printable_content .= "<h2>Customer Information</h2>";
$printable_content .= "<div class=\"cart-cell\">";
$printable_content .= "<div class=\"info\">";
$printable_content .= "<p><strong>Name: </strong>" . $customer->first . " " . $customer->last . "<p>";
$printable_content .= "<p><strong>E-Mail Address: </strong>" . $customer->email . "</p>";
$printable_content .= "<p><strong>Username: </strong>" . $customer->login . "</p>";
$printable_content .= "</div>";
$printable_content .= "<div class=\"clearfix\"></div>";
$printable_content .= "</div>";

if (count($items)){
	$printable_content .= "<h2>Items</h2>";
	foreach ($items as $item) {
		$printable_content .= "<div class=\"cart-cell\">";
		$printable_content .= "<div class=\"info\">";
		$printable_content .= "<h3>" . $item->name . "</h3>";
		$printable_content .= "<p><strong>Product ID: </strong>" . $item->product_id . "</p>";
		$printable_content .= "<p><strong>Unit Price: </strong>$" . $item->price . "</p>";
		$printable_content .= "</div>";
		$printable_content .= "<div class=\"quantity-control\">";
		$printable_content .= "<p><strong>Quantity: </strong>" . $item->quantity . "</p>";
		$printable_content .= "<p><strong>Subtotal: </strong>$" . $item->quantity * $item->price . "</p>";
		$printable_content .= "</div>";
		$printable_content .= "<div class=\"clearfix\"></div>";
		$printable_content .= "</div>";
	}
	$printable_content .= "<div id=\"cart-total\"><div id=\"summary-total\"><strong>Total: </strong>$" . $order_details->total . "</div><div class=\"clearfix\"></div></div>";
}

$printable_content .= "<h2>Payment Information</h2>";
$printable_content .= "<div class=\"cart-cell\">";
$printable_content .= "<div class=\"info\">";
$printable_content .= "<p><strong>Credit card number: </strong>" . $order_details->creditcard_number . "<p>";
$printable_content .= "<p><strong>Expiry date: </strong>" . $order_details->creditcard_month . "/" . $order_details->creditcard_year . "</p>";
$printable_content .= "</div>";
$printable_content .= "<div class=\"clearfix\"></div>";
$printable_content .= "</div>";
echo $printable_content;
echo "<br />";
echo "<div>";
if ($this->session->userdata('email_sent')) {
	echo "<p>This receipt has been sent to your e-mail address.</p>";
	$this->session->unset_userdata('email_sent');	
}
echo form_input(array (
		'type' => 'button',
		'name' => 'print',
		'class' => 'button',
		'id' => 'print-receipt',
		)
	, 'Print');
echo "</div>";
?>

<script>
	function printWindow(){
		var newWindow = window.open();
		newWindow.document.writeln('<html><head>' +
			'<title>eStore: Receipt for Order #<?= $order_details->id ?></title>' +
			'<style>' + 
			'body { font-family: Arial,"Helvetica Neue",Helvetica,sans-serif; color: black; background: white;}' + 
			'header {font-size: 3em; font-weight: bold; }' +
			'@media print { .print-omit {display: none !important;} }' +
			'.cart-cell {border: 1px solid black; margin: 0 0 1em 0; padding: 0.5em; }' + 
			'.cart-cell p, .cart-cell h3 {margin: 0.2em;}' + 
			'.cart-cell .info { float: left; }' + 
			'.cart-cell .quantity-control, #cart-total #summary-total { float: right; }' + 
			'.clearfix { clear: both; }' + 
			'</style>' + 
			'</head><body>' + 
			'<header>eStore</header>' + 
			'<p class="print-omit"><input type="button" onclick="window.print()" value="Print" /> <input type="button" onclick="window.close()" value="Close Window" /></p>' + 
			'<?= $printable_content ?>' + 
			'</body></html>'
		);
		newWindow.document.close();
	}
$(function() {
	$('#print-receipt').click(printWindow);
});	

</script>
