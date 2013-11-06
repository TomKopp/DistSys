
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
  
  $('.userShow').each(function(){
	 $(this).click(function(){
		 href = $(this).attr('href');
		 $.get(href, function( data ) {
			 $( "#render" ).hide();
			  $( "#render" ).html( data );
			  $( "#render" ).show("slow");
			  
		  });
		 return false;
	 }) ;
	  
  });
  
  $('.userEdit').each(function(){
		 $(this).click(function(){
			 href = $(this).attr('href');
			 $.get(href, function( data ) {
				 $( "#render" ).hide();
				  $( "#render" ).html( data );
				  $( "#render" ).show("slow");
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
			 
			 
			  
			 
			 
			 return false;
		 }) ;
		  
	  });
  
  $('.userDelete').each(function(){
		 $(this).click(function(){
			 href = $(this).attr('href');
			 tr = $(this).parent().parent();
			 $.get(href, function( data ) {
				  $( "#render" ).html( data.res );
				  if (data.status == true){
					  $(tr).hide("slow");
				  }
			  });
			 return false;
		 }) ;
		  
	  });
	 
});