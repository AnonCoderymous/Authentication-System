const form = document.forms[0],
inputs = document.querySelectorAll('input:not(#login)'),
errorMsgArea = document.querySelector('.errorMsgs'),
email = document.querySelector('#email'),
password = document.querySelector('#password'),
login_button = document.querySelector('form > input[type=submit]');

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

function changeInputOutlineDefault(_input) {
	_input.style.outline = '1px solid lightgrey'
}

form.onsubmit = function() {
	return false;
}

login_button.onclick = function() {
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

	if(window.XMLHttpRequest) {

		//prefill form data from form
		let formData = new FormData(document.forms.LoginForm);

		let xhr = new XMLHttpRequest();
		xhr.open('POST', 'auth.php');
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
