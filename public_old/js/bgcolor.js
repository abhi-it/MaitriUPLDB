//var fontSize = 100;
jQuery(document).ready(function(){
			if(_getCookie("bgcolor") != null){
				var bgcolor = _getCookie("bgcolor");
			}
			
			$('body').css('background-color', bgcolor);	
			$('#mainbackground').css('background-color', bgcolor);	
			$('#log').css('background-color',bgcolor);
});
function _getCookie (name) {
	var arg = name + "=";
	var alen = arg.length;
	var clen = document.cookie.length;
	var i = 0;
	while (i < clen) {
		var j = i + alen;
		if (document.cookie.substring(i, j) == arg) {
			return _getCookieVal (j);
		}
		i = document.cookie.indexOf(" ", i) + 1;
		if (i == 0) 
			break;
	}
	return null;
}
function _deleteCookie (name,path,domain) {
	if (_getCookie(name)) {
		document.cookie = name + "=" +
		((path) ? "; path=" + path : "") +
		((domain) ? "; domain=" + domain : "") +
		"; expires=Thu, 01-Jan-70 00:00:01 GMT";
	}
}
function _setCookie (name,value,expires,path,domain,secure) {
	var vurl = true;
	if(path != '' && path != undefined){
		vurl = validUrl(path);
	}
	if(jQuery.type(name) == "string" &&  vurl){
		document.cookie = name + "=" + escape (value) +
		((expires) ? "; expires=" + expires.toGMTString() : "") +
		((path) ? "; path=" + path : "") +
		((domain) ? "; domain=" + domain : "") +
		((secure) ? "; secure" : "");
	}
}
function _getCookieVal (offset) {
	var endstr = document.cookie.indexOf (";", offset);
	if (endstr == -1) { endstr = document.cookie.length; }
	return unescape(document.cookie.substring(offset, endstr));
}
/*********Font size resize**********/

function changeBodyBg(bodycolor){

		if(bodycolor == "green"){
					var bgcolor='green'  
			}
			if(bodycolor == "orange"){
					var bgcolor='#ff9933'  
			}
			if(bodycolor == "pink"){
					var bgcolor='#ff336be8'  
			}
		if(bodycolor == "red"){
					var bgcolor='red'  
		   }
		if(bodycolor == "blue"){
				var bgcolor='#02486d'
			}
		if(bodycolor == "brown"){
					var bgcolor='brown'  
			}
		$('body').css('background-color', bgcolor);	
		$('#mainbackground').css('background-color', bgcolor);	
		$('#log').css('background-color',bgcolor);	
	_setCookie("bgcolor",bgcolor);
 
} 
