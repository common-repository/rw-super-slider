// JavaScript Document
jQuery.fn.outerHTML = function(){
    // IE, Chrome & Safari will comply with the non-standard outerHTML, all others (FF) will have a fall-back for cloning
    return (!this.length) ? this : (this[0].outerHTML || (
      function(el){
          var div = document.createElement('div');
          div.appendChild(el.cloneNode(true));
          var contents = div.innerHTML;
          div = null;
          return contents;
    })(this[0]));
}


function rwss_post_types_change( is_actual_event )
{
	if( is_actual_event == '1' )
	{
		jQuery( ".rwss-repeater-item-list .rwss-repeater-delete" ).trigger( "click" );
	}
	
	var op_html = ''; 
	var tax_arr = [ 'all' ];		
	jQuery( '#all_taxs .'+jQuery('#post-types').val() ).each(function(){
		if( jQuery( this ).val() != ''  )
		{
			tax_arr.push( jQuery( this ).val() );
		}
		op_html =  op_html + jQuery( this ).outerHTML();
	});
	jQuery( '#rwss-repeater-item-holder .condition_tax' ).html( op_html );		
	
	//Term Part
	var op_term_html = '';
	if ( tax_arr.length === 0 ) {
		jQuery( '#all_terms .all' ).each(function(){
			op_term_html += jQuery( this ).outerHTML(); 
		});
	}
	else
	{
		var allow_blank_term = true;
		for( val in tax_arr)
		{	
			jQuery( '#all_terms .'+tax_arr[val] ).each(function(){
				if( jQuery( this ).val() == ''  )
				{
					if( allow_blank_term === true )
					{
						op_term_html += jQuery( this ).outerHTML(); 
						allow_blank_term = false;
					}
				}
				else
					op_term_html += jQuery( this ).outerHTML(); 
			});
		}
	}
	jQuery( '#rwss-repeater-item-holder .condition_term' ).html( op_term_html );			
}

function rwss_post_type_change()
{
	if( jQuery( 'input[name=slider-type]:checked' ).val() == 'cpt'  )
	{
		jQuery( '#rwss_cpt' ).show();
		jQuery( '#rwss_custom_meta_box' ).hide();
	}
	else
	{
		jQuery( '#rwss_cpt' ).hide();
		jQuery( '#rwss_custom_meta_box' ).show();
	}
	
}

jQuery(document).ready(function () {
	rwss_post_type_change();
	jQuery( 'input[name=slider-type]' ).change(function(){
		rwss_post_type_change();
	});
	
	//Start for Desc length show hide
	jQuery( "#display-description" ).on( "change", function() {
		if( jQuery( "#display-description" ).is(':checked') )
		{
			jQuery( "#description-max-length" ).closest( 'tr' ).slideDown();
		}
		else
		{
			jQuery( "#description-max-length" ).closest( 'tr' ).slideUp();
		}
	});
	jQuery( "#display-description" ).trigger( 'change' );
	//End for Desc length show hide
	
	//Start for link new tab show hide
	jQuery( "#add-link-url" ).on( "change", function() {
		if( jQuery( "#add-link-url" ).is(':checked') )
		{
			jQuery( "#link-new-tab" ).closest( 'tr' ).slideDown();
		}
		else
		{
			jQuery( "#link-new-tab" ).closest( 'tr' ).slideUp();
		}
	});
	jQuery( "#add-link-url" ).trigger( 'change' );
	//End for link new tab show hide
	
	
	
	rwss_post_types_change( '0' );
	
	//For Condition repeater
	jQuery( '#post-types' ).change( function() {
		rwss_post_types_change( '1' );
	});
	jQuery( '.rwss-repeater-add' ).click(function(){
		var rwss_is_add_allow = true;
		jQuery( '.rwss-repeater-item-list select').each( function(){
			if( jQuery(this).val() == '' )
			{
				rwss_is_add_allow = false;
			}
		});
		
		if( rwss_is_add_allow )
		{	
			var rwss_item = jQuery( '#rwss-repeater-item-holder' ).html();
			jQuery( '.rwss-repeater-item-list' ).append( rwss_item );
		}
		else
		{
			alert( rwss_vars.add_empty_error_msg  );
		}
	});    
	
	jQuery( ".rwss-repeater-item-list" ).on( "click", ".rwss-repeater-delete", function() {
		jQuery(this).closest('.rwss-repeater-item').remove();
	});
	
	jQuery( ".rwss-repeater-item-list" ).on( "change", ".condition_tax", function() {
		var tax_val = jQuery( this ).val();
		
		var item_cont = jQuery( this ).closest( '.rwss-repeater-item' );
		var filter_opt_html = '';
		if(  tax_val.length > 0 )
		{
			jQuery( '#rwss-repeater-item-holder .condition_term .'+tax_val ).each( function(elem){
				filter_opt_html += jQuery( this ).outerHTML();
			});
		}
		else
		{
			jQuery( '#rwss-repeater-item-holder .condition_term .all' ).each( function(elem){
				filter_opt_html += jQuery( this ).outerHTML();
			});	
		}
		jQuery( '.condition_term', item_cont ).html( filter_opt_html );
	});
	
	/*
	 * Start for Seperate Custom Slider
	*/
	jQuery( '.rwss-custom-repeater-add' ).click(function(){
			var rwss_custom_item = jQuery( '#rwss-custom-repeater-item-holder' ).html();
			jQuery( '.rwss-custom-repeater-item-list' ).append( rwss_custom_item );
	});    
	
	jQuery( ".rwss-custom-repeater-item-list" ).on( "click", ".rwss-custom-repeater-delete", function() {
		jQuery(this).closest('.rwss-custom-repeater-item').remove();
	});
	  
	// ADD IMAGE LINK	
	
  jQuery(document).on( 'click', '.rwss_image_button', function( event ){    
  	event.preventDefault();
	var frame;
	var custom_item_container;
	custom_item_container = jQuery( this ).closest('.rwss-custom-repeater-item')
    
    // If the media frame already exists, reopen it.
    if ( frame ) {
      frame.open();
      return;
    }
    
    // Create a new media frame
    frame = wp.media({
      title: 'Select or Upload Media Of Your Chosen Persuasion',
      button: {
        text: 'Use this Image'
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });

    
    // When an image is selected in the media frame...
    frame.on( 'select', function() {
      
      // Get media attachment details from the frame state
      var attachment = frame.state().get('selection').first().toJSON();

      // Send the attachment URL to our custom image input field.
	  jQuery('.image-preview', custom_item_container).removeAttr('src').attr( 'src', attachment.url );

      // Send the attachment id to our hidden input
      jQuery('.slide_image_id', custom_item_container).val( attachment.id );

    });

    // Finally, open the modal on click
    frame.open();
  });
  
  
  jQuery(".rwss-custom-repeater").on('keyup',".slider-title-input",function(){
	  var custom_item_cont = jQuery( this ).closest( '.rwss-custom-repeater-item' );
	  jQuery( '.rwss-custom-slide-title', custom_item_cont ).html( jQuery( this ).val() );
  });
  
  jQuery( ".rwss-custom-repeater-item-list" ).on( "click", ".rwss-custom-slide-title", function() {
		jQuery( this ).toggleClass( 'collapse' );
  });


});