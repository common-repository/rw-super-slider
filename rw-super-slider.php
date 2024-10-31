<?php
/*
Plugin Name: RW Super Slider
Description: RW Super Slider provides owl slider for custom post type as well as custom images.
Version: 1.0
Author: ahmed17
Author URI: http://www.reloadweb.co.uk/
Text Domain: rw-super-slider
Domain Path: /languages
License URI: http://www.gnu.org/licences/gpl-2.0.html
License: GPLv2 or later

Copyright 2017 ahmed17 (Reload Web)


	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
define( 'RWSS_VERSION', '1.0');
define( 'RWSS_URL', plugins_url( '', __FILE__ )); 
define( 'RWSS_ASSETS_URL', RWSS_URL . '/assets'); 
define( 'RWSS_PATH', plugin_dir_path( __FILE__ ));

require_once( RWSS_PATH . 'cpt.php' ); 
if( is_admin() )
{
	require_once( RWSS_PATH . 'cmb.php' );
	require_once( RWSS_PATH . 'custom-cmb.php' );
	require_once( RWSS_PATH . 'admin-editor.php' );
}
require_once( RWSS_PATH . 'front.php' );
require_once( RWSS_PATH . 'widget.php' );

add_action( 'init', 'rwss_load_textdomain' );
/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
function rwss_load_textdomain() {
  load_plugin_textdomain( 'rw-super-slider', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}
/**
 * Proper way to enqueue scripts and styles.
 */
function rwss_admin_enqueue($hook) {
	  if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
		global $post;
	    if ( 'rw_slider' === $post->post_type ) {  
			wp_enqueue_media();
		
			wp_enqueue_style( 'rwss-custom-admin',
							 RWSS_URL . '/css/custom-admin.css'
							 ,array(), RWSS_VERSION, 'all' );
		
			wp_enqueue_script( 'rwss-custom-admin',
							 RWSS_URL . '/js/custom-admin.js'
							 ,array('jquery'), RWSS_VERSION, true );
			wp_localize_script( 'rwss-custom-admin', 'rwss_vars', 
						array(
							'add_empty_error_msg' => esc_html__('Please fill all conditions and then try to add condition.', 'rw-super-slider'),
						)
			 );
		}
		else
		{
			wp_enqueue_style( 'rwss-custom-sc-admin',
							 RWSS_URL . '/css/custom-sc-admin.css'
							 ,array(), RWSS_VERSION , 'all' );		
		}
	}
}
add_action( 'admin_enqueue_scripts', 'rwss_admin_enqueue' );

add_action( 'admin_init', 'rwss_admin_init' );
function rwss_admin_init()
{
	add_action('in_admin_footer', 'rwss_admin_footer_add_dropdown');
}
function rwss_admin_footer_add_dropdown() {
	global $pagenow,$post;
	if( !( ( $pagenow == 'post-new.php' || $pagenow == 'post.php') && 'rw_slider' === $post->post_type) )
		return;
	?>
    <div id="rwss-repeater-item-holder" style="display:none;">
        <div class="rwss-repeater-item">
            <select name="condition[tax][]" class="condition_tax">
                <option value=""><?php esc_html_e('Select Taxonomy','rw-super-slider');?></option>
            </select>
            <select name="condition[operator][]"  class="condition_operator">
                <option value="IN" selected="selected"><?php esc_html_e('is equal to','rw-super-slider');?></option>
                <option value="NOT IN"><?php esc_html_e('is not equal to','rw-super-slider');?></option>
            </select>
            <select name="condition[term][]" class="condition_term">
                <option  value=""><?php esc_html_e('Select Term','rw-super-slider');?></option>
            </select>
            <input class="rwss-repeater-delete" type="button" value="<?php esc_html_e('Delete','rw-super-slider');?>"/>
        </div>
    </div>
    
    <div id="rwss-custom-repeater-item-holder" style="display:none;">
        <div class="rwss-custom-repeater-item">
        	<h3 class="rwss-custom-slide-title"><?php esc_html_e('New Slide', 'rw-super-slider');?></span></h3>
            <div class="rwss-custom-item-toggle">
                <input type="text" name="slides[title][]"  class="slider-title-input"  placeholder="Title" value="<?php esc_attr_e('New Slide', 'rw-super-slider');?>" />
                <textarea name="slides[description][]" placeholder="Description"></textarea>
                <input type="url" name="slides[link][]" placeholder="Link" value=""/>
                <input type="number" name="slides[order][]" placeholder="Order" value="" min="0" />
                
                 <div class="img-upload">
                    <img class='image-preview' src='<?php echo RWSS_URL.'/images/img-thumb.png';?>' height="75">
                    <input type="button" class="rwss_image_button button" 
                value="<?php esc_html_e( 'Upload image','rw-super-slider');?>" />
                    <input type="hidden" name="slides[image][]" class="slide_image_id" value="" />
                </div>
                
                <input class="rwss-custom-repeater-delete" type="button" value="<?php esc_html_e('Delete','rw-super-slider');?>"/>
            </div>
         </div>
    </div>
    <?php
}
if( !function_exists( 'pixlr_trim_text' ) ):
function rwss_trim_text($input, $length, $ellipses = true, $strip_html = true) {
	//strip tags, if desired
    if ($strip_html) {
        $input = strip_tags($input);
    }
  
    //no need to trim, already shorter than trim length
    if (mb_strlen($input) <= $length) {
        return $input;
    }
  
    //find last space within length
    $last_space = mb_strrpos(mb_substr($input, 0, $length), ' ');
    $trimmed_text = mb_substr($input, 0, $last_space);
	
    //add ellipses (...)
    if ($ellipses) {
        $trimmed_text .= esc_html__('...','rw-super-slider');
    }
  
    return $trimmed_text;
}
endif;
