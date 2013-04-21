"use strict";
/*
 * CONTROLLER
 *
 */
/*========================================================
			NS Namespace
==========================================================*/
var WC = {}
// add database object to NS
WC.db = {};
// add forms object to NS
WC.forms = {};
// add helpers object to NS
WC.helper = {};



/*========================================================
			HELPERS
==========================================================*/

/**---------------------------
		parse JSON
 ---------------------------**/

WC.helper.parse_json = function (d) {
	return $.parseJSON(d);
};

/**---------------------------
		clean up input string
 ---------------------------**/

WC.helper.String_serializer = function (d) {
	var rex = /\s+/g,
		 trimmed = "";
	// trim off spaces		
	trimmed = d.trim();
	// remove spaces in comma separated input
	if (rex.test(trimmed)) {
		trimmed = trimmed.replace(rex, "");
	}
	return trimmed;
};

// accepts one form element only
WC.helper.serializer = function (d, name, serialize) {	
	var rex = /\s+/g,
	
	// serialize
	do_serialize = function (str) {
		// return searlized string
		return encodeURIComponent(name) + "=" + encodeURIComponent(str);
	},
	
	// prepare string
	prep_string = function (string) {
		var cleanString = "";
		// validate type input
		if (typeof string !== 'string') {
			return null;
		} else {
			cleanString = string.trim();
			// remove blanks
			if (rex.test(cleanString)) {
				cleanString = cleanStr.replace(rex, "");
			}
			// seralize string for submission
			if (serialize === true) {
				cleanString = do_serialize(cleanString);
			}
			// return cleaned string
			return cleanString;
		}
	};
	return prep_string(d);
};

/*========================================================
			DATABASE
==========================================================*/

/**---------------------------
		Model – Database
 ---------------------------**/

WC.helper.parse_json = function (d) {
	return $.parseJSON(d);
};

WC.helper.trim_string = function (d) {
	var rex = /\s*/g,
		 trimmed = d.trim();
	trimmed = trimmed.replace(rex, "");
};

WC.db.model = {
	
	// GET request
	/*		
	CallDB: function(ide, form) {
		// identifies which form was submitted
		this.caller = ide;
		// DB ajax call
		this.ajax = function() {
			$.ajax({
				type: "GET",
				url: '../application/modules/db/controllers/wc-db-control.inc.php',
				//data: form.serializeArray(),
				data: form.serialize(),
				success: function (data) {
					var res = WC.db.model.ready_data(data);	
					WC.db.controller.caller(res);
				}
			});
		}
	},
	*/
	// POST request
	// make DB call
	callDB: function (ide, form) {
		var fields = form.serialize(),
			 _this = this;	
		console.log('serialized fields :', fields);
		
		// AJAX call
		$.ajax({
			type: "POST",
			url: '../application/modules/db/controllers/wc-db-control.inc.php',
			//data: form.serializeArray(),
			data: fields,
			success: function (data) {
				alert(data)
				var res = _this.ready_data(data);	
				WC.db.controller.caller(ide, res);
			}
		});
	},

	// form table from result
	ready_data: function (json_data) {
		// check for string type
		if (typeof json_data !== 'string') {
			return;
		}
	
		var a, 
			 b,
			 res_string = "",
			 res_arr = [],
			 ids = "",
			 js_res_array = [];
	
		//remove brackets		
		res_string = json_data.replace(/\[(.*)\]/g, '$1');
		// separate object entities
		res_string = res_string.replace(/\}(,){/g, '}|{');
		// split into array
		res_arr = res_string.split('|');
		// prepare javascript results object
		
		for (a = 0; a < res_arr.length; a += 1) {
			// if results array is empty assign error message
			// stop loop
			if (res_arr[a] === "") {
				js_res_array[0] = { error: "Sorry, no result found" };
				ids = "0";
				break;
			}
			// convert JSON to javascript and push into results array
			b = WC.helper.parse_json(res_arr[a]);
			js_res_array.push(b);
			//collect used ids
			ids = (a < 1) ? ids + b['id'] : ids + ", " + b['id'];
		}

		// return results object
		// returns [ results object with array and used ids string ]
	return { result:js_res_array, ids_used: ids };
	}
};



/**---------------------------
		View – Database
 ---------------------------**/
