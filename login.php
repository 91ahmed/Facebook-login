<!DOCTYPE html>
<html language='en'>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset='UTF-8'/>
		<title>Facebook Login</title>
		<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;800;900&display=swap" rel="stylesheet">
		<link rel='stylesheet' href='assets/css/style.css'/>
	</head>
	<body>
		<?php if(!isset($_SESSION['facebook_access_token'])): ?>
		
			<div class='facebook-login'>
				<p>click to login</p>
				<a href='<?= $facebook->getUserLoginUrl(); ?>' class='facebook-login-link'></a>
			</div>
			
		<?php else: ?>
			
			<div class="profile-content">
				<div class="profile-photo" style="background-image:url('https://graph.facebook.com/<?= $facebook->getUserData('id'); ?>/picture?type=large');"></div>
				<p><b>Hello,</b> <?= $facebook->getUserData('name'); ?></p>
				<a href="?logout=1&accesstoken=<?= $facebook->getUserAccessToken(); ?>" class="logout-btn">Logout</a>
			</div>

		<?php endif; ?>
	</body>
</html>