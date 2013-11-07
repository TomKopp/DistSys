
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
	passwordForm();
	profileForm();
	
	userShow();
	userEdit();
	userDelete();
	
	catShow();
	catNew();
	catDelete();
	catEdit();

	prodShow();
	prodNew();
	prodDelete();
	prodEdit();
	
	
	function passwordForm(){
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
	}
  
  
  function profileForm(){
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
  }
  
  /* admin user */
  function userShow(){
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
  }
  
  function userEdit(){
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
					      index = href.lastIndexOf("/");
					      newHref = href.substring(0, index);
					      index = newHref.lastIndexOf("/");
					      newHref = newHref.substring(0, index+1);
					      $.get(newHref+"part", function( data ) {
						    	$( "#main table" ).html( data );
						    	userShow();
						    	userEdit();
						    	userDelete();
								 $( "#render" ).delay(2000).hide("slow");
						    });
					      
					    });
					    
					    
					 
					    return false;
					  });
			  });
			 
			 
			  
			 
			 
			 return false;
		 }) ;
		  
	  });
  }
  
  function userDelete(){
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
  }
  /* end admin user */
  
  /* admin categorie */
  function catShow(){
  $('.catShow').each(function(){
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
  }
  function catNew(){
     $('.catNew').each(function(){
		 $(this).click(function(){
			 href = $(this).attr('href');
			 $.get(href, function( data ) {
				 $( "#render" ).hide();
				  $( "#render" ).html( data );
				  $( "#render" ).show("slow");
				  $("#cat-form").submit( function( e ){
					  
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
					      index = href.lastIndexOf("/");
					      newHref = href.substring(0, index);
					      index = newHref.lastIndexOf("/");
					      newHref = newHref.substring(0, index+1);
					      $.get(newHref+"categorie/part", function( data ) {
						    	$( "#main table" ).html( data );
						    	catShow();
						    	catEdit();
						    	catDelete();
								 $( "#render" ).delay(2000).hide("slow");
						    });
					      
					    });
					    
					    
					 
					    return false;
					  });
				  
			  });
			 return false;
		 }) ;
		  
	  });
  }
  function catEdit(){
	  $('.catEdit').each(function(){
			 $(this).click(function(){
				 href = $(this).attr('href');
				 $.get(href, function( data ) {
					 $( "#render" ).hide();
					  $( "#render" ).html( data );
					  $( "#render" ).show("slow");
					  $("#cat-form").submit( function( e ){
						  
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
						      index = href.lastIndexOf("/");
						      newHref = href.substring(0, index);
						      index = newHref.lastIndexOf("/");
						      newHref = newHref.substring(0, index+1);
						      $.get(newHref+"part", function( data ) {
							    	$( "#main table" ).html( data );
							    	catShow();
							    	catEdit();
							    	catDelete();

									 $( "#render" ).delay(2000).hide("slow");
							    });
						      
						    });
						    
						    
						 
						    return false;
						  });
				  });
				 
				 
				  
				 
				 
				 return false;
			 }) ;
			  
		  });
  }
  function catDelete(){
	  $('.catDelete').each(function(){
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
  }
  /* end admin categorie */
  
  /* admin product */
  function prodShow(){
  $('.prodShow').each(function(){
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
  }
  function prodNew(){
     $('.prodNew').each(function(){
		 $(this).click(function(){
			 href = $(this).attr('href');
			 $.get(href, function( data ) {
				 $( "#render" ).hide();
				  $( "#render" ).html( data );
				  $( "#render" ).show("slow");
				  $("#prod-form").submit( function( e ){
					  
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
					      index = href.lastIndexOf("/");
					      newHref = href.substring(0, index);
					      index = newHref.lastIndexOf("/");
					      newHref = newHref.substring(0, index+1);
					      $.get(newHref+"product/part", function( data ) {
						    	$( "#main table" ).html( data );
						    	prodShow();
						    	prodEdit();
						    	prodDelete();
								 $( "#render" ).delay(2000).hide("slow");
						    });
					      
					    });
					    
					    
					 
					    return false;
					  });
				  
			  });
			 return false;
		 }) ;
		  
	  });
  }
  function prodEdit(){
	  $('.prodEdit').each(function(){
			 $(this).click(function(){
				 href = $(this).attr('href');
				 $.get(href, function( data ) {
					 $( "#render" ).hide();
					  $( "#render" ).html( data );
					  $( "#render" ).show("slow");
					  $("#prod-form").submit( function( e ){
						  
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
						      index = href.lastIndexOf("/");
						      newHref = href.substring(0, index);
						      index = newHref.lastIndexOf("/");
						      newHref = newHref.substring(0, index+1);
						      $.get(newHref+"part", function( data ) {
							    	$( "#main table" ).html( data );
							    	prodShow();
							    	prodEdit();
							    	prodDelete();

									 $( "#render" ).delay(2000).hide("slow");
							    });
						      
						    });
						    
						    
						 
						    return false;
						  });
				  });
				 
				 
				  
				 
				 
				 return false;
			 }) ;
			  
		  });
  }
  function prodDelete(){
	  $('.prodDelete').each(function(){
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
  }
  /* end admin categorie */
	 
});