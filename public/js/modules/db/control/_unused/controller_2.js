"use strict";
/*
 * CONTROLLER
 *
 */


/*========================================================
			NS Namespace
==========================================================*/
var WC = {};
// add database object to NS
WC.db = {};
// add forms object to NS
WC.forms = {};


/*========================================================
			DATABASE
==========================================================*/

/**---------------------------
		Model – Database
 ---------------------------**/

WC.helper.parse_json = function(d) {
	return $.parseJSON(d);
}
	




WC.db.model = {
	// make DB call
	callDB:	function(form)
	{
		//console.log('db.model: callDB OK');
		var _this = this;
		$.ajax({
			type: "GET",
			url: '../application/modules/db/controllers/db-control.inc.php',
			//data: form.serializeArray(),
			data: form.serialize(),
			success: function (res) {	
				WC.db.controller.caller(res);
			}
		});
	},
	// form table from result
	serve_table: function(json_data)
	{
			// check for string type
			if (typeof json_data !== 'string') {
				return;
			}
			
			var a, 
					ro = null,
					ro1,
					res = "",
					arr,
					ids = "";
					
			//remove brackets		
			ro = json_data.replace(/\[(.*)\]/g, '$1');
			// separate object entities
			ro = ro.replace(/\}(,){/g, '}|{');
			// split into array
			arr = ro.split('|');
			// assemble table rows
			for (a = 0; a < arr.length; a += 1) {
				// convert JSON to javascript
				ro = WC.helper.parse_json(arr[a]);
				// concatenate results
				res += "<tr>"+"<td>"+
					ro['id']+"</td><td>"+
					ro['german']+"</td><td>"+
					ro['english']+"</td><td>"+
					ro['french']+"</td><td>"+
					ro['dutch']+"</td><td>"+
					ro['japanese']+"</td><td>"+
					ro['italian']+"</td><td>"+
					ro['spanish']+"</td><td>"+
					ro['comments']+"</td><td>"+
					ro['updated']+"</td></tr>";
				
				//collect used ids
				ids = (a < 1) ? ids + ro['id'] : ids + ", " + ro['id'];
			}
			return { result:res, ids_used: ids };
	}
};



/**---------------------------
		View – Database
 ---------------------------**/
WC.db.view = {
	// results container
	container: $('#result > tbody'),
	ids_container: $('#ids_used'),
	update:	function (data) {
		this.container.html(data['result']);
		this.ids_container.html(data['ids_used']);
	},
	// showhide form
	addSpinner: function () {
		//this.container.html( )
	}
};





/**---------------------------
		Controller – Database
 ---------------------------**/
// JSON
WC.db.controller = {
	// model calls caller when Ajax results received
	caller: function(db_res) {
		var res = WC.db.model
		WC.db.view.update(db_res);
		// remove spinner			
	},
	// refresher trigger
	do_search: (function () 
	{
		$('#entry_refresh').on('click', function () {
			console.log('db.conroller: refresh clicked');
			// call db and store result
			WC.db.model.callDB( $('#form_search') );
		});
	    // add spinner to database results field
			//WC.db.model.callDB.addSpinner();
	
	})()
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
			$('#entry_edit, #entry_delete').click(function () {
				WC.forms.view.db_entry_edit_form.show_hide();
			});
		}()
	}
};