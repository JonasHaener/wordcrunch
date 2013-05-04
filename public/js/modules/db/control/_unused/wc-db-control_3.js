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

WC.helper.parse_json = function (d) {
	return $.parseJSON(d);
};

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

WC.helper.trim_comas = function (str) {
	return str.replace(/\,+/g, ",");
};

/*========================================================
			DATABASE
==========================================================*/

/**---------------------------
		Model – Database
 ---------------------------**/
WC.db.model = {
	// make DB call
	ajx_data: "",
	// call type from controller
	call_type: "",
	// exponential backoff
	attempts: 3,
	// exponential backoff attempts 
	delay: 2000,
	
	// controlls DB model
	controller: {
		// called by input controller
		db_call: function(ide, form) { 
			WC.db.model.callDB(ide, form);
		},
		// function called by ajax success event
		prep_results_view: function(call_type, json) {
			var _this = WC.db.model,
					view = WC.db.view,
					// JSON data from DB in JS object
					js_obj = _this.ready_json(json),
					result = js_obj.result[0],
					status = js_obj.status,
					rows = "",
					ids = "";
			// prepare for view
			if (typeof call_type !== 'string') {
				return;
			}
			// call view based on type 'search', 'retrieve', 'edit', 'delete'
			switch (call_type) {
				// DB search
				// results
				case 'search':
					rows = _this.prep_table( js_obj ),
					ids = js_obj['ids_used'];
					view.update_content( rows );
					view.update_id( ids );
					// display if not entries found
					if (typeof status === "string") {
						view.update_status( status );	
					}
					break;
				// retrieve values for 
				// editing form	
				case 'retrieve':
					if (typeof result.id === 'string' && result.id !== "") {
						view.update_for_edit( result );
					}
					if (typeof status === "string") {
						view.update_status( status );	
					}
					break;
				// editing and saving 
				// from form
				case 'edit':
					view.update_for_edit( result );
					if (typeof status === "string") {
						view.update_status( status );	
					}
					break;			
					// deleting and saving 
					// from form	
				case 'delete':
					view.update_for_edit( result );
					if (typeof status === "string") {
						view.update_status( status );	
					}
					break;
			}
		},
	},
	
	// make Ajax DB call
	callDB: function (ide, form) {
		var _this = this;
		// in editor mode call user warning first
		if (ide && ide === "edit" && WC.db.view.warn_confirm() === false) {
			return;
		}
		// for consecutive calls use saved values and assign
		// values directly
		_this.ajx_data = (form) ? form.serialize() : _this.ajx_data;
		alert(_this.ajx_data);
		_this.call_type = (ide) ? ide : _this.call_type;
		// AJAX call
		$.ajax({
			type: "POST",
			url: '../application/modules/db/controllers/wc-db-control.inc.php',
			data: _this.ajx_data,
			beforeSend: function() {
				// show spinner
				WC.db.view.show_spinner();
			},
			// success function
			success: function (data) {
				//pass data back to model controller
				_this.controller.prep_results_view( _this.call_type, data );	
			},
			// error handling function
			error: function(xhr, status) {
        if(_this.attempts-- === 0) {
          // After 4 trials call end to server
					WC.db.view.update_status( "Server not responding" );
          _this.reset();
          return;
        }
        setTimeout(function() {
          _this.callDB();
					//console.log('called again');
        }, _this.delay *= 2);
      },
			complete: function() { 
				// remove spinner
				WC.db.view.hide_spinner();
			}
		});
	},
	
	// reset function
	reset: function () {
   	this.delay = 1000;
   	this.attempts = 3;
  },
		
	// transform JSON into JavaScript object
	ready_json: function (json_data) {
		// check for string type
		if (typeof json_data !== 'string') {
			return;
		}
		var a, b,
			 	res_string = "",
			 	res_arr = [],
			 	ids = "",
			 	js_res_array = [],
				no_entries = "";
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
				js_res_array[0] = { status: "Sorry, no result found" };
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
		return { 'result': js_res_array, 'ids_used': ids, 'status': js_res_array[0].status };
	},

	// prepare table for results
	prep_table : function (data) {	
		var a, b,
			 	// results db array
			 	db_res_arr = data.result,
			 	status = data.status,
			 	rows = "";
		// if an error message is present return the error here
		if (status) {
			return rows += "<tr>"+"<td>"+status+"</td></tr>";
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
	}
};

/**---------------------------
		View – Database
 ---------------------------**/
WC.db.view = {
	// results containers
	container: $('#result > tbody'),
	ids_container: $('#ids_used'),
	user_message: $('<div id="user_feedback" class=""></div>'),
	message_pos: $('body'),
	// display confirmation message
	warn_confirm: function() {
		return confirm('Do you know what you are doing?');
	},
	show_spinner: function() { 
		$('#spinner').show();	
	},
	hide_spinner: function() { 
		$('#spinner').hide();	
	},
	// write results to results field
	update_content: function (data) {
		this.container.html(data);
	},
	// update status and error messaged
	update_status: function (data) {
		this.user_message
			.text(data)
			// show user feedback and fade out
			.hide()
			.addClass("gradient-yellow-rgb")
			.appendTo(this.message_pos)
			.fadeIn(500)
			.delay(1000)
			.fadeOut(500);
	},
	// update ids field
	update_id: function (data) {
		this.ids_container.val(data);
	},
	// update input fields
	update_for_edit: function (data) {
		$('#id_to_edit').val(data.id);
		$('#edit_german').val(data.german);
		$('#edit_english').val(data.english);
		$('#edit_french').val(data.french);
		$('#edit_dutch').val(data.dutch);
		$('#edit_spanish').val(data.spanish);
		$('#edit_italian').val(data.italian);
		$('#edit_japanese').val(data.japanese);
		$('#edit_comments').val(data.comments);
	}
};

/**---------------------------
		Controller – Database
 ---------------------------**/
// JSON
WC.db.controller = {
	// refresher trigger
	do_search: (function () {
		$('#entry_refresh').on('click', function () {
			WC.db.model.controller.db_call('search', $('#form_search'));
		});
	})(),
	// submit entries from edit entry form
	do_edit: function () {
		$('#go_edit').on('click', function () {
			WC.db.model.controller.db_call('edit', $('#form_edit_entry'));	
		});
	}(),
	// retrieve data from DB for editing
	retrieve_for_edit: function () {
		$('#id_to_edit').on('blur', function () {
			// do not submit the radio buttons to 
			// avoid conflict when submitting entire form
			// when updating Database
			var form = $('#form_edit_entry > input').not('input[type=radio]');
			WC.db.model.controller.db_call('retrieve', form);
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
	}(),
	
	// input field cleaner
	clean_input_fields: function () {
			$('#inp_search').on('change', function() {
				var txt = $(this).val();
				// true cleans within the string too
				txt = WC.helper.trim_string(txt, true);
				// reduce commas to maximum one
				txt = WC.helper.trim_comas(txt);
				// reassign text to input field
				$(this).val(txt);
			});
			$('#form_edit_entry > input').on('change', function() {
				var txt = $(this).val();
				// false cleans left, right
				txt = WC.helper.trim_string(txt, false);
				// reduce commas to maximum one
				txt = WC.helper.trim_comas(txt);
				// reassign text to input field
				$(this).val(txt);
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
		//console.log('time updated');
		var d = new Date();
		$('#date').html( d.toDateString() );
		// update date every hour
		setTimeout(WC.dates.write_date, 60000);
	}
};
// call to initialize
WC.dates.write_date();