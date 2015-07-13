jQuery(document).ready(function() {
	app.init();
});

var app = {
	init : function(){
		app.submitForm();
        jQuery('.sortable').sorTable();
        jQuery('.pagination').sortaPaginate();
        jQuery('.show-x-entries').sortaShowXEntries();
        
        jQuery('.submit-form').click(function(e){ // attaches an action to the form based on the button clicked, e.g. save and new, save and exit
        	e.preventDefault();
        	var form = jQuery(this).closest('form');
        	form.find('#action').remove();
        	form.append('<input type="hidden" name="action" id="action" value="'+jQuery(this).attr('action')+'" />');
        	form.submit();
        });
        
        app.deleteEntry();
        app.initDropzone();
	},
	deleteEntry : function(){
		jQuery('.delete-entry').click(function(e){
			e.preventDefault();
			
			if(!confirm('Are you sure?')) {
				return false;
			}
			
	    	app.clearErrors();
	    	
			jQuery.ajax({
			    url: jQuery(this).attr('url'),
			    type: 'DELETE',
		        headers: {
		        	'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
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
                        jQuery('.page-header').after('<div class="alert alert-danger alert-dismissible" role="alert">'+
                      		  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                      		  msg+
                      		'</div>');
                    } else {
                        jQuery('.page-header').after('<div class="alert alert-success alert-dismissible" role="alert">'+
                        		  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        		  msg+
                        		'</div>');
                    }
			    }
			});
		});
	},
	submitForm : function() { // ajax form submission
		jQuery('form.ajaxSubmission').submit(function(e){
			e.preventDefault();
			
			var form = jQuery(this),
				method = form.attr('method'),
				action = form.attr('action');
			
			showProcessing();
			
			jQuery.ajax({
			    url: action,
			    type: method,
			    data: form.serialize(),
			    dataType: 'json',
		        headers: {
		        	'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
		        },
			    success: function(res) {
			    	app.clearErrors();
			    	hideProcessing();
                    var msg = res.msg ? res.msg : 'Unknown Error';
                    if(res.errors) {
                        jQuery.each(res.errors, function(k,v){
                            jQuery('#'+k).closest('.form-group').addClass('has-error');
                            jQuery('#'+k).after('<span class="has-error help-block error">'+v+'</span>');
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
                        jQuery('.page-header').after('<div class="alert alert-danger alert-dismissible" role="alert">'+
                      		  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                      		  msg+
                      		'</div>');
                    } else {
                        jQuery('.page-header').after('<div class="alert alert-success alert-dismissible" role="alert">'+
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
    	jQuery('.has-error').removeClass('has-error');
        jQuery('.alert-danger').removeClass('alert-danger');
        jQuery('.error').remove();
        jQuery('.alert').hide();
	},
	initDropzone: function(){
		jQuery('.laradrop-test').laradrop({
			fileHandler: null,
			fileDeleteHandler: null,
			fileSrc: null,
			csrfToken: null,
			csrfTokenField: null,
			processingDisplay: null
		});
	}
}

jQuery.fn.laradrop = function(options) {	
    Dropzone.autoDiscover = false;
    var fileHandler = options.fileHandler,
    	fileDeleteHandler = options.fileDeleteHandler,
    	fileSrc = options.fileSrc,
    	csrfToken = options.csrfToken,
    	csrfTokenField = options.csrfTokenField ? options.csrfTokenField : '_token',
    	areYouSureText = options.areYouSureText ? options.areYouSureText : 'Are you sure?',
    	processingDisplay = options.processingDisplay ? options.processingDisplay : 'processing...',
    	uid = new Date().getTime(),
    	laradropObj = jQuery(this);
   
   if(jQuery(this).attr('laradrop-upload-handler')) {
	   fileHandler = jQuery(this).attr('laradrop-upload-handler');
   }
   
   if(jQuery(this).attr('laradrop-file-delete-handler')) {
	   fileDeleteHandler = jQuery(this).attr('laradrop-file-delete-handler');
   }
   
   if(jQuery(this).attr('laradrop-file-source')) {
	   fileSrc = jQuery(this).attr('laradrop-file-source');
   }
   
   if(jQuery(this).attr('laradrop-csrf-token')) {
	   csrfToken = jQuery(this).attr('laradrop-csrf-token');
   }
   
   if(jQuery(this).attr('laradrop-csrf-token-field')) {
	   csrfTokenField = jQuery(this).attr('laradrop-csrf-token-field');
   }
    	
   jQuery('body').after(getModalContainer());
   jQuery('.laradrop-modal-container .modal-body').css({'overflow-y':'auto', 'height': jQuery(window).height()-200+'px'});
   
   var btnText = jQuery("#modal-container-"+uid+" .btn-upload").text()

    new Dropzone("#modal-container-"+uid+" .btn-upload", { 
        url: fileHandler,
        init: function(){
        	this.on("sending", function(file, xhr, data) {
                data.append(csrfTokenField, csrfToken);
                displayProcessing();
            });
            
            this.on("success", function(obj, res) {
            	jQuery.get(fileSrc, function(files){ 
            		displayMedia(files);
            		hideProcessing();
            	});
            });
            
            this.on("addedfile", function(file) {
            	jQuery('.dz-preview, .dz-processing, .dz-image-preview, .dz-success, .dz-complete').remove();
            	return false;
            });
        }
    });  
    
    	
	jQuery(this).find('.laradrop-select-file').click(function(e){
		e.preventDefault();
		jQuery.get(fileSrc, function(res){
			displayMedia(res);
			jQuery('.laradrop-modal-container').modal('toggle');
		});
	});
	
	function displayProcessing(){
		jQuery("#modal-container-"+uid+" .btn-upload").text(processingDisplay);
	}
	
	function hideProcessing(){
		jQuery("#modal-container-"+uid+" .btn-upload").text(btnText);
	}

	function displayMedia(res){
			var out='<div  class="row list-group">';
			jQuery.each(res.data, function(k,v){
				out+=getThumbnailContainer().replace('[[fileSrc]]', v.file).replace('[[fileId]]',v.id);
			});
			out+='</div>';
			jQuery('.laradrop-modal-container').find('.modal-title').text('Media');
			jQuery('.laradrop-modal-container').find('.modal-body').html(out);
			jQuery('.laradrop-modal-container').find('.insert').click(function(){
				var src = jQuery(this).closest('.laradrop-thumbnail').find('img').attr('src');
				laradropObj.find('.laradrop-file-thumb').html('<img src="'+src+'" />');
				laradropObj.find('.laradrop-input').val(src);
				jQuery('.laradrop-modal-container').modal('hide');
			});	  
		    
		    jQuery('.laradrop-modal-container .delete').click(function(e) {
		    	e.preventDefault();
		    	var fileId = jQuery(this).attr('file-id');
		    	
		    	fileDeleteHandler = fileDeleteHandler.replace(fileDeleteHandler.substr(fileDeleteHandler.lastIndexOf('/')), '/'+fileId);
		    	
		    	if(!confirm(areYouSureText)) {
		    		return false;
		    	}

		    	displayProcessing();
		    	
				jQuery.ajax({
				    url: fileDeleteHandler,
				    type: 'DELETE',
				    dataType: 'json',
			        headers: {
			        	'X-CSRF-TOKEN': csrfToken
			        },
				    success: function(res) {
		            	jQuery.get(fileSrc, function(files){ 
		            		displayMedia(files);
		            		hideProcessing();
		            	});
				    }
				});
		    });
		    
		    jQuery('.laradrop-thumbnail .thumbnail').hover(
		    		  function() {
		    			  jQuery(this).find('.caption').fadeIn('fast');
		    			  }, function() {
		    				  jQuery(this).find('.caption').fadeOut('fast');
		    			  }
		    			);
		    

	}	

	function getModalContainer() {
		return '\
    	<div class="modal fade laradrop-modal-container"  id="modal-container-'+uid+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">\
		  <div class="modal-dialog modal-lg">\
		    <div class="modal-content" >\
		      <div class="modal-header">\
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
		        <h4 class="modal-title"></h4>\
		      </div>\
		      <div class="modal-body" >\
		        ...\
		      </div>\
		      <div class="modal-footer">\
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>\
		        <button type="button" class="btn btn-primary btn-upload">Upload</button>\
		      </div>\
		    </div>\
		  </div>\
		</div>';
	}
	
	function getThumbnailContainer() {
		return '\
		<div class="item laradrop-thumbnail col-xs-12 col-md-2">\
			<div class="thumbnail" style="cursor:pointer;">\
				<img class="group list-group-image" src="[[fileSrc]]" alt="" />\
				<div class="caption" style="display:none;float:right;margin-top:-40px;">\
					<div class="row">\
						<div class="col-md-5">\
							<button class="btn btn-success btn-xs insert">Insert</button>\
						</div>\
						<div class="col-md-5">\
							<button class="btn btn-danger btn-xs delete" file-id="[[fileId]]" >Delete</button>\
						</div>\
					</div>\
				</div>\
			</div>\
		</div>'
	}
}

/*
 * sorTable 
 * Add sort functionality to any table
 */
 jQuery.fn.sorTable = function() {
     var base_url = window.location.href.split('?')[0],
         url, display, direction, link, display_glyph = '';
     
 	jQuery(this).each(function(){
     	url = base_url + '?sortby=' + jQuery(this).attr('id') + '&dir=',
     	display = jQuery(this).text(),
     	direction = 'asc',
     	display_glyph = false;

 	    if(jQuery.url().param('sortby') == jQuery(this).attr('id')){
 	        display_glyph = true;
     	    if(jQuery.url().param('dir') == 'desc'){
     	        direction = 'desc';
     	    }
  	    }
  	    url+=(direction=='asc'?'desc':'asc');

  	    jQuery.each(jQuery.url().param(), function(k,v){
      	   if(k!='sortby' && k!='dir'){
        	      if(k=='filter'){
           	      jQuery.each(v, function(k2,v2){
               	      url+='&filter['+k2+']='+v2;
           	      });
       	      }else{
      		    url+='&'+k+'='+v;
       	      }
      	   }
  	    });

 	    link = '<a href="'+encodeURI(url)+'">'+display+'</a><span class="fa '+(display_glyph==false?'fa-sort':' fa-sort-'+(direction=='asc'?'asc':'desc'))+'" aria-hidden="true"></span>';
 	    jQuery(this).html(link);
 	});
 }

/*
 * sortaPaginate
 * Add sort params to pagination links
 */
 jQuery.fn.sortaPaginate = function() {
    var href = '',
        params = jQuery.url().param();    

    if(!jQuery.isEmptyObject(params)){          
     	jQuery(this).find('a').each(function(){
         	href = jQuery(this).attr('href');
         	jQuery.each(params, function(k, v){
         	   if(k!='page'){
           	      if(k=='filter'){
              	      jQuery.each(v, function(k2,v2){
                  	      href+='&filter['+k2+']='+v2;
              	      });
          	      }else{
         		    href+='&'+k+'='+v;
          	      }
         	   }
         	});
         	jQuery(this).attr('href', encodeURI(href));
     	});
    }
 }
 
 /*
  * sortaShowXEntries
  * Add sort params to 'show x entries' links
  */
  jQuery.fn.sortaShowXEntries = function() {
     var value = '',
         params = jQuery.url().param();    

     if(!jQuery.isEmptyObject(params)){          
      	jQuery(this).find('option').each(function(){
          	value = jQuery(this).val();
          	jQuery.each(params, function(k, v){
          	   if(k!='page' && k!='showEntries'){
            	      if(k=='filter'){
               	      jQuery.each(v, function(k2,v2){
                   	      value+='&filter['+k2+']='+v2;
               	      });
           	      }else{
          		    value+='&'+k+'='+v;
           	      }
          	   }
          	});
          	jQuery(this).val(encodeURI(value));
      	});
     }
     
     jQuery(this).change(function(){
    	 window.location = jQuery(this).val();
     });
  }