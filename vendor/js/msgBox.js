// Message Box/ msgbox
var msgBoxElement = document.getElementById('message-box');
var msgBoxOverLayElement = document.querySelector('.message-box__overlay');
var msgBoxButtonElement = document.querySelector('.message-body__button');
// style: success, fail
function ShowMsgBox(title, content, button, style = "success", func) {
	msgBoxElement.classList.add('show-box');

	msgBoxElement.querySelector('.message-body').classList = ['message-body'];

	msgBoxElement.querySelector('.message-body').classList.add(style);
	msgBoxElement.querySelector('.message-body__title').innerHTML = title;
	msgBoxElement.querySelector('.message-body__content').innerHTML = content;
	msgBoxElement.querySelector('.message-body__button').innerHTML = button;
	msgBoxOverLayElement.onclick = function() {
		if (typeof func == 'function')
			func();
		else
			msgBoxElement.classList.remove('show-box');
	}

	msgBoxButtonElement.onclick = function() {
		if (typeof func == 'function')
			func();
		else
			msgBoxElement.classList.remove('show-box');
	}
}


var iconData = new Array();
// iconData['success'] = '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check-circle" class="svg-inline--fa fa-check-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"></path></svg>';
iconData['success'] = '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" class="svg-inline--fa fa-check fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>';
iconData['info'] = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="18px" height="18px"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>';
iconData['waring'] = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="18px" height="18px"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/></svg>';
iconData['danger'] = '<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 17.357 17.357" style="enable-background:new 0 0 17.357 17.357;" xml:space="preserve"><g><path style="fill:#fff;" d="M15.724,4.232c-0.21-0.19-0.511-0.25-0.776-0.157c-0.004,0.002-1.027,0.143-1.027,0.143	s-3.198-0.65-4.529-3.749C9.273,0.192,9.004,0.009,8.703,0C8.379-0.008,8.12,0.158,7.986,0.428c-1.562,3.132-4.64,3.79-4.64,3.79 L2.439,4.086C2.17,3.979,1.864,4.03,1.645,4.22C1.426,4.408,1.331,4.703,1.398,4.985c0.491,2.067,3.153,12.372,7.281,12.372 S15.468,7.052,15.96,4.985C16.026,4.71,15.933,4.422,15.724,4.232z M11.741,11.232c0.112,0.111,0.112,0.291,0,0.402l-1.008,1.008 c-0.111,0.111-0.291,0.111-0.401,0L8.679,10.99l-1.652,1.652c-0.112,0.111-0.291,0.111-0.402,0l-1.008-1.008 c-0.111-0.111-0.111-0.291,0-0.402l1.652-1.651L5.617,7.928c-0.111-0.111-0.111-0.291,0-0.401l1.008-1.008 c0.111-0.111,0.29-0.111,0.402,0L8.679,8.17l1.652-1.652c0.11-0.111,0.29-0.11,0.401,0l1.008,1.009c0.112,0.11,0.112,0.29,0,0.401 l-1.652,1.653L11.741,11.232z"/></g></svg>';


var msgModalElement = document.getElementById('message-modal');
function ShowMsgModal(title, content, timeout = 3, style = "success") {
	var html = '<div class="msg-body">';
		html += '<div class="timeout" style="animation: hidden linear '+timeout+'s"></div>';
		html += '<div class="img-icon"></div>';
		html += '<div class="body-main">';
		html += '<div class="main-title"></div>';
		html += '<div class="main-content"></div>';
		html += '</div></div>';

	$('#message-modal').append(html);
	var el = msgModalElement.querySelector('.msg-body:last-child');

	el.querySelector('.img-icon').innerHTML += iconData[style];
	el.querySelector('.body-main .main-title').innerHTML += title;
	el.querySelector('.body-main .main-content').innerHTML += content;
	el.classList.add(style);

	el.onclick = function() {
		HideMsgModal(this, 0);
	}

	HideMsgModal(el, timeout);
}

function HideMsgModal(element, timeout) {
	setTimeout(function(){
		element.classList.add('hidden');
		element.setAttribute('style', '--height-max: '+element.clientHeight+'px');
		setTimeout(function(){
			element.remove();
		}, 300)
	}, timeout*1000)
}

function ShowQuestionBox(content, func) {
	var html = '<div class="qs-body">';
		html += '<div class="qs-content">'+content+'</div>';
		html += '<div class="qs-btn-group"><div class="btn-apply">Đồng ý</div><div class="btn-cancel">Hủy</div></div>';
		html += '</div>';

	$('#question-box').append(html);
	element = document.getElementById('question-box');
	
	element.classList.add('show');

	element.querySelector('.btn-apply').onclick = function() {
		func();
		element.querySelector('.qs-body').remove();
		element.classList.remove('show');
	}

	element.querySelector('.btn-cancel').onclick = function() {
		element.querySelector('.qs-body').remove();
		element.classList.remove('show');
	}

}

function ShowInputBox(option) {
	var messageInput = document.getElementById('message-input-box');
	var inputElement = messageInput.querySelector('.msgi-input');
	var selectElement = messageInput.querySelector('.msgi-option');
	messageInput.querySelector('.msgi-title').innerText = option.title;
	selectElement.innerHTML = "";
	for (var key in option.selectOption) {
		$('#message-input-box .msgi-option').append('<option value="'+key+'">'+option.selectOption[key]+'</option>');
	}

	option.input = option.input ? true : false;
	if (option.input == true)
		inputElement.style.display = 'block';
	else 
		inputElement.style.display = 'none';

	messageInput.classList.add('show');

	selectElement.onchange = function() {
		if (option.input == true){
			inputElement.style.display = 'block';
		} else if (selectElement.value == 'input') {
			inputElement.style.display = 'block';
		} else {
			inputElement.style.display = 'none';
		}
	}

	messageInput.querySelector('.msgi-btn-apply').onclick = function() {
		var value = "";
		if (selectElement.value != 'input')
			value = selectElement.value;
		else
			value = inputElement.value;
		option.func(value);
		messageInput.classList.remove('show');
	}

	messageInput.querySelector('.msgi-btn-cancel').onclick = function() {
		messageInput.classList.remove('show');
	}
}