<?php
	session_start();
	include 'header.php';
	if(isset($_SESSION[ 'isAuthorized' ]) && isset($_SESSION[ 'name' ])) {
?>

<body>
	<section class="welcome">
		<div class="welcome_usr">Welcome <b><?php echo $_SESSION[ 'name' ]; ?></b></div>
		<div class="logout_usr"><a href="logout.php">Logout</a></div>
	</section>
</body>
</html>
<?php 
	} else {
		echo PHP_EOL;
		echo '<center>';
			echo PHP_EOL;
			echo '<div class="unauth_div">';
				echo PHP_EOL;
				echo '<h2>You are not logged in.</h2>';
				echo PHP_EOL;
				echo 'Alread a user? <a href="login.php">Login</a>';
				echo PHP_EOL;
				echo '<br/>';
				echo PHP_EOL;
				echo 'OR';
				echo PHP_EOL;
				echo '<br/>';
				echo PHP_EOL;
				echo 'New to the site? <a href="index.php">Sign up</a>';
				echo PHP_EOL;
			echo '</div>';
			echo PHP_EOL;
		echo '</center>';
	}
?>