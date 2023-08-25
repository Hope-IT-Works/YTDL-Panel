/*!
  * YTDL-Panel (https://github.com/Hope-IT-Works/YTDL-Panel)
  * Copyright 2023-2023 The YTDL-Panel Authors (https://github.com/Hope-IT-Works/YTDL-Panel/graphs/contributors)
  * Licensed under MIT (https://github.com/Hope-IT-Works/YTDL-Panel/blob/main/LICENSE)
  */

function YTDLPANEL_log(message) {
	if(message){
		console.log("[YTDL-Panel] "+message);
	}
}

function YTDLPANEL_error(message) {
	if(message){
		console.error("[YTDL-Panel] "+message);
	}
}

YTDLPANEL_log('Loaded');

function YTDLPANEL_onload(routine){
	switch(routine){
		case "start":
			YTDLPANEL_check_dependency('ytdl');
  			YTDLPANEL_check_dependency('ffmpeg');
			break;
		case "download":
			YTDLPANEL_add_downloadform_events();
			break;
		default:
			YTDLPANEL_error("Unknown onload routine.");
	}
}

function YTDLPANEL_get_request (url, callback){
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.responseType = 'json';
    xhr.onload = function() {
		var status = xhr.status;
		if (status === 200) {
			callback(null, xhr.response);
		} else {
			callback(status, xhr.response);
		}
    };
    YTDLPANEL_log('GET: ' + url);
    xhr.send();
}

function YTDLPANEL_check_dependency(dependency){
	let dependencies = ['ytdl', 'ffmpeg'];
	if(dependencies.includes(dependency)){
		let request_url = './api/?action=is_installed&data='+dependency;
		YTDLPANEL_get_request(request_url, function(err, response){
			let dependency_check_html = '';
			if(err === null && response.data !== null){
				dependency_check_html += '<ol class="list-group"><li class="list-group-item d-flex justify-content-between align-items-start">';
				dependency_check_html += '<div class="ms-2 me-auto"><div class="fw-bold">Installed</div>'+response.data.message+'</div></li>';
				dependency_check_html += '<li class="list-group-item d-flex justify-content-between align-items-start">';
				dependency_check_html += '<div class="ms-2 me-auto"><div class="fw-bold">Version</div>'+response.data.version+'</div></li></ol>';
			} else {
				dependency_check_html += '<div class="alert alert-danger d-flex align-items-center" role="alert">';
				dependency_check_html += '<i class="bi-exclamation-triangle-fill flex-shrink-0 me-2" role="img" aria-label="Danger:"></i>';
				dependency_check_html += '<div class="flex-grow-1">API Error: Request failed!</div><a class="btn btn-danger btn-sm" target="_blank" href="';
				dependency_check_html += request_url+'&gui=true">View Request</a></div>';
			}
			document.getElementById('dependency_check_'+dependency).innerHTML = dependency_check_html;
		});
	} else {
		YTDLPANEL_error("Unknown dependency check.");
	}
}

function YTDLPANEL_add_downloadform_events() {
	document.getElementById('InputDownloadURL').addEventListener('input', YTDLPANEL_check_downloadform);
	document.getElementById('InputChangeFormat').addEventListener('click', YTDLPANEL_change_format);
	document.getElementById('InputAudioOnly').addEventListener('change', YTDLPANEL_change_format);
}

function YTDLPANEL_check_downloadform() {
	let url_regex = /^(http|https):\/\/([a-zA-Z0-9\-._~%!$&\'()*+,;=:@\/]+)(:\d+)?(\/[a-zA-Z0-9\-._~%!$&\'()*+,;=:@\/]*)?(\?[a-zA-Z0-9\-._~%!$&\'()*+,;=:@\/?%=]*)?(#[a-zA-Z0-9\-._~%!$&\'()*+,;=:@\/]*)?$/;
	let InputDownloadURL = document.getElementById('InputDownloadURL');
	let InputFileNameTemplate = document.getElementById('InputFilenameTemplate');
	let InputAudioOnly = document.getElementById('InputAudioOnly');
	let InputChangeFormat = document.getElementById('InputChangeFormat');
	let InputSubmit = document.getElementById('InputSubmit');
	if(url_regex.test(InputDownloadURL.value)){
		InputFileNameTemplate.disabled = false;
		InputAudioOnly.disabled = false;
		InputChangeFormat.disabled = false;
		InputSubmit.disabled = false;
		InputDownloadURL.classList.remove("border","border-danger");
	} else {
		InputFileNameTemplate.disabled = true;
		InputAudioOnly.disabled = true;
		InputChangeFormat.disabled = true;
		InputSubmit.disabled = true;
		InputDownloadURL.classList.add("border","border-danger");
	}
}

function YTDLPANEL_change_format(){
	let DivChangeFormat = document.getElementById('DivChangeFormat');
	let InputDownloadURL = document.getElementById('InputDownloadURL');
	let InputAudioOnly = document.getElementById('InputAudioOnly');
	let InputSubmit = document.getElementById('InputSubmit');
	InputSubmit.disabled = true;
	let request_url = '../api/?action=get_formats&data='+InputDownloadURL.value;

	var format_select_html = '';
	format_select_html += '<button type="button" class="btn btn-secondary" id="InputChangeFormat" disabled>';
	format_select_html += '<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>';
	format_select_html += '<span role="status"> Loading formats...</span>';
	format_select_html += '</button>';

	DivChangeFormat.innerHTML = format_select_html;
	
	format_select_html = '<button type="button" class="btn btn-secondary" id="InputChangeFormat">Reload formats</button>';

	YTDLPANEL_get_request(request_url, function(err, response){
		if(err === null && response.data !== null){
			let formats = [];
			if(InputAudioOnly.checked){
				response.data.formats.forEach(function(format){
					if(format.audio_ext !== "none" && format.video_ext === "none"){
						formats.push(format);
					}
				});
			} else {
				formats = response.data.formats;
			}
			format_select_html += '<select class="form-select" name="InputFormatSelect" aria-label="Format Selection">';
			formats.forEach(function(format){
				format_select_html += '<option value="'+format.format_id+'">'+format.format+' | Audio: '+format.audio_ext+' | Video: '+format.video_ext+' | Extension: '+format.ext+'</option>';
			});
			format_select_html += '</select>';
		} else {
			if(err === null) {
				format_select_html += '<div class="alert alert-danger" role="alert">No formats found!</div>';
			} else {
				format_select_html += '<div class="alert alert-danger" role="alert">API request failed!</div>';
			}
		}
		DivChangeFormat.innerHTML = format_select_html;
		document.getElementById('InputChangeFormat').addEventListener('click', YTDLPANEL_change_format);
		InputSubmit.disabled = false;
	});
}