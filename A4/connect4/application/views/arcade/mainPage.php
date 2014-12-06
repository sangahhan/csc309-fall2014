
<!DOCTYPE html>

<html>
	
	<head>

	<script src="<?= js_url('jquery.min.js') ?>"></script>
	<script src="<?= js_url('jquery.timers.js') ?>"></script>
	<script>
		$(function(){
			$('#availableUsers').everyTime(500,function(){
					$('#availableUsers').load('<?= site_url('arcade/getAvailableUsers') ?>');
					$.getJSON('<?= site_url('arcade/getInvitation') ?>',function(data, text, jqZHR){
							if (data && data.invited) {
								var user=data.login;
								var time=data.time;
								if(confirm('Play ' + user)) 
									$.getJSON('<?= site_url('arcade/acceptInvitation')?>',function(data, text, jqZHR){
										if (data && data.status == 'success')
											window.location.href = '<?= site_url('board/index')?>'
									});
								else  
									$.post('<?= site_url('arcade/declineInvitation')?>');
							}
						});
				});
			});
	
	</script>
	</head> 
<body>  
	<h1>Connect 4</h1>

	<div>
	Hello <?= $user->fullName() ?>  <?= anchor(site_url('account/logout'),'(Logout)') ?>  <?= anchor(site_url('account/updatePasswordForm'),'(Change Password)') ?>
	</div>
	
<?php 
	if (isset($errmsg)) 
		echo "<p>$errmsg</p>";
?>
	<h2>Available Users</h2>
	<div id="availableUsers">
	</div>
	
	
	
</body>

</html>

