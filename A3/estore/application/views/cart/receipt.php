<?php
echo $content;
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
		newWindow.document.writeln('<?= $printable_content ?>');
		newWindow.document.close();
	}
$(function() {
	$('#print-receipt').click(printWindow);
});	

</script>
