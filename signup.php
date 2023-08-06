<?php
	//start session
	session_start();

	//make a response array
	$response = array('error' => false, 'msg' => '', 'isInput' => false, 'input' => '');

	//check request method
	if($_SERVER[ 'REQUEST_METHOD' ] === 'POST' && isset($_POST[ 'fname' ])) {

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
		$fname = mysqli_real_escape_string($conn, $fname);
		$lname = mysqli_real_escape_string($conn, $lname);
		$uname = mysqli_real_escape_string($conn, $uname);
		$email = mysqli_real_escape_string($conn, $email);
		$pass = mysqli_real_escape_string($conn, $pass);
		$conf_pass = mysqli_real_escape_string($conn, $conf_pass);

		// check if name contains a number
		if(validateName($fname) === 1) {
			$response[ 'error' ] = true;
			$response[ 'isInput' ] = true;
			$response[ 'input' ] = 'fname';
			$response[ 'msg' ] = 'First name should not contain numbers.';
		}

		// check if first name is valid
		if(validateName($lname) === 1) {
			$response[ 'error' ] = true;
			$response[ 'isInput' ] = true;
			$response[ 'input' ] = 'lname';
			$response[ 'msg' ] = 'Last name should not contain numbers.';
		}

		// check if last name is valid
		if(validateUsername($uname) === false) {
			$response[ 'error' ] = true;
			$response[ 'isInput' ] = true;
			$response[ 'input' ] = 'uname';
			$response[ 'msg' ] = 'Invalid username.';
		}

		// check if email is valid or not
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$response[ 'error' ] = true;
			$response[ 'isInput' ] = true;
			$response[ 'input' ] = 'email';
			$response[ 'msg' ] = 'Please enter valid email address.';
		}

		//check if password(s) are valid
		if(strlen($pass) < 6) {
			$response[ 'error' ] = true;
			$response[ 'isInput' ] = true;
			$response[ 'input' ] = 'pass';
			$response[ 'msg' ] = 'Password must be 6 characters long.';
		}else{
			if($pass !== $conf_pass) {
				$response[ 'error' ] = true;
				$response[ 'isInput' ] = true;
				$response[ 'input' ] = 'conf_pass';
				$response[ 'msg' ] = 'Passwords not matched.';
			}
		}

		// check whether entries exists in database
		if(chckUsers($conn, $uname, $email) === 0) {
			$data=array($fname, $lname, $uname, $email, md5($pass));
			if(insertRecord($conn, $data) === true) {
				$response[ 'msg' ] = 'Thank you for sign in up!';
				$_SESSION[ 'isAuthorized' ] = true;
				$_SESSION[ 'name' ] = $fname.' '.$lname;
			}
		}else{
			// if user exists
			// show user exists prompt
			$response[ 'error' ] = true;
			$response[ 'msg' ] = 'User already exists with the email OR username.';
		}

		echo json_encode($response, true);

		mysqli_close($conn);
	}

	exit;
?>