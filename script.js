const form = document.forms[0],
inputs = document.querySelectorAll('input:not(#signup)'),
errorMsgArea = document.querySelector('.errorMsgs'),
username = document.querySelector('#username'),
password = document.querySelector('#password'),
confirm_password = document.querySelector('#confirm_password'),
email = document.querySelector('#email'),
signup_button = document.querySelector('form > input[type=submit]');

function containsNumbers(str) {
	var numberFormat = /[0-9]/;
	return numberFormat.test(str);
}

function changeInputOutlineDefault(_input) {
	_input.style.outline = '1px solid lightgrey'
}

function validateEmail(email) {
	var mailFormat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	return mailFormat.test(email);
}

function checkUsername(username) {
	var regexPattern =/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/;
	return regexPattern.test(username);
}

function insertErrorMsg(_input, _msg, _type, _msgtype) {
	_input.focus();
	switch(_type){
		case 'danger':
			_input.style.outline = '1px solid red';
			break;
		case 'warning':
			_input.style.outline = '1px solid gold';
			break;
		default:
			_input.style.outline = '1px solid lightgrey';
	}
	errorMsgArea.style.display = 'block';
	errorMsgArea.style.visibility = 'visible';
	if(_msgtype === 'TEXT') {
		errorMsgArea.innerText = _msg;
	}else {
		errorMsgArea.innerHTML = _msg;
	}
}

form.onsubmit = function() {
	return false;
}

signup_button.onclick = function() {
	for(let input of inputs) {
		if(input.value.trim() === '' || input.value.length <= 0) {
			setTimeout(function(){
				insertErrorMsg(input, `Please enter ${input.id.toUpperCase()}`, 'danger', 'TEXT');
			}, 1500);
			return;
		}else{
			changeInputOutlineDefault(input);
		}
	}

	for(let i=0; i<2; i++) {
		if(containsNumbers(inputs[i].value) === true) {
			setTimeout(function(){
				insertErrorMsg(inputs[i], `Name should not contain numbers.`, 'danger', 'TEXT');
			}, 1500);
			return;
		}else{
			changeInputOutlineDefault(inputs[i]);
		}
	}

	if(checkUsername(username.value) === false) {
		var msg = '<h3 style=\'color:black;\'>Invalid Username</h3>';
		msg += '<ul style=\'text-align:left; font-size:15px; list-style-type: none;\'>';
			msg += '<li>Username should be combination of numbers and letters.</li>';
			msg += '<li>Only letters or numbers will be considered invalid.</li>';
			msg += '<li>Special Characters are not allowed.</li>';
			msg += '<li>[!] Example: john007</li>';
		msg += '</ul>';
		setTimeout(function(){
			insertErrorMsg(username, msg, 'danger', 'HTML');
		}, 1500);
		return;
	}

	if(validateEmail(email.value) === false) {
		setTimeout(function(){
			insertErrorMsg(email, `Please enter valid email address.`, 'danger', 'TEXT');
		}, 1500);
		return;
	}

	if(password.value.length >= 6) {
		if(password.value !== confirm_password.value) {
			setTimeout(function(){
				insertErrorMsg(confirm_password, `Passwords not matched.`, 'danger', 'TEXT');
			}, 1500);
			return;
		}
	}else{
		setTimeout(function(){
			insertErrorMsg(password, `Password must be 6 characters long.`, 'danger', 'TEXT');
		}, 1500);
		return;
	}

	// make a request to server using XMLHttpRequest API
	if(window.XMLHttpRequest) {

		//prefill form data from form
		let formData = new FormData(document.forms.SignupForm);

		let xhr = new XMLHttpRequest();
		xhr.open('POST', 'signup.php');
		xhr.send(formData);

		//if the request gets completed.
		xhr.onload = () => {
			_response = JSON.parse(xhr.response);
			if(_response.error === true) {
				if(_response.isInput === true) {
					const selector = 'input[tag='+_response.input+']',
					error_input_field = document.querySelector(selector);
					setTimeout(function(){
						insertErrorMsg(error_input_field, _response.msg, 'danger', 'TEXT');
					}, 1500);
					return false;
				}else{
					setTimeout(function(){
						errorMsgArea.style.display = 'block';
						errorMsgArea.style.visibility = 'visible';
						errorMsgArea.innerText = _response.msg;
					}, 1500);
					return false;
				}
			} else if(_response.error === false) {
				setTimeout(function(){
					errorMsgArea.innerText = _response.msg;
					errorMsgArea.style.display = 'block';
					errorMsgArea.style.visibility = 'visible';
					errorMsgArea.style.backgroundColor = 'green';
				}, 1500);
				setTimeout(function(){
					window.location.href = 'home.php';
				}, 4000);
			} else {
				console.log(_response);
			}
		}

		//if error occurs due to network down or invalid URL.
		xhr.onerror = () => {
			window.alert(`Please check your network and try again later.`);
			return false;
		}

		//triggers periodically while response is being downloaded
		xhr.onprogress = () => {
			console.log(`Received ${xhr.loaded} of ${xhr.total}`);
		}
	}
}
