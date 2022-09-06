/*--------------------------------------------------------------
>>> TABLE OF CONTENTS:
----------------------------------------------------------------
1. ...
2. ...
3. ...
--------------------------------------------------------------*/

jQuery(document).ready(function($){

var tab="Banana";
  	 
$( ".btn1" ).click(function() {
	jQuery.ajax({
		type : 'post',
        dataType : 'json',
        url: ajaxurl, // Since WP 2.8 ajaxurl is always defined and points to admin-ajax.php
        data: {
              'action':'example_ajax_request', // This is our PHP function below
              'tab' : tab // This is the variable we are sending via AJAX
          },
          success:function(response) {
			 // This outputs the result of the ajax request (The Callback)]
			  console.log(response.content);
			  $("#content-area").empty();
              $("#content-area").html(response.content); 
          },
	

          error: function(errorThrown){
	
              window.alert(errorThrown);
          }
      });
    });   
}); 



