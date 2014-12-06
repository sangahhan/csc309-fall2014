<?php 
	if (count($users) > 1) {
		echo "<ul>";
		foreach ($users as $user) {
			if ($user->id != $currentUser->id) {	
				echo "<li>".anchor(site_url("arcade/invite?login=" . $user->login,$user->fullName()))."</li>";
			}
		}
		echo "</ul>";
	} else {
		echo "<p>There are no users available right now.</p>";
	}
?>