WC.db.view = {
	// results containers
	container: $('#result > tbody'),
	ids_container: $('#ids_used'),
	
	// display confirmation message
	warn_confirm: function() {
		return confirm('Do you know what you are doing?');
	},
	
	// display user update message
	send_user_feedback: function(data) {
		// call either error or status
		var stat = data[0].error || data[0].status;
		if (typeof stat === 'string' && stat !== "") {
			// create message container
			var o = $('<div id="user_feedback" class="gradient-yellow-rgb"></div>');
			o.text( stat );
			// show user feedback and fade out
			o.hide().appendTo($('body')).fadeIn(500).delay(1000).fadeOut(500);
		}
	},
	
	// prepare table for results
	prep_table : function (data) {	
		var a,
			 b,
			 // results db array
			 db_res_arr = data.result,
			 error = db_res_arr[0].error,
			 rows = "";
		
		// if an error message is present return the error here
		if (error) {
			return rows += "<tr>"+"<td>"+error+"</td></tr>";
		}
		
		// id no error loop through results rows		
		for (a = 0; a < db_res_arr.length; a += 1) {
			// get current position
			b = db_res_arr[a];
			// js_array from model containes DB returned rows
			rows += "<tr>"+"<td>"+
				b['id']+"</td><td>"+
				b['german']+"</td><td>"+
				b['english']+"</td><td>"+
				b['french']+"</td><td>"+
				b['dutch']+"</td><td>"+
				b['japanese']+"</td><td>"+
				b['italian']+"</td><td>"+
				b['spanish']+"</td><td>"+
				b['comments']+"</td><td>"+
				b['updated']+"</td></tr>";
		}
		// clean up
		db_res_arr = null;
		
		// return results rows
		return rows;
	},
	// write results to results field
	update: function (ide, data) {
		if (typeof ide !== 'string') {
			return;
		}
		switch (ide) {
			case 'search':
				var rows = this.prep_table(data),
					 ids = data['ids_used'];
				this.container.html(rows);
				this.ids_container.val(ids);
				this.send_user_feedback(data.result);	
				break;
					
			case 'retrieve':
				this.update_for_edit(data.result);
				this.send_user_feedback(data.result);
				break;
			
			case 'edit':
				this.send_user_feedback(data.result);
				break;			
					
			case 'delete':
				this.update_for_edit(data.result);
				break;
		}
	},
	
	// update update fields
	update_for_edit: function (data) {
		// data is input as Array [ length = 1 ]
		$('#id_to_edit').val(data[0].id);
		$('#edit_german').val(data[0].german);
		$('#edit_english').val(data[0].english);
		$('#edit_french').val(data[0].french);
		$('#edit_dutch').val(data[0].dutch);
		$('#edit_spanish').val(data[0].spanish);
		$('#edit_italian').val(data[0].italian);
		$('#edit_japanese').val(data[0].japanese);
		$('#edit_comments').val(data[0].comments);
	},
	
	// showhide form
	addSpinner: function (obj) {
		// accept position object
		$('#ajax_spinner').show();	
	},
	
	// remove spinner
	removeSpinner: function () {
		$('#ajax_spinner').hide();	
	}
};

/**---------------------------
		Controller – Database
 ---------------------------**/
// JSON
WC.db.controller = {
	// model calls caller when Ajax results received
	caller: function (ide, res) {
		WC.db.view.update(ide, res);
		WC.db.view.removeSpinner();		
	},
	
	// refresher trigger
	do_search: (function () {
		$('#entry_refresh').on('click', function () {
			console.log('db.conroller: refresh clicked');
			// call db and store result
			// finder identifies as search database
			WC.db.model.callDB( 'search', $('#form_search') );
			WC.db.view.addSpinner( {'position':'inside'} );	
		});
	})(),
	
	// submit entries from edit entry form
	do_edit: function () {
		$('#go_edit').on('click', function () {
			// calll warning and confirm user input
			if ( WC.db.view.warn_confirm() ) {
				WC.db.model.callDB( 'edit', $('#form_edit_entry') );
				WC.db.view.addSpinner( {'position':'ontop'} );		
			}
		});
	}(),
	
	// retrieve data from DB for editing
	retrieve_for_edit: function () {
		$('#id_to_edit').on('blur', function () {
			// do not submit the radio buttons to avoid conflict when submitting entire form for
			// when updating Database
			var form = $('#form_edit_entry > input').not('input[type=radio]');
			WC.db.model.callDB( 'retrieve', form);
			WC.db.view.addSpinner( {'position':'ontop'} );		
		});
	}()

};


/*========================================================
			FORMS
==========================================================*/

/**---------------------------
		View – Forms
 ---------------------------**/
WC.forms.view = {
	
	// data editor form
	db_entry_edit_form: {
		// form container
		container: $('#form_edit_entry'),
		// showhide form
		show_hide: function () {
			this.container.slideToggle(350);
		},
	
		// disable, activate form fields
		control_entry_fields: function (field_value) {
			var inp_fields = $('#form_edit_entry input[type=text]');
			//clear all fields
			inp_fields.val("");
			// control entry fields
			switch (field_value) {
				case "new_entry":			
					inp_fields
					 .removeProp('disabled')
					 .removeClass('hide_field')
					 .filter('#id_to_edit')
					 // hide id field
					 .addClass('hide_field');
				break;
				
				case "edit_entry":		
					inp_fields
					 .removeProp('disabled')
					 .removeClass('hide_field');
				break;
				
				case "delete_entry":		
					inp_fields
					 .removeClass('hide_field')
					 .not('#id_to_edit')
					 .prop('disabled', 'disabled');
				break;							
			}
		}
	}
};


/**---------------------------
		Controller – Forms
 ---------------------------**/
WC.forms.controller = {
	// call user warning function
	warner: function() {
		return confirm('Do you know what you are doing?'); 
	},
	
	// data editor form 
	db_entry_edit_form: {
		// showhide input
		show_hide: function () {
			$('#entry_edit, #entry_delete').on('click', function () {
				WC.forms.view.db_entry_edit_form.show_hide();
			});
		}()
	},
	
	// edit field control radio buttons edit, delete, new
	edit_entry: function () {
		$('#form_edit_entry').on('change', 'input[type=radio]', function () {
			var field_value = $(this).prop('value');
			WC.forms.view.db_entry_edit_form.control_entry_fields(field_value);
		});
	}()
};

/*========================================================
		Dates and Times
==========================================================*/
/**---------------------------
		Page date
 ---------------------------**/
WC.dates = {
	// self-updating
	write_date: function() {
		console.log('time updated');
		var d = new Date();
		$('#date').html( d.toDateString() );
		//setTimeout(WC.dates.write_date, 60000);
	}
};
// call to initialize
WC.dates.write_date();