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

WC.helper.String_serializer = function (d)
{
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

/////===============================================
/*continue here building class serializer*/
/////===============================================
// accepts one form element only
WC.helper.serializer = function (d, name, serialize)
{	
		var rex = /\s+/g;
		var do_serialize = function (str) {
			// return searlized string
			return encodeURIComponent(name) + "=" + encodeURIComponent(str);

		};
		var prep_string = function (string) {
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
				
				return cleanString;
			}
		};
		return prep_string(d);
		
};

//var a = WC.helper.serializer("1,2,3,4,5", 'jonas', true);
//alert(a);






/*========================================================
			DATABASE
==========================================================*/

/**---------------------------
		Model – Database
 ---------------------------**/

WC.helper.parse_json = function (d) {
	return $.parseJSON(d);
};

WC.helper.trim_string = function (d)
{
	var rex = /\s*/g,
			trimmed = d.trim();
	
	trimmed = trimmed.replace(rex, "");

};



WC.db.model = {
	// make DB call
	callDB:	function (form)
	{
		//console.log('db.model: callDB OK');
		var _this = this;
		$.ajax({
			type: "GET",
			url: '../application/modules/db/controllers/db-control.inc.php',
			//data: form.serializeArray(),
			data: form.serialize(),
			success: function (data) {
				alert(data)
				var res = _this.ready_data(data);	
				WC.db.controller.caller(res);
			}
		});
	},
	// form table from result
	ready_data: function (json_data)
	{
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
	// results container
	container: $('#result > tbody'),
	ids_container: $('#ids_used'),
	// display confirmation message
	warn_confirm: function() {
		return confirm('Do you know what you are doing?');
	},
	
	prep_table : function (data)
	{	
			var a,
					b,
					// results db array
					db_res_arr = data.result,
					rows = "";
					
			// loop through results rows		
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
	update:	function (data) {
		var rows = this.prep_table(data),
				ids = data['ids_used'];
		
		this.container.html(rows);
		this.ids_container.val(ids);
	},
	// showhide form
	addSpinner: function (obj) {
			// accept position object
			switch(obj.position) {
					case 'ontop':
							$('body').addClass('ajax-load');
					break;
					case 'inside':
							this.container.addClass('ajax-load');
					break;
			}
	},
	// remove spinner
	removeSpinner: function () {
			$('.ajax-loader').removeClass('ajax-loader');	
	}


};





/**---------------------------
		Controller – Database
 ---------------------------**/
// JSON
WC.db.controller = {
	
	// model calls caller when Ajax results received
	caller: function (res) {
			WC.db.view.update(res);
			WC.db.view.removeSpinner();		
	},
	
	// refresher trigger
	do_search: (function () {
			$('#entry_refresh').on('click', function () {
					console.log('db.conroller: refresh clicked');
					// call db and store result
					WC.db.model.callDB( $('#form_search') );
					WC.db.view.addSpinner( {'position':'ontop'} );	
			});
	})(),
	
	// submit entries from edit entry form
	do_edit: function () {
			$('#go_edit').on('click', function () {
					if ( WC.db.view.warn_confirm() ) {
							console.log('db.conroller: refresh clicked');
							// call db and store result
							WC.db.model.callDB( $('#form_edit_entry') );
							WC.db.view.addSpinner( {'position':'inside'} );		
					}
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
	
	warner: function () {
	
	},
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
				//alert('run')
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
										// do not select field id
										.removeClass('hide_field')
										.not('#id_to_edit')
										// disable all other text fields
										.prop('disabled', 'disabled')
										.addClass('hide_field');
								break;
				}
		}
	}
};


/**---------------------------
		Controller – Forms
 ---------------------------**/
WC.forms.controller = {
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
		}(),
		
		// edit field control radio buttons edit, delete, new
		edit_entry: function () {
				$('#form_edit_entry').on('change', 'input[type=radio]', function () {
					var field_value = $(this).prop('value');
					WC.forms.view.db_entry_edit_form.control_entry_fields(field_value);
				});
		}(),
		
	}
	
	
	
	
};