/*========================================================
			HELPERS
==========================================================*/

if (WC instanceof Object === false) {
	var WC = {};
}

// add helpers object to NS
WC.helper = {};

// parse into JSON string
WC.helper.parse_json = function (d) {
	return $.parseJSON(d);
};

// trim input string
WC.helper.trim_string = function (str, bool) {
	// bool false = trim left right only
	if (bool === false) {
		return str.trim();
	}
	// bool true = clean within string too, 
	if (bool === true) {
		var str_s1 = str.trim(),
				str_s2 = str_s1.replace(/\s*/g, "");
		return str_s2;		
	}
};

// trim input comas
WC.helper.trim_comas = function (str) {
	return str.replace(/\,+/g, ",");
};