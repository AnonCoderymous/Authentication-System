<?php
	session_start();
	if(isset($_SESSION[ 'isLoggedIn' ])){
		header('Location: welcome_page.php');
	}else{
		include 'header.php';
?>

<body>

	<section>
		<div class="form_area">
			<h1>Login to account</h1>
			<form name="LoginForm" autocomplete="on">
				<div class="errorMsgs"></div>
				<label for="email">Email</label>
				<input type="text" name="email" tag="email" id="email" placeholder="Email Address">
				<label for="password">Password</label>
				<input type="password" name="pass" tag="pass" id="password" placeholder="Password">
				<input type="submit" name="login" id="login" value="login">
				<div class="login_link_area">
					New user?
					<a href="index.php">SIGNUP</a>
				</div>
			</form>
		</div>
	</section>
	<script type="text/javascript" src="login_script.js" defer></script>
</body>
</html><?php } ?>
