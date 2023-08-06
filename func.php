<?php
	// check for users already exists
	if(!function_exists('chckUsers')) {
		function chckUsers($_conn, $_uname, $_email) {
			$checkQuery = "SELECT uname, email FROM `users` 
			WHERE uname='{$_uname}' OR email='{$_email}'";
			$queryhandler = mysqli_query($_conn, $checkQuery);
			$rows = mysqli_num_rows($queryhandler);
			mysqli_free_result($queryhandler);
			return $rows;
		}
	}

	// check if name contains numbers
	if(!function_exists('validateName')) {
		function validateName($_name) {
			$isNumber = 0; // by default, string has no numbers which is 0 (TRUE)
			for( $i=0; $i<strlen($_name); $i++ ) {
				if( ctype_digit($_name[$i]) ) {
					$isNumber = 1; // if string contains numbers then 1 (FALSE)
					break;
				}
			}
			return $isNumber;
		}
	}

	// check if username is valid
	if(!function_exists('validateUsername')) {
		function validateUsername($_uname) {
			$isNumber = true;
			$isValidUsername = true;
			for( $i=0; $i<strlen($_uname); $i++ ) {
				if( ctype_alnum($_uname[$i]) ) {
					$isNumber = true;
				}else{
					$isNumber = false;
				}
			}

			$isValidUsername = ($isNumber === true) ? true : false;
			return $isValidUsername;
		}
	}

	// insert the record function
	if(!function_exists('insertRecord')) {
		function insertRecord($_conn, array $data) {
			$insrtQuery = "INSERT INTO `users`(`fname`, `lname`, `uname`, `email`, `pass`) VALUES ('{$data[0]}','{$data[1]}','{$data[2]}','{$data[3]}','{$data[4]}')";
			$insrtQueryHandler = mysqli_query($_conn, $insrtQuery);
			if($insrtQueryHandler){
				return true;
			}else{
				return false;
			}
			mysqli_free_result($insrtQueryHandler);
		}
	}

	// login function
	if(!function_exists('loginUser')) {
		function loginUser($_conn, $_email, $_pass) {
			$loginQuery = "SELECT * FROM `users` WHERE email='{$_email}' AND pass='$_pass'";
			$loginQueryHandler = mysqli_query($_conn, $loginQuery);
			$loginRows = mysqli_num_rows($loginQueryHandler);
			mysqli_free_result($loginQueryHandler);
			return $loginRows;
		}
	}

	// check if user exists, then only login
	if(!function_exists('chckUsersLogin')) {
		function chckUsersLogin($_conn, $_email) {
			$checkQuery = "SELECT email FROM `users` 
			WHERE email='{$_email}'";
			$queryhandler = mysqli_query($_conn, $checkQuery);
			$rows = mysqli_num_rows($queryhandler);
			mysqli_free_result($queryhandler);
			return $rows;
		}
	}

	// if login success fetch the name
	if(!function_exists('fetchName')) {
		function fetchName($_conn, $_email) {
			$nameQuery = "SELECT fname, lname, email FROM `users` WHERE email='{$_email}'";
			$nameQueryHandler = mysqli_query($_conn, $nameQuery);
			$results = mysqli_fetch_assoc($nameQueryHandler);
			$full_name = $results[ 'fname' ].' '.$results[ 'lname' ];
			mysqli_free_result($nameQueryHandler);
			return $full_name;
		}
	}
?>