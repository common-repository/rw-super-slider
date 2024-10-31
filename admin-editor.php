<?php
/*Add this code to your functions.php file of current theme OR plugin file if you're making a plugin*/
//add the button to the tinymce editor
add_action('media_buttons_context','rwss_add_tinymce_media_button');
function rwss_add_tinymce_media_button($context){
return $context.= "
	<a href=\"#TB_inline?width=300&inlineId=rwss_shortcode_popup&height=400\" class=\"insert_rw_slider_button thickbox\" id=\"rwss_shortcode_popup_button\" title=\"".esc_attr__('Add RW Slider','rw-super-slider')."\">".esc_html__('Add RW Slider','rw-super-slider')."</a>";
}
add_action('admin_footer','rwss_shortcode_media_button_popup');
//Generate inline content for the popup window when the "my shortcode" button is clicked
function rwss_shortcode_media_button_popup(){?>
  <div id="rwss_shortcode_popup" style="display:none;">
    <--".wrap" class div is needed to make thickbox content look good-->
    <div class="wrap">
      <div>
        <h2><?php esc_html_e('Insert RW Slider','rw-super-slider');?></h2>
        <div class="my_shortcode_add">
        
         <?php
		 $args = array(
		 				'post_type' => 'rw_slider',
						'post_status' => 'publish',
		 );
		 $the_query = new WP_Query( $args );
		 if ( $the_query->have_posts() ) {
		 ?>
         <br>
             <select id="rw_slider_sc_tb">
                    <?php
                    while ( $the_query->have_posts() ) {
                        $the_query->the_post();
                    ?>    
                        <option value="<?php echo get_the_ID();?>"><?php echo get_the_title();?></option>
                    <?php
                    }
                    ?>
             </select>
         	 
          	<button class="button-primary" id="rwss_add_sc_btn"><?php esc_html_e('Add RW Slider','rw-super-slider');?></button>
          <?php
			}
			else
			{
			?>
				<p>
				<?php esc_html_e('You have not added any RW Slider yet. To add RW slider please ');?><a href="<?php echo admin_url('post-new.php?post_type=rw_slider');?>">
					<?php esc_html_e('click here','rw-super-slider');?></a>
                </p>            
            <?php 
			}
			?>
        </div>
      </div>
    </div>
  </div>
<?php
}
//javascript code needed to make shortcode appear in TinyMCE edtor
add_action('admin_footer','rwss_shortcode_add_shortcode_to_editor');
function rwss_shortcode_add_shortcode_to_editor(){
	global $pagenow;
	
	if( !( 'post.php' != $pagenow || 'post-new.php' != $pagenow) )
		return;
?>
<script>
jQuery(document).ready( function(){
	jQuery('#rwss_add_sc_btn ').on('click',function( evt ){
	  evt.preventDefault();	
	  var user_content = jQuery('#rw_slider_sc_tb').val();
	  var shortcode = '[rwss_slider id="'+user_content+'"]';
	  if( !tinyMCE.activeEditor || tinyMCE.activeEditor.isHidden()) {
			send_to_editor( shortcode );
	  } else {
		send_to_editor( shortcode );
	  }
	   self.parent.tb_remove();
	});
});
</script>
<?php
}