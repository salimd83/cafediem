<!DOCTYPE html>

<html>

<head profile="http://www.w3.org/2005/10/profile">
<link rel="icon" 
      type="image/png" 
      href="./favicon.png">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link type="text/css" rel="stylesheet" href="css/reset.css" />
	<link type="text/css" rel="stylesheet" href="css/main.css" />

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="js/main.js"></script>

	<link rel="shortcut icon" href="./favicon.png" />

	<title>Cafe Diem</title>
</head>

<body>

	<div class="main" id="intro">
		<div class="left">
			<img src="images/logo-banner.gif" alt="" />
		</div>
		<div class="right">
			<div class="logo-quiz">
				<?php if(isset($_GET['required'])): ?>
					<p class="error2">Both Your name and email are required</p>
				<?php endif; ?>
				<?php if(isset($_GET['hasubmit'])): ?>
					<p class="error2">Your email is already registered</p>
				<?php endif; ?>
				<form name="subscribe" id="subscribe" action="controllers/user.php?a=create" method="post">
					<div><label for="name">Full Name*</label><input type="text" name="name" /></div>
					<div><label for="email">Email*</label><input type="text" name="email" /></div>
					<div><label for="mobile">Mobile Number*</label><input type="text" name="mobile" /></div>
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