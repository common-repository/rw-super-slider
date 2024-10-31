<?php
/**
 * Slider Type Metabox
 */
class RWSS_Slider_Type_Meta_Box {
	private $screens = array(
		'rw_slider',
	);
	private $fields = array();

	/**
	 * Class construct method. Adds actions to their respective WordPress hooks.
	 */
	 
	public function __construct() {
		
		global $_wp_additional_image_sizes;
		/*
		echo '<pre>';
print_r( self::get_image_sizes() );
echo '</pre>';
die;
*/
		/*
		Array
	(
		[thumbnail] => Array
			(
				[width] => 150
				[height] => 150
				[crop] => 1
			)
	
		[medium] => Array
			(
				[width] => 300
				[height] => 300
				[crop] => 
			)
	
		[medium_large] => Array
			(
				[width] => 768
				[height] => 0
				[crop] => 
			)
	
		[large] => Array
			(
				[width] => 1024
				[height] => 1024
				[crop] => 
			)
	
	)
		*/
	
		$image_sizes_md = self::get_image_sizes();
		$image_sizes = array();
		$image_sizes[''] = esc_html__('Origional','rw-super-slider');
		$size_sep = esc_html__(' x ','rw-super-slider');
		foreach( $image_sizes_md as $key=> $val )
		{
			$image_sizes[$key] = $key.' ('.$val['width'].$size_sep.$val['height'].')' ;
			
		}
		
		$this->fields = array(
					array(
						'id' => 'owl-items-0',
						'label' => esc_html__('No. Of Items on the Small Screen', 'rw-super-slider' ),
						'type' => 'number',
						'default' => 1, 
					),
					array(
						'id' => 'owl-items-600',
						'label' => esc_html__('No. Of Items on the Medium Screen', 'rw-super-slider' ),
						'type' => 'number',
						'default' => 2, 
					),
					array(
						'id' => 'owl-items-1000',
						'label' => esc_html__('No. Of Items on the Large Screen', 'rw-super-slider' ),
						'type' => 'number',
						'default' => 3, 
					),
					array(
						'id' => 'owl-margin',
						'label' => esc_html__('Margin Right(px) on item', 'rw-super-slider' ),
						'type' => 'number',
						'default' => 0, 
					),
					array(
						'id' => 'owl-loop',
						'label' => esc_html__('Infinity loop', 'rw-super-slider' ),
						'type' => 'radio',
						'options' => array(
							'yes' => esc_html__('Yes', 'rw-super-slider' ),
							'no' => esc_html__('No', 'rw-super-slider' ),
						),
						'default' => 'no', 
					),
					array(
						'id' => 'owl-center',
						'label' => esc_html__('Center item', 'rw-super-slider' ),
						'type' => 'radio',
						'options' => array(
							'yes' => esc_html__('Yes', 'rw-super-slider' ),
							'no' => esc_html__('No', 'rw-super-slider' ),
						),
						'default' => 'no', 
					),
					array(
						'id' => 'owl-mouseDrag',
						'label' => esc_html__('Mouse drag enabled', 'rw-super-slider' ),
						'type' => 'radio',
						'options' => array(
							'yes' => esc_html__('Yes', 'rw-super-slider' ),
							'no' => esc_html__('No', 'rw-super-slider' ),
						),
						'default' => 'yes', 
					),
					array(
						'id' => 'owl-touchDrag',
						'label' => esc_html__('Touch drag enabled', 'rw-super-slider' ),
						'type' => 'radio',
						'options' => array(
							'yes' => esc_html__('Yes', 'rw-super-slider' ),
							'no' => esc_html__('No', 'rw-super-slider' ),
						),
						'default' => 'yes', 
					),
					array(
						'id' => 'owl-pullDrag',
						'label' => esc_html__('Stage pull to edge', 'rw-super-slider' ),
						'type' => 'radio',
						'options' => array(
							'yes' => esc_html__('Yes', 'rw-super-slider' ),
							'no' => esc_html__('No', 'rw-super-slider' ),
						),
						'default' => 'yes', 
					),
					array(
						'id' => 'owl-freeDrag',
						'label' => esc_html__('Item pull to edge', 'rw-super-slider' ),
						'type' => 'radio',
						'options' => array(
							'yes' => esc_html__('Yes', 'rw-super-slider' ),
							'no' => esc_html__('No', 'rw-super-slider' ),
						),
						'default' => 'no', 
					),
					array(
						'id' => 'owl-stagePadding',
						'label' => esc_html__('Padding left and right on stage', 'rw-super-slider' ),
						'type' => 'number',
						'options' => array(
							'yes' => esc_html__('Yes', 'rw-super-slider' ),
							'no' => esc_html__('No', 'rw-super-slider' ),
						),
						'default' => '0', 
					),
					/*
					//Merge
					*/
					array(
						'id' => 'owl-autoWidth',
						'label' => esc_html__('Auto Width', 'rw-super-slider'),
						'type' => 'radio',
						'options' => array(
							'yes' => esc_html__('Yes', 'rw-super-slider' ),
							'no' => esc_html__('No', 'rw-super-slider' ),
						),
						'default' => 'no', 
					),
					//autoWidth
					array(
						'id' => 'owl-nav',
						'label' => esc_html__('Show Next/Prev Buttons', 'rw-super-slider' ),
						'type' => 'radio',
						'options' => array(
							'yes' => esc_html__('Yes', 'rw-super-slider' ),
							'no' => esc_html__('No', 'rw-super-slider' ),
						),
						'default' => 'no', 
					),
					//rewind
					//navText
					//navElement
					//slideBy
					array(
						'id' => 'owl-dots',
						'label' => esc_html__('Show dots navigation', 'rw-super-slider' ),
						'type' => 'radio',
						'options' => array(
							'yes' => esc_html__('Yes', 'rw-super-slider' ),
							'no' => esc_html__('No', 'rw-super-slider' ),
						),
						'default' => 'yes', 
					),
					//dotData
					
					array(
						'id' => 'owl-lazyLoad',
						'label' => esc_html__('Lazy load images', 'rw-super-slider' ),
						'type' => 'radio',
						'options' => array(
							'yes' => esc_html__('Yes', 'rw-super-slider' ),
							'no' => esc_html__('No', 'rw-super-slider' ),
						),
						'default' => 'no', 
					),
					array(
						'id' => 'display-title',
						'label' => esc_html__('Display Title', 'rw-super-slider' ),
						'type' => 'checkbox',
					),
					array(
						'id' => 'display-description',
						'label' => esc_html__('Display Description', 'rw-super-slider' ),
						'type' => 'checkbox',
					),
					array(
						'id' => 'description-max-length',
						'label' => esc_html__('Description Max. Length', 'rw-super-slider' ),
						'type' => 'number',
						'default' => 200
					),
					array(
						'id' => 'add-link-url',
						'label' => esc_html__('Add Link Url', 'rw-super-slider' ),
						'type' => 'checkbox',
					),
					array(
						'id' => 'link-new-tab',
						'label' => esc_html__('Open Link in New Tab', 'rw-super-slider' ),
						'type' => 'checkbox',
					),
					array(
						'id' => 'image-size',
						'label' => esc_html__('Image Size', 'rw-super-slider' ),
						'type' => 'select',
						'options' => $image_sizes,
						'default' => '', 
					),
					array(
						'id' => 'slider-type',
						'label' => esc_html__('Slider Configuration', 'rw-super-slider' ),
						'type' => 'radio',
						'options' => array(
							'cpt' => esc_html__('Post Type', 'rw-super-slider' ),
							'custom' => esc_html__('Slider', 'rw-super-slider' ),
						),
						'default' => 'cpt', 
						
					),
				);
		
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );
	}
	
	/**
	 * Get size information for all currently-registered image sizes.
	 *
	 * @global $_wp_additional_image_sizes
	 * @uses   get_intermediate_image_sizes()
	 * @return array $sizes Data for all currently-registered image sizes.
	 */
	function get_image_sizes() {
		global $_wp_additional_image_sizes;
	
		$sizes = array();
	
		foreach ( get_intermediate_image_sizes() as $_size ) {
			if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
				$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
				$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
				$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
				$sizes[ $_size ] = array(
					'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
					'height' => $_wp_additional_image_sizes[ $_size ]['height'],
					'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
				);
			}
		}
	
		return $sizes;
	}

	/**
	 * Hooks into WordPress' add_meta_boxes function.
	 * Goes through screens (post types) and adds the meta box.
	 */
	public function add_meta_boxes() {
		foreach ( $this->screens as $screen ) {
			add_meta_box(
				'slider-type',
				esc_html__( 'Slider Configuration', 'rw-super-slider' ),
				array( $this, 'add_meta_box_callback' ),
				$screen,
				'normal',
				'high'
			);
		}
	}

	/**
	 * Generates the HTML for the meta box
	 * 
	 * @param object $post WordPress post object
	 */
	public function add_meta_box_callback( $post ) {
		wp_nonce_field( 'slider_type_data', 'slider_type_nonce' );
		echo esc_html__('Please fill slider configuration options.', 'rw-super-slider');
		$this->generate_fields( $post );
	}

	/**
	 * Generates the field's HTML for the meta box.
	 */
	public function generate_fields( $post ) {
		$output = '';
		foreach ( $this->fields as $field ) {
			$label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
			$db_value = get_post_meta( $post->ID,  $field['id'], true );
			if( !$db_value && !empty( $field['default'] ) ){
				$db_value = $field['default'];
			}
		
			
			switch ( $field['type'] ) {
				case 'radio':
					$input = '<fieldset>';
					$input .= '<legend class="screen-reader-text">' . $field['label'] . '</legend>';
					$i = 0;
					foreach ( $field['options'] as $key => $value ) {
						$field_value = !is_numeric( $key ) ? $key : $value;
						$input .= sprintf(
							'<label><input %s id="%s" name="%s" type="radio" value="%s"> %s</label>%s',
							$db_value === $field_value ? 'checked' : '',
							$field['id'],
							$field['id'],
							$field_value,
							$value,
							$i < count( $field['options'] ) - 1 ? '<br>' : ''
						);
						$i++;
					}
					$input .= '</fieldset>';
					break;
				case 'checkbox':
					$input = sprintf(
						'<input %s id="%s" name="%s" type="checkbox" value="1">',
						$db_value === '1' ? 'checked' : '',
						$field['id'],
						$field['id']
					);
					break;
				case 'number':
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s" min="0">',
						$field['type'] !== 'color' ? 'class="regular-text"' : '',
						$field['id'],
						$field['id'],
						$field['type'],
						$db_value
					);
					break;
				case 'select':
					$input = sprintf(
						'<select id="%s" name="%s"  %s>',
						$field['id'],
						$field['id'],
						isset($field['multiple']) && $field['multiple'] ? 'multiple' :''
					);
					foreach ( $field['options'] as $key => $value ) {
						$field_value = !is_numeric( $key ) ? $key : $value;
						$input .= sprintf(
							'<option %s value="%s">%s</option>',
							$db_value === $field_value ? 'selected' : '',
							$field_value,
							$value
						);
					}
					$input .= '</select>';
					break;
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						$field['type'] !== 'color' ? 'class="regular-text"' : '',
						$field['id'],
						$field['id'],
						$field['type'],
						$db_value
					);
			}
			$output .= $this->row_format( $label, $input );
		}
		echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
	}

	/**
	 * Generates the HTML for table rows.
	 */
	public function row_format( $label, $input ) {
		return sprintf(
			'<tr><th scope="row">%s</th><td>%s</td></tr>',
			$label,
			$input
		);
	}
	/**
	 * Hooks into WordPress' save_post function
	 */
	public function save_post( $post_id ) {
		if ( ! isset( $_POST['slider_type_nonce'] ) )
			return $post_id;

		$nonce = $_POST['slider_type_nonce'];
		if ( !wp_verify_nonce( $nonce, 'slider_type_data' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		foreach ( $this->fields as $field ) {
			if ( isset( $_POST[ $field['id'] ] ) ) {
				switch ( $field['type'] ) {
					case 'email':
						$_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
						break;
					case 'text':
						$_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
						break;
				}
				update_post_meta( $post_id, $field['id'], $_POST[ $field['id'] ] );
			} else if ( $field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, $field['id'], '0' );
			}
		}
	}
}
new RWSS_Slider_Type_Meta_Box;

