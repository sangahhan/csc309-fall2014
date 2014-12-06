<?php 
// generic error view
?>
<h2><?php echo $title ?></h2>

<?php
// spit the given error message and title
echo "<p>" . $err_msg . "  " . anchor($return_link,'Return to ' . $return_phrase) . "</p>";
?>
