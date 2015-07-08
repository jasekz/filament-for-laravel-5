$(document).ready(function() {
	app.init();
});

var app = {
	init : function(){
		app.submitForm();
        $('.sortable').sorTable();
        $('.pagination').sortaPaginate();
        $('.show-x-entries').sortaShowXEntries();
        
        $('.submit-form').click(function(e){ // attaches an action to the form based on the button clicked, e.g. save and new, save and exit
        	e.preventDefault();
        	var form = $(this).closest('form');
        	form.find('#action').remove();
        	form.append('<input type="hidden" name="action" id="action" value="'+$(this).attr('action')+'" />');
        	form.submit();
        });
        
        app.deleteEntry();
	},
	deleteEntry : function(){
		$('.delete-entry').click(function(e){
			e.preventDefault();
			
			if(!confirm('Are you sure?')) {
				return false;
			}
			
	    	app.clearErrors();
	    	
			$.ajax({
			    url: $(this).attr('url'),
			    type: 'DELETE',
		        headers: {
		        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        },
			    dataType: 'json',
			    success: function(res) {
                    if(res.redirect){
                        if(res.redirect == 'back'){
                        	location = document.referrer;
                        }else{
                            location = res.redirect;
                        }
                        return false;
                    }
                    if(res.reload) {
                        location.reload();
                        return false;
                    }
                    
                    var msg = res.msg ? res.msg : 'Unknown Error';
                    if (res.error){
                        $('.page-header').after('<div class="alert alert-danger alert-dismissible" role="alert">'+
                      		  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                      		  msg+
                      		'</div>');
                    } else {
                        $('.page-header').after('<div class="alert alert-success alert-dismissible" role="alert">'+
                        		  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        		  msg+
                        		'</div>');
                    }
			    }
			});
		});
	},
	submitForm : function() { // ajax form submission
		$('form.ajaxSubmission').submit(function(e){
			e.preventDefault();
			
			var form = $(this),
				method = form.attr('method'),
				action = form.attr('action');
			
			showProcessing();
			
			$.ajax({
			    url: action,
			    type: method,
			    data: form.serialize(),
			    dataType: 'json',
		        headers: {
		        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        },
			    success: function(res) {
			    	app.clearErrors();
			    	hideProcessing();
                    var msg = res.msg ? res.msg : 'Unknown Error';
                    if(res.errors) {
                        $.each(res.errors, function(k,v){
                            $('#'+k).closest('.form-group').addClass('has-error');
                            $('#'+k).after('<span class="has-error help-block error">'+v+'</span>');
                        });                            
                    }
                    if(res.redirect){
                        if(res.redirect == 'back'){
                        	location = document.referrer;
                        }else{
                            location = res.redirect;
                        }
                        return false;
                    }
                    if(res.reload) {
                        location.reload();
                        return false;
                    }
                    if (res.error){
                        $('.page-header').after('<div class="alert alert-danger alert-dismissible" role="alert">'+
                      		  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                      		  msg+
                      		'</div>');
                    } else {
                        $('.page-header').after('<div class="alert alert-success alert-dismissible" role="alert">'+
                        		  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        		  msg+
                        		'</div>');
                    }
			    }
			});
						
			function showProcessing(){
				var btn = form.find('.btn.submit'),
					text = btn.text();
					
				btn.addClass('disabled');
			}
			
			function hideProcessing(){
				form.find('.btn.submit').removeClass('disabled');
			}
		});
	},
	clearErrors : function(){
    	$('.has-error').removeClass('has-error');
        $('.alert-danger').removeClass('alert-danger');
        $('.error').remove();
        $('.alert').hide();
	}
}



/*
 * sorTable 
 * Add sort functionality to any table
 */
 $.fn.sorTable = function() {
     var base_url = window.location.href.split('?')[0],
         url, display, direction, link, display_glyph = '';
     
 	$(this).each(function(){
     	url = base_url + '?sortby=' + $(this).attr('id') + '&dir=',
     	display = $(this).text(),
     	direction = 'asc',
     	display_glyph = false;

 	    if($.url().param('sortby') == $(this).attr('id')){
 	        display_glyph = true;
     	    if($.url().param('dir') == 'desc'){
     	        direction = 'desc';
     	    }
  	    }
  	    url+=(direction=='asc'?'desc':'asc');

  	    $.each($.url().param(), function(k,v){
      	   if(k!='sortby' && k!='dir'){
        	      if(k=='filter'){
           	      $.each(v, function(k2,v2){
               	      url+='&filter['+k2+']='+v2;
           	      });
       	      }else{
      		    url+='&'+k+'='+v;
       	      }
      	   }
  	    });

 	    link = '<a href="'+encodeURI(url)+'">'+display+'</a><span class="fa '+(display_glyph==false?'fa-sort':' fa-sort-'+(direction=='asc'?'asc':'desc'))+'" aria-hidden="true"></span>';
 	    $(this).html(link);
 	});
 }

/*
 * sortaPaginate
 * Add sort params to pagination links
 */
 $.fn.sortaPaginate = function() {
    var href = '',
        params = $.url().param();    

    if(!$.isEmptyObject(params)){          
     	$(this).find('a').each(function(){
         	href = $(this).attr('href');
         	$.each(params, function(k, v){
         	   if(k!='page'){
           	      if(k=='filter'){
              	      $.each(v, function(k2,v2){
                  	      href+='&filter['+k2+']='+v2;
              	      });
          	      }else{
         		    href+='&'+k+'='+v;
          	      }
         	   }
         	});
         	$(this).attr('href', encodeURI(href));
     	});
    }
 }
 
 /*
  * sortaShowXEntries
  * Add sort params to 'show x entries' links
  */
  $.fn.sortaShowXEntries = function() {
     var value = '',
         params = $.url().param();    

     if(!$.isEmptyObject(params)){          
      	$(this).find('option').each(function(){
          	value = $(this).val();
          	$.each(params, function(k, v){
          	   if(k!='page' && k!='showEntries'){
            	      if(k=='filter'){
               	      $.each(v, function(k2,v2){
                   	      value+='&filter['+k2+']='+v2;
               	      });
           	      }else{
          		    value+='&'+k+'='+v;
           	      }
          	   }
          	});
          	$(this).val(encodeURI(value));
      	});
     }
     
     $(this).change(function(){
    	 window.location = $(this).val();
     });
  }