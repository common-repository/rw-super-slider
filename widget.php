<?php 
/**
 * Adds RWSS_Widget widget.
 */
class RWSS_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'rwss_widget', // Base ID
			esc_html__( 'RWSS Slider', 'rw-super-slider' ), // Name
			array( 'description' => esc_html__( 'Displays RW Slider', 'rw-super-slider' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		if ( intval( $instance['slider_id'] ) > 0 ) {
			RWSS_Front::render_slider( $instance['slider_id'] );
		}
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Slider', 'rw-super-slider' );
		$slider_id = ! empty( $instance['slider_id'] ) ? $instance['slider_id'] : '';
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'rw-super-slider' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        <p>
         <?php
		 $args = array(
		 				'post_type' => 'rw_slider',
						'post_status' => 'publish',
		 );
		 $the_query = new WP_Query( $args );
		 if ( $the_query->have_posts() ) {
			 ?>
        
		<label for="<?php echo esc_attr( $this->get_field_id( 'slider_id' ) ); ?>"><?php esc_attr_e( 'Slider:', 'rw-super-slider' ); ?></label> 
		<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'slider_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'slider_id' ) ); ?>">
        	 <?php
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
			?>    
				<option value="<?php echo get_the_ID();?>" <?php selected( $slider_id, get_the_ID() );?>><?php echo get_the_title();?></option>
			<?php
			}
			?>
        </select>
        <?php
		 }
		 else
		 {
        
				esc_html_e('You have not added any RW Slider yet. To add RW slider please ');?><a href="<?php echo admin_url('post-new.php?post_type=rw_slider');?>">
					<?php esc_html_e('click here','rw-super-slider');?></a>
         <?php
		 }
		 ?>
                          
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['slider_id'] = ( ! empty( $new_instance['slider_id'] ) ) ? intval( $new_instance['slider_id'] ) : '';

		return $instance;
	}

} // class For Widget
function rwss_register_widgets() {
	register_widget( 'RWSS_Widget' );
}
add_action( 'widgets_init', 'rwss_register_widgets' );