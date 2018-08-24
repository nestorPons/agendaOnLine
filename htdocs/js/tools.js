var tools = {
	template : function(obj, url, callback){
		if ($.isEmpty(obj.template)){
			var data = {
				controller: 'templates',
				object: url
			}
			$.post(INDEX, data,function (html, textStatus, jqXHR) {
				obj.$template = $('<div />').append( html ).children()
				typeof callback == "function" && callback(html);
			},'html'); 
		} else {
			typeof callback == "function" && callback(obj);
		}
	},
	urlBase64ToUint8Array: function (base64String) {
		var padding = '='.repeat((4 - base64String.length % 4) % 4);
		var base64 = (base64String + padding)
		.replace(/\-/g, '+')
		.replace(/_/g, '/');

		var rawData = window.atob(base64);
		var outputArray = new Uint8Array(rawData.length);

		for (var i = 0; i < rawData.length; ++i) {
		outputArray[i] = rawData.charCodeAt(i);
		}
		return outputArray;
	},
 }