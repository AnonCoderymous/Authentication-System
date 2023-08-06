<?php
	//start session
	session_start();

	//make a response array
	$response = array('error' => false, 'msg' => '', 'isInput' => false, 'input' => '');

	//check request method
	if($_SERVER[ 'REQUEST_METHOD' ] === 'POST' && isset($_POST[ 'email' ])) {

		// check for empty FIELDS
		foreach($_POST as $key => $value) {
			if(empty($value)) {
				$response[ 'error' ] = true;
				$response[ 'isInput' ] = true;
				$response[ 'input' ] = $key;
				$response[ 'msg' ] = 'Form is missing some details.';
			}
		}

		// include database connection file and functions file
		include 'config.php';
		include 'func.php';

		// extract the data
		extract($_POST);

		//sanitizing the data from SQL Injection Attack
		$email = mysqli_real_escape_string($conn, $email);
		$pass = mysqli_real_escape_string($conn, $pass);

		// check whether entries exists in database
		if(chckUsersLogin($conn, $email) === 0) {
				$response[ 'error' ] = true;
				$response[ 'msg' ] = 'User with that email does not exists.';
		}else{
			// if user exists
			// then authenticate the user
			if(loginUser($conn, $email, md5($pass)) === 0) {
				$response[ 'error' ] = true;
				$response[ 'msg' ] = 'Incorrect username and password.';
			}else{
				$response[ 'msg' ] = 'Login Successfull.';
				$_SESSION[ 'isAuthorized' ] = true;
				$_SESSION[ 'name' ] = fetchName($conn, $email);
			}
		}

		echo json_encode($response, true);

		mysqli_close($conn);
	}

	exit;
?>
