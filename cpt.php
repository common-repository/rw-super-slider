<?php
// Register Custom Post Type
function rwss_register_cpt() {
	$labels = array(
		'name'                  => _x( 'RW Sliders', 'Post Type General Name', 'rw-super-slider' ),
		'singular_name'         => _x( 'RW Slider', 'Post Type Singular Name', 'rw-super-slider' ),
		'menu_name'             => __( 'RW Sliders', 'rw-super-slider' ),
		'name_admin_bar'        => __( 'RW Slider', 'rw-super-slider' ),
		'archives'              => __( 'Item Archives', 'rw-super-slider' ),
		'all_items'             => __( 'All RW Slide', 'rw-super-slider' ),
		'add_new_item'          => __( 'Add New RW Slider', 'rw-super-slider' ),
		'add_new'               => __( 'New RW Slider', 'rw-super-slider' ),
		'new_item'              => __( 'New RW Slider', 'rw-super-slider' ),
		'edit_item'             => __( 'Edit RW Slider', 'rw-super-slider' ),
		'update_item'           => __( 'Update RW Slider', 'rw-super-slider' ),
		'view_item'             => __( 'View RW Slider', 'rw-super-slider' ),
		'view_items'            => __( 'View RW Sliders', 'rw-super-slider' ),
		'search_items'          => __( 'Search RW Slider', 'rw-super-slider' ),
		'not_found'             => __( 'Not found', 'rw-super-slider' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'rw-super-slider' ),
		'featured_image'        => __( 'Featured Image', 'rw-super-slider' ),
		'set_featured_image'    => __( 'Set featured image', 'rw-super-slider' ),
		'remove_featured_image' => __( 'Remove featured image', 'rw-super-slider' ),
		'use_featured_image'    => __( 'Use as featured image', 'rw-super-slider' ),
		'insert_into_item'      => __( 'Insert into RW Slider', 'rw-super-slider' ),
		'uploaded_to_this_item' => __( 'Uploaded to this RW Slider', 'rw-super-slider' ),
		'items_list'            => __( 'Items list', 'rw-super-slider' ),
		'items_list_navigation' => __( 'Items list navigation', 'rw-super-slider' ),
		'filter_items_list'     => __( 'Filter items list', 'rw-super-slider' ),
	);
	$args = array(
		'label'                 => __( 'RW Slider', 'rw-super-slider' ),
		'description'           => __( 'RW Slider is custom post type of RW Super Slider Plugin', 'rw-super-slider' ),
		'labels'                => $labels,
		'supports'              => array( 'title', ),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 60,
		'menu_icon'             => 'dashicons-images-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,		
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);
	register_post_type( 'rw_slider', $args );
}
add_action( 'init', 'rwss_register_cpt', 0 );

/**
 * RW Slider update messages.
 *
 * See /wp-admin/edit-form-advanced.php
 *
 * @param array $messages Existing post update messages.
 *
 * @return array Amended post update messages with new CPT update messages.
 */
function rwss_cpt_updated_messages( $messages ) {
	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );

	$messages['rw_slider'] = array(
		0  => '', // Unused. Messages start at index 1.
		1  => __( 'RW Slider updated.', 'rw-super-slider' ),
		2  => __( 'Custom field updated.', 'rw-super-slider' ),
		3  => __( 'Custom field deleted.', 'rw-super-slider' ),
		4  => __( 'RW Slider updated.', 'rw-super-slider' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'RW Slider restored to revision from %s', 'rw-super-slider' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => __( 'RW Slider published.', 'rw-super-slider' ),
		7  => __( 'RW Slider saved.', 'rw-super-slider' ),
		8  => __( 'RW Slider submitted.', 'rw-super-slider' ),
		9  => sprintf(
			__( 'RW Slider scheduled for: <strong>%1$s</strong>.', 'rw-super-slider' ),
			// translators: Publish box date format, see http://php.net/date
			date_i18n( __( 'M j, Y @ G:i', 'rw-super-slider' ), strtotime( $post->post_date ) )
		),
		10 => __( 'RW Slider draft updated.', 'rw-super-slider' )
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'rwss_cpt_updated_messages' );