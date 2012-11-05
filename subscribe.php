<!DOCTYPE html>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link type="text/css" rel="stylesheet" href="css/reset.css" />
	<link type="text/css" rel="stylesheet" href="css/main.css" />

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="js/main.js"></script>

	<title>Cafe Diem</title>
</head>

<body>

	<div class="main" id="intro">
		<div class="left">
			<img src="images/logo-banner.gif" alt="" />
		</div>
		<div class="right">
			<div class="logo-quiz">
				<?php if(isset($_GET['reuired'])): ?>
					<p class="error">Both Your name and email are required</p>
				<?php endif; ?>
				<form name="subscribe" id="subscribe" action="controllers/user.php?a=create" method="post">
					<input type="text" name="name" placeholder="Full Name" />
					<input type="text" name="email" placeholder="Email" />
				</form>
			</div>

			<div class="link-btn">
				<a href="subscribe.php" class="subscribe">Let's Go</a>
			</div>
		</div>
		<div class="clear"></div>
	</div>

</body>

</html>