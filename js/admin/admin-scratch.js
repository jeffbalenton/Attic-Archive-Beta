/*--------------------------------------------------------------
Scratch JS
--------------------------------------------------------------*/



jQuery(document).ready(function($){


	
 // alert( "Handler for .change() called." );
	
	
//console.log("The values is now"+str);


	
	function displayVals() {
  var value = $( "select#users" ).val();
		if (value ==""){
			console.log("No person selected");
		}
        console.log("Person selected " +value);
}
 
$( "select#users" ).change( displayVals );

	
	}); 	