<?php
// view to show receipt

echo $content;
echo "<br />";
echo "<div>";
// if this is the first time this receipt has been viewed, there should be an email sent
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
<!-- actions for print button -->
<script>
	function printWindow(){
		var newWindow = window.open();
		newWindow.document.writeln('<?= $printable_content ?>');
		newWindow.document.close();
	}
$(function() {
	$('#print-receipt').click(printWindow);
});	

</script>
