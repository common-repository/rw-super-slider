<?php
/**
 * Register meta box(es).
 */
function rwss_register_custom_meta_box() {
    add_meta_box( 'rwss_custom_meta_box', esc_html__( 'Custom Slider', 'rw-super-slider' ), 'rwss_custom_meta_box_callback', 'rw_slider' );
}
add_action( 'add_meta_boxes', 'rwss_register_custom_meta_box' );

function rwss_custom_meta_box_callback()
{
	global $post;
	$slides = get_post_meta( $post->ID, 'slides', true );
	?>
    <div class="inside">
		<?php esc_html_e('Please configure custom post type slider settings','rw-super-slider');?>
		<table class="form-table">
        	<tbody>
            	<tr>
                	<th scope="row">
		                <label for="slides"><?php esc_html_e('Slides','rw-super-slider');?></label>
                    </th>
                	<td>
                        <div class="rwss-custom-repeater">
                            <div class="rwss-custom-repeater-item-list">
                            	<?php
								if( !empty( $slides['order'] ) ):
								$count = 0;
				                foreach($slides['order'] as $key=>$title_val)
								{
									$count++;
									?>
                                    <div class="rwss-custom-repeater-item">
                                    <h3 class="rwss-custom-slide-title <?php if($count != 1):?>collapse<?php endif;?>">
									<?php 
									if( !empty($slides['title'][$key]) )  
									{
										echo esc_html( $slides['title'][$key] );
									}
									else
									{
										esc_html_e('New Slide', 'rw-super-slider');
									}
									?>
									</h3>
                                    <div class="rwss-custom-item-toggle">
                                        <input type="text" name="slides[title][]" class="slider-title-input" placeholder="Title" value="<?php echo 
                                        !empty($slides['title'][$key])?esc_html($slides['title'][$key]):'';?>" />
                                        <textarea name="slides[description][]" placeholder="Description"><?php echo !empty($slides['description'][$key])?esc_html($slides['description'][$key]):'';?></textarea>
                                        <input type="url" name="slides[link][]" placeholder="Link" value="<?php echo !empty($slides['link'][$key])?esc_html($slides['link'][$key]):'';?>" />
                                        <input type="number" name="slides[order][]" placeholder="Order" value="<?php echo !empty($slides['order'][$key])?esc_html($slides['order'][$key]):'';?>"  min="0"/>
                                        <?php
                                        $img_src  = wp_get_attachment_url( intval( $slides['image'][$key] ) );
                                        ?>
                                        <div class="img-upload">
                                            <img class='image-preview' src='<?php echo esc_url($img_src);?>' height='100'>
                                            <input type="button" class="rwss_image_button button" value="<?php esc_html_e( 'Upload image','rw-super-slider'); ?>" />	
                                            <input type="hidden" name="slides[image][]" class="slide_image_id" value="<?php echo esc_html(intval( $slides['image'][$key] ));?>" />
                                        </div>
                                        <input class="rwss-custom-repeater-delete" type="button" value="<?php esc_html_e('Delete','rw-super-slider');?>"/>
                                        </div>
                                    </div>
									<?php
								}
								endif;
								?>
                            </div>	
                            <input class="rwss-custom-repeater-add button button-primary button-large" type="button" value="Add" />                        </div>
                  </td>
             </tr>
             </tbody>
          </table>
    </div>	
    <?php
}

add_action( 'save_post_rw_slider', 'rwss_custom_meta_box_save' );
function rwss_custom_meta_box_save( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;
	
	$new_slides = array();
	if ( isset( $_POST[ 'slides' ] ) ) {
		foreach( $_POST[ 'slides' ]['title'] as $key=>$field_val )
		{
			if( !empty(   $_POST[ 'slides' ]['title'][ $key ] ) && intval( $_POST[ 'slides' ]['image'][$key] ) )
			{
				$new_slides['title'][]       =  sanitize_text_field($_POST[ 'slides' ]['title'][ $key ]);
				$new_slides['description'][] =  esc_textarea( $_POST[ 'slides' ]['description'][ $key ] );
				$new_slides['link'][] 		=  sanitize_text_field($_POST[ 'slides' ]['link'][ $key ]);
				$new_slides['order'][] 	   =  intval( sanitize_text_field($_POST[ 'slides' ]['order'][ $key ]));
				$new_slides['image'][] 	   =  intval( sanitize_text_field($_POST[ 'slides' ]['image'][ $key ]) );
			}
		}
	}
	
	update_post_meta( $post_id, 'slides', $new_slides);
}