/**
 * CPT
 */
class RWSS_CPT {
	private $screens = array(
		'rw_slider',
	);
	private $fields = array();

	/**
	 * Class construct method. Adds actions to their respective WordPress hooks.
	 */
	public function __construct() {
		global $wp_post_types;
		
		$cpt_options = array();
		$types = get_post_types();
		foreach( $types as $type )
		{
			$typeobj = get_post_type_object( $type );
			if( post_type_supports( $type, 'thumbnail' ) )
			{
				$cpt_options[ $type ] = $typeobj->labels->name;
			}
		}
		$this->cpt_options = $cpt_options;

		
		$this->fields = array(
			array(
				'id' => 'post-types',
				'label' => esc_html__('Post Types', 'rw-super-slider' ),
				'type' => 'select',
				'options' => $cpt_options,
			),
			array(
				'id' => 'condition-rel',
				'label' => esc_html__('Condition Relationship', 'rw-super-slider' ),
				'type' => 'select',
				'options' => array(
					'AND' => esc_html__('AND', 'rw-super-slider' ),
					'OR' => esc_html__('OR', 'rw-super-slider' ),
				),
			),
			array(
				'id' => 'condition',
				'label' => esc_html__('Conditions', 'rw-super-slider' ),
				'type' => 'condition_repeater',
			),
			array(
				'id' => 'number-of-items',
				'label' => esc_html__('Number of Items', 'rw-super-slider' ),
				'type' => 'number',
			),
			array(
				'id' => 'include-post-ids',
				'label' => esc_html__('Include Post Ids', 'rw-super-slider' ),
				'type' => 'text',
			),
			array(
				'id' => 'exclude-post-ids',
				'label' => esc_html__('Exclude Post Ids', 'rw-super-slider' ),
				'type' => 'text',
			),
			
		);
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );
		
		
		add_action( 'in_admin_footer', array( $this, 'print_all_tax_term_select' ) );
		
	}

	/**
	 * Hooks into WordPress' add_meta_boxes function.
	 * Goes through screens (post types) and adds the meta box.
	 */
	public function add_meta_boxes() {
		foreach ( $this->screens as $screen ) {
			add_meta_box(
				'rwss_cpt',
				esc_html__( 'Post Type', 'rw-super-slider' ),
				array( $this, 'add_meta_box_callback' ),
				$screen,
				'normal',
				'high'
			);
		}
	}

	/**
	 * Generates the HTML for the meta box
	 * 
	 * @param object $post WordPress post object
	 */
	public function add_meta_box_callback( $post ) {
		wp_nonce_field( 'cpt_data', 'cpt_nonce' );
		esc_html_e('Please configure post type slider settings', 'rw-super-slider');
		$this->generate_fields( $post );
	}
	
	public function print_all_tax_term_select()
	{
		global $pagenow,$post;
		
		if( !( ( $pagenow == 'post-new.php' || $pagenow == 'post.php') && 'rw_slider' === $post->post_type) )
			return;
			
		
		$args = array( 
			'public'   => true,
		);	
		$taxonomies = get_taxonomies( $args , 'objects'); 
		$cpt_keys = array_keys($this->cpt_options);
		
		$valid_taxs = array(); 
		?>
        
        
        <select id="all_taxs" style="display:none;">
        	<option class="<?php echo implode( ' ', $cpt_keys );?>" value=""><?php esc_html_e('Select Taxonomy', 'rw-super-slider')  ;?></option>
        <?php
		foreach( $taxonomies as $tax_key=>$tax_val )
		{
			if( $tax_key == 'post_format' )
				continue;
			
			$res_ints = array(); 
			$res_ints = array_intersect($cpt_keys, $tax_val->object_type);
			if( count( $res_ints ) > 0 )
			{
			?>
            <option class="<?php echo implode( ' ', $tax_val->object_type ) ?>" 
            value="<?php echo $tax_key;?>"><?php echo $tax_val->labels->singular_name;?></option>
            <?php	
				$valid_taxs[] = $tax_key;
			}
		}
		?>
        </select>
        <?php
		$terms = get_terms( array(
			'taxonomy' => $valid_taxs,
			'hide_empty' => false,
		) );
		?>
		<select id="all_terms"  style="display:none;">
        <option class="<?php echo implode( ' ', $valid_taxs );?> all" value=""><?php esc_html_e('Select Term Value', 'rw-super-slider');?></option>
        <?php
		foreach( $terms as $term_val )
		{			
			?>
            <option class="<?php echo $term_val->taxonomy;?>" 
            value="<?php echo $term_val->slug;?>"><?php echo $term_val->name;?></option>
            <?php	
		}
		?>
        </select>
        <?php
	}

	/**
	 * Generates the field's HTML for the meta box.
	 */
	public function generate_fields( $post ) {
		$output = '';
		foreach ( $this->fields as $field ) {
			$label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
			$db_value = get_post_meta( $post->ID, 'cpt_' . $field['id'], true );
			switch ( $field['type'] ) {
				case 'condition_repeater':
					$input = '<div class="rwss-repeater">
									<div class="rwss-repeater-item-list">';
										if( !empty($db_value) && !empty($db_value['tax']) && !empty($db_value['operator']) && !empty($db_value['operator']))
										{	
											$cpt_type = get_post_meta( $post->ID, 'cpt_' . 'post-types', true );
											
											$cpt_type = 'post';
										
											$args = array( 
												'public'   => true,
												'object_type' => array( $cpt_type ),
											);	
											$cpt_tax = get_taxonomies( $args , 'objects');
											
											if( isset( $db_value['tax'] ) )
											{
												foreach( $db_value['tax'] as $key=>$tax_val )
												{
													
													$input .= '
			<div class="rwss-repeater-item">
				<select name="condition[tax][]" class="condition_tax">
					<option value="">'.esc_html('Select Taxonomy','rw-super-slider').'</option>';
					foreach( $cpt_tax  as $cpt_tax_key=>$cpt_tax_val )
					{
						if( $cpt_tax_key != 'post_format' )
						{
							$input .= '<option value="'.$cpt_tax_key.'" '.
							selected( $db_value['tax'][$key], $cpt_tax_key, false ).'>'.$cpt_tax_val->labels->name.'</option>';
						}
					}
				$input .= '</select>
				<select name="condition[operator][]" class="condition_operator">
					<option value="==" '.selected( $db_value['operator'][$key],'==',false).'>'.esc_html('is equal to','rw-super-slider').'</option>
					<option value="!=" '.selected( $db_value['operator'][$key],'!=',false).'>'.esc_html('is equal to','rw-super-slider').'</option>
				</select>
				<select name="condition[term][]" class="condition_term">
					<option value="">'.esc_html('Select Term','rw-super-slider').'</option>';
					
					$cpt_terms = get_terms( $db_value['tax'][$key],  array( 'hide_empty' => false ));
					foreach($cpt_terms as $cpt_term_key => $cpt_term_val)
					{
						$input .=  '<option  class="'.$cpt_term_val->taxonomy.'" 
            value="'.$cpt_term_val->slug.'"  '.selected( $db_value['term'][$key], $cpt_term_val->slug, false ).' >'.$cpt_term_val->name.'</option>';			
					}		
				$input .= '
				</select>
				<input class="rwss-repeater-delete" type="button" value="Delete">
			</div>
													
													';
												}
											
											}
											
										}									
						$input .= '</div>	
									<input class="rwss-repeater-add button button-primary button-large" type="button" value="'.
									esc_html__( 'Add', 'rw-super-slider')
									.'"/>
									
								</div>
							  ';
					break;
				case 'checkbox':
					$input = sprintf(
						'<input %s id="%s" name="%s" type="checkbox" value="1">',
						$db_value === '1' ? 'checked' : '',
						$field['id'],
						$field['id']
					);
					break;
				case 'select':
					$input = sprintf(
						'<select id="%s" name="%s"  %s>',
						$field['id'],
						$field['id'],
						isset($field['multiple']) && $field['multiple'] ? 'multiple' :''
					);
					foreach ( $field['options'] as $key => $value ) {
						$field_value = !is_numeric( $key ) ? $key : $value;
						$input .= sprintf(
							'<option %s value="%s">%s</option>',
							$db_value === $field_value ? 'selected' : '',
							$field_value,
							$value
						);
					}
					$input .= '</select>';
					break;
				
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						$field['type'] !== 'color' ? 'class="regular-text"' : '',
						$field['id'],
						$field['id'],
						$field['type'],
						$db_value
					);
			}
			$output .= $this->row_format( $label, $input );
		}
		echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
	}

	/**
	 * Generates the HTML for table rows.
	 */
	public function row_format( $label, $input ) {
		return sprintf(
			'<tr><th scope="row">%s</th><td>%s</td></tr>',
			$label,
			$input
		);
	}
	/**
	 * Hooks into WordPress' save_post function
	 */
	public function save_post( $post_id ) {
		if ( ! isset( $_POST['cpt_nonce'] ) )
			return $post_id;

		$nonce = $_POST['cpt_nonce'];
		if ( !wp_verify_nonce( $nonce, 'cpt_data' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		foreach ( $this->fields as $field ) {
			
			if( $field['id'] == 'condition')
			{
				if ( isset( $_POST[ $field['id'] ] ) ) 
				{
					$save_condition = array();
					foreach( $_POST[ $field['id'] ]['tax'] as $key=>$tax_val )
					{
						if( 
							!empty($_POST[ $field['id'] ]['tax']) 
							&&
							!empty($_POST[ $field['id'] ]['operator'])
							&&
							!empty($_POST[ $field['id'] ]['term']) 
						)
						{
							$save_condition['tax']		= 	$_POST[ $field['id'] ]['tax'];
							$save_condition['operator']   =	$_POST[ $field['id'] ]['operator'];
							$save_condition['term']	   =	$_POST[ $field['id'] ]['term'];
						}
					}
					update_post_meta( $post_id, 'cpt_' . $field['id'], $save_condition);
				}
				else
				{
					update_post_meta( $post_id, 'cpt_' . $field['id'], array());
				}
			
			}
			else
			{
				if ( isset( $_POST[ $field['id'] ] ) ) {
					switch ( $field['type'] ) {
						case 'email':
							$_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
							break;
						case 'text':
							$_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
							break;
					}
					update_post_meta( $post_id, 'cpt_' . $field['id'], $_POST[ $field['id'] ] );
				} else if ( $field['type'] === 'checkbox' ) {
					update_post_meta( $post_id, 'cpt_' . $field['id'], '0' );
				}
			}
			
		}
	}
}
add_action( 'init', 'rwss_add_cpt_cmb' );
function rwss_add_cpt_cmb()
{
	new RWSS_CPT;
}
