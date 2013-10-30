
/* password */
function postForm( $form, callback ){
	 
	  /*
	   * Get all form values
	   */
	  var values = {};
	  $.each( $form.serializeArray(), function(i, field) {
	    values[field.name] = field.value;
	  });
	 
	  /*
	   * Throw the form values to the server!
	   */
	  $.ajax({
	    type        : $form.attr( 'method' ),
	    url         : $form.attr( 'action' ),
	    data        : values,
	    success     : function(data) {
	      callback( data );
	    }
	  });
	  
	  
	 
	}

$(document).ready(function(){

  $("#password-form").submit( function( e ){
    e.preventDefault();
    postForm( $(this), function( response ){
      $('.res').html(response.status);
      if (response.res){
    	  $('.res').addClass("text-success");
    	  $('.res').removeClass("text-danger");
      }else {
    	  $('.res').removeClass("text-success");
    	  $('.res').addClass("text-danger");
      }
      
    });
 
    return false;
  });
  
  $("#profile-form").submit( function( e ){
	    e.preventDefault();
	    postForm( $(this), function( response ){
	      $('.res').html(response.status);
	      if (response.res){
	    	  $('.res').addClass("text-success");
	    	  $('.res').removeClass("text-danger");
	      }else {
	    	  $('.res').removeClass("text-success");
	    	  $('.res').addClass("text-danger");
	      }
	      
	    });
	 
	    return false;
	  });
	 
});