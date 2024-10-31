<?php
class RWSS_Front {
	public static function render_shortcode( $atts, $content = "" ) {
		$atts = shortcode_atts( array(
			'id' => 0,
		), $atts, 'rwss_slider' );
		
		if( intval($atts[ 'id' ]) == 0)
			return  '';
			
		$id = intval($atts[ 'id' ]);
		return self::render_slider( $id, $echo = false);		
	}
	public static function render_slider( $id , $echo = true) {
		
		if( intval(  $id ) == 0 )
			return ;
		
		global $rwss_id_count;
		if( empty($rwss_id_count) )
		{
			$rwss_id_count = 1;
		}
		else
		{
			$rwss_id_count++; 
		}
		
		$cont_id = 'cont_'.$id.'_'.$rwss_id_count;
		$items_0 =  get_post_meta( $id, 'owl-items-0', true) || get_post_meta( $id, 'owl-items-0', true) == 0 ? get_post_meta( $id, 'owl-items-0', true) : 1;
		$items_600 =  get_post_meta( $id, 'owl-items-600', true) || get_post_meta( $id, 'owl-items-600', true) == 0 ? get_post_meta( $id, 'owl-items-600', true) : 2;
		$items_1000 =  get_post_meta( $id, 'owl-items-1000', true) ? get_post_meta( $id, 'owl-items-1000', true) : 3;
		
		$loop =  get_post_meta( $id, 'owl-loop', true) == 'yes'?1:0;
		$margin =  get_post_meta( $id, 'owl-margin', true) || get_post_meta( $id, 'owl-margin', true) == 0 ? get_post_meta( $id, 'owl-margin', true) : 0;
		$center =  get_post_meta( $id, 'owl-center', true) == 'yes'?1:0;
		$mouseDrag =  get_post_meta( $id, 'owl-mouseDrag', true) == 'yes'?1:0;
		$touchDrag =  get_post_meta( $id, 'owl-touchDrag', true) == 'yes'?1:0;
		$pullDrag =  get_post_meta( $id, 'owl-pullDrag', true) == 'yes'?1:0;
		$freeDrag =  get_post_meta( $id, 'owl-freeDrag', true) == 'yes'?1:0;
		$stagePadding = get_post_meta( $id, 'owl-stagePadding', true) || get_post_meta( $id, 'owl-stagePadding', true) == 0 ? get_post_meta( $id, 'owl-stagePadding', true) : 0;
		$autoWidth = get_post_meta( $id, 'owl-autoWidth', true) == 'yes'?1:0;
		$nav = get_post_meta( $id, 'owl-nav', true) == 'yes'?1:0;
		$dots = get_post_meta( $id, 'owl-dots', true) == 'yes'?1:0;
		$lazyLoad = get_post_meta( $id, 'owl-lazyLoad', true) == 'yes'?1:0;
		
		
		wp_enqueue_script('owl-carousel' );
		wp_enqueue_style( 'owl-carousel');
		wp_enqueue_style( 'owl-default-theme' );
		wp_enqueue_style( 'rwss-custom-front' );
		
		wp_add_inline_script(
		'owl-carousel',
		'
        jQuery(document).ready(function(){
          jQuery("#'.$cont_id.'").owlCarousel({
			margin : '.intval( $margin ).', 
		  	loop: '.$loop.',
			center: '.$center.',
			mouseDrag: '.$mouseDrag.',
			touchDrag: '.$touchDrag.',
			pullDrag: '.$pullDrag.',
			freeDrag: '.$freeDrag.',
			stagePadding: '.$stagePadding.',
			autoWidth: '.$autoWidth.',
			nav: '.$nav.',
			dots: '.$dots.',
			lazyLoad: '.$lazyLoad.',
			responsive:{
				0:{
					items:'.intval( $items_0 ).',
				},
				600:{
					items:'.intval( $items_600 ).',
				},
				1000:{
					items:'.intval( $items_1000 ).',
				}
			}
		  });
        });'
		,
		$position = 'after'
		);
		$image_size = get_post_meta( $id, 'image-size', true);
		ob_start();
		do_action('rwss_before_slider');
		
		$main_classes = 'owl-carousel owl-theme';
		if(intval( $items_1000 ) > 1)
		{
			$main_classes .= ' rwss-owl-multiple';
		}

		?>	
		<div id="<?php echo esc_attr($cont_id);?>" class="<?php echo apply_filters('rwss_item_class_filter',$main_classes,$id);?>">
        	<?php
			if( get_post_meta($id, 'slider-type', true) == 'cpt' )
			{
				$post_type = get_post_meta($id, 'cpt_post-types', true);
				
				$args = array();
				$args['post_type'] = $post_type;
				
				$condition = get_post_meta($id, 'cpt_condition', true);
				if( !empty( $condition['tax'] ) )
				{
					foreach( $condition['tax'] as $tax_key=>$tax_val )
					{
						if( !empty( $condition['tax'][$tax_key] ) && !empty( $condition['operator'][$tax_key] )  && !empty( $condition['term'][$tax_key] ) )
						{
							$args['tax_query'][] = array(
											'taxonomy' => $condition['tax'][$tax_key],
											'field'    => 'slug',
											'terms'    => array($condition['term'][$tax_key]),			
											'operator' => $condition['operator'][$tax_key],
										);			
						}
					}
				}
				if( !empty( $args['tax_query'] ) && get_post_meta($id, 'cpt_condition-rel', true) )
				{
					$args['tax_query']['relation'] = get_post_meta($id, 'cpt_condition-rel', true);
				}
				
				$limit = intval( get_post_meta($id, 'cpt_number-of-items', true) );
				if( $limit > 0 )
				{
					$args['posts_per_page'] = $limit;
				}
				else
				{
					$args['posts_per_page'] = -1;
				}
				
				$include_ids_str =  get_post_meta($id, 'cpt_include-post-ids', true);
				if( !empty( $include_ids_str ) )
				{
					$include_ids_arr = explode( ',',$include_ids_str);
					$include_ids_arr =  array_filter( $include_ids_arr );
					$include_ids_arr =  array_filter( $include_ids_arr, 'intval' );
					$include_ids_arr =  array_map( 'intval' ,  $include_ids_arr);
					if( is_array( $include_ids_arr ) && count( $include_ids_arr ) > 0 )	
					{
						$args['post__in'] = $include_ids_arr; 	
					}
				}
				
				
				$exclude_ids_str =  get_post_meta($id, 'cpt_exclude-post-ids', true);
				if( !empty( $exclude_ids_str ) )
				{
					$exclude_ids_arr = explode( ',',$exclude_ids_str);
					$exclude_ids_arr =  array_filter( $exclude_ids_arr );
					$exclude_ids_arr =  array_filter( $exclude_ids_arr, 'intval' );
					$exclude_ids_arr =  array_map( 'intval' ,  $exclude_ids_arr);
					if( is_array( $exclude_ids_arr ) && count( $exclude_ids_arr ) > 0 )	
					{
						$args['post__not_in'] = $exclude_ids_arr; 	
					}
				}
				
				$args['post_status'] = 'publish';
				
			
				
				$args = apply_filters( 'rwss_post_query', $args, $id );
				
				$the_query = new WP_Query(  $args );
				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						if( !empty($image_size) )
						{
							$img_arr = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $image_size);
							$img_src = $img_arr[0];
							}
						else
						{
							$img_src = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
						}						
						?>
							<div class="<?php echo apply_filters('rwss_item_class_filter','item',$id);?>">
                            	<?php if( get_post_meta($id, 'add-link-url', true) ) {?>
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>" <?php if( get_post_meta($id, 'link-new-tab', true) ):?>target="_blank"<?php endif;?>>
								<?php }                             	
								if( !empty( $img_src ) ):
								?>
                                <img src="<?php echo esc_url($img_src);?>" alt="<?php the_title_attribute();?>"/>
                                <?php 
								endif;
								
								if( get_post_meta($id, 'display-title', true) )
								{
									the_title( '<h3>', '</h3>', true);
								}
								if( get_post_meta($id, 'display-description', true) )
								{
									$excerpt = get_the_excerpt();
									$length = intval( get_post_meta($id, 'description-max-length', true) );
									?>
                                    <p>
									<?php echo rwss_trim_text($excerpt, $length);?>
                                    </p>
                                    <?php
								}
								?>
                                <?php if( get_post_meta($id, 'add-link-url', true) ) {?>
								</a>
								<?php } ?>
                            </div>	
                        <?php
						
					}
					wp_reset_postdata();
				} 
			}
			elseif( get_post_meta($id, 'slider-type', true) == 'custom' )
			{
				$slides = get_post_meta($id, 'slides', true);
				if( !empty( $slides ) && !empty( $slides['title'] ))
				{
					$slides_arr = array();
					
					asort($slides['order']);
					foreach( $slides['order'] as $order_key=>$order_val )
					{?>
						<div class="<?php echo apply_filters('rwss_item_class_filter','item',$id);?>">
                        <?php
						if( get_post_meta($id, 'add-link-url', true)  && !empty($slides['link'][$order_key])) {?>
							<a href="<?php echo esc_url($slides['link'][$order_key]);?>" title="<?php echo esc_attr( $slides['title'][$order_key]);?>" <?php if( get_post_meta($id, 'link-new-tab', true) ):?>target="_blank"<?php endif;?>>
						<?php } 
						if( !empty($image_size) )
						{
							$img_arr = wp_get_attachment_image_src( intval( $slides['image'][$order_key] ), $image_size);
							$img_src = $img_arr[0];
						}
						else
						{						
							$img_src  = wp_get_attachment_url( intval( $slides['image'][$order_key] ) );
						}
						if( !empty( $img_src ) ):
						?>
						<img src="<?php echo esc_url($img_src);?>" alt="<?php echo esc_attr( $slides['title'][$order_key]);?>"/>					
						<?php
						endif;
						if( get_post_meta($id, 'display-title', true) && !empty($slides['title'][$order_key]) )
						{
							echo  '<h3>'.esc_html( $slides['title'][$order_key] ).'</h3>';
						}
                        if( get_post_meta($id, 'display-description', true) && !empty($slides['description'][$order_key]) )
						{
							$excerpt = esc_html($slides['description'][$order_key]);
							$length = intval( get_post_meta($id, 'description-max-length', true) );
							?>
							<p>
							<?php echo rwss_trim_text($excerpt, $length);?>
							</p>
							<?php
						}
						?>
						<?php if( get_post_meta($id, 'add-link-url', true)  && !empty($slides['link'][$order_key])) {?>
                        </a>
                        <?php } 
						?>
						</div>
                        <?php
					}
				}
			}
		   ?>
		</div>
		<?php
		do_action('rwss_after_slider');
		$content = ob_get_clean();
		$content =  apply_filters('rwss_render_output', $content, $id);
		if( $echo  )
		{
			echo $content;
		}
		else
		{
			return $content;
		}
		
	}
}
add_shortcode( 'rwss_slider', 'RWSS_Front::render_shortcode');
function rwss_front_scripts() {
	wp_register_script('owl-carousel', RWSS_ASSETS_URL.'/owl/owl.carousel.min.js', array('jquery'), '2.2.1', true);
	wp_register_style( 'owl-carousel', RWSS_ASSETS_URL.'/owl/owl.carousel.min.css', array(), '2.2.1', 'all' );
	wp_register_style( 'owl-default-theme', RWSS_ASSETS_URL.'/owl/owl.theme.default.min.css', array( 'owl-carousel' ), '2.2.1', 'all' );
	wp_register_style( 'rwss-custom-front', RWSS_URL.'/css/custom-front.css', array('owl-default-theme','owl-carousel'), RWSS_VERSION, 'all' );
}
add_action ('wp_enqueue_scripts', 'rwss_front_scripts');