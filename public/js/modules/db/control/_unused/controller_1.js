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
/*
WC.db.model = {
	// make DB call
	callDB:	function(form)
	{
		//console.log('db.model: callDB OK');
		var _this = this;
		$.ajax({
			type: 'GET',
			url: '../application/modules/db/controllers/db-control.inc.php',
			data: form.serialize(),
			success: function (res) {	
				WC.db.controller.caller(res);
			}
		});
	}

};
*/
// JSON getter

function serializer(form) {
	var serial = form.serializeArray();
	alert(serial.valueOf());
	return serial;
	
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
	}

};



/**---------------------------
		View – Database
 ---------------------------**/
/* working with string
WC.db.view = {
	// results container
	container: $('#result > tbody'),
	// write results to results container
	update:	function (data) {
		this.container.html(data);
	},
	// showhide form
	addSpinner: function () {
		//this.container.html( )
	}
};
*/
WC.db.view = {
	// results container
	container: $('#result > tbody'),
	// write results to results container
	parse_json: function(d) {
		return $.parseJSON(d);
	},
	// form table from result
	write_table: function(json_data)
	{
			var a, 
					ro = null,
					ro1,
					res = "",
					arr;
			//remove brackets		
			ro = json_data.replace(/\[(.*)\]/g, '$1');
			// separate object entities
			ro = ro.replace(/\}(,){/g, '}|{');
			// split into array
			arr = ro.split('|');
			// assemble table rows
			for (a = 0; a < arr.length; a += 1) {
				// convert JSON to javascript
				ro = this.parse_json(arr[a]);
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
		
			}
			return res;
	},
	update:	function (json_data) {
		var res = this.write_table(json_data);
		this.container.html(res);
	},
	// showhide form
	addSpinner: function () {
		//this.container.html( )
	}
};





/**---------------------------
		Controller – Database
 ---------------------------**/
/*
WC.db.controller = {
	// model calls caller when Ajax results received
	caller: function(db_res) {
		WC.db.view.update(db_res);			
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
*/

// JSON
WC.db.controller = {
	// model calls caller when Ajax results received
	caller: function(db_res) {
		WC.db.view.update(db_res);			
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