<?php
	session_start();
	if(isset($_SESSION[ 'isLoggedIn' ])){
		header('Location: home.php');
	}else{
		include 'header.php';
?>

<body>

	<section>
		<div class="form_area">
			<h1>Create an account</h1>
			<form name="SignupForm" autocomplete="on">
				<div class="errorMsgs"></div>
				<div class="name">
					<div class="fname_flds">
						<label for="fname">First Name</label>
						<input type="text" name="fname" tag="fname" id="first name" placeholder="First Name">
					</div>
					<div class="lname_flds">
						<label for="lname">Last Name</label>
						<input type="text" name="lname" tag="lname" id="last name" placeholder="Last Name">
					</div>
				</div>
				<label for="username">Username</label>
				<input type="text" name="uname" tag="uname" id="username" placeholder="Username">
				<label for="email">Email</label>
				<input type="text" name="email" tag="email" id="email" placeholder="Email Address">
				<label for="password">Password</label>
				<input type="password" name="pass" tag="pass" id="password" placeholder="Password">
				<label for="conf_pass">Confirm Password</label>
				<input type="password" name="conf_pass" tag="conf_pass" id="confirm_password" placeholder="Confirm Password">
				<input type="submit" name="signup" id="signup" value="sign up">
				<div class="login_link_area">
					Already a user?
					<a href="login.php">LOGIN</a>
				</div>
			</form>
		</div>
	</section>
	<script type="text/javascript" src="script.js" defer></script>
</body>
</html><?php } ?>