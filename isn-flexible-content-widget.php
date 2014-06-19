<?php
/*
Plugin Name: Flexible Content Widget
Description: A widget for content which is flexible.
Plugin URI: http://www.bigspring.co.uk
Author: dave@bigspring
*/

add_action('widgets_init', function() {
	register_widget('FlexibleContentWidget');
});

// Create the widget
class FlexibleContentWidget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		// widget actual processes
		parent::__construct(
			'flexible_content_widget',
			__('Flexible Content Widget', 'thing'),
			array('description' => __('A widget for content which is flexible.', 'thing'), )
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget

		// setup widget vars
		$title = apply_filters( 'flexible_content_widget', $instance['title'] );
		$sub_title = apply_filters( 'flexible_content_widget', $instance['sub_title'] );
		$body_text = apply_filters( 'flexible_content_widget', $instance['body_text'] );
		$background = apply_filters( 'flexible_content_widget', $instance['background'] );
		$background_colour = apply_filters( 'flexible_content_widget', $instance['background_colour'] );
		$button_colour = apply_filters( 'flexible_content_widget', $instance['button_colour'] );
		$link = apply_filters( 'flexible_content_widget', $instance['link'] );

		echo $args['before_widget'];

		?>

		<div class="widget widget-flexible-content-widget sidebar-widget">
			<?php if($link) { ?><a href="<?= $link ?>"> <? } ?>
				<div class="well" style="background: url('<?= $background ?>') no-repeat right bottom <?= $background_colour ?>">
					<h3><?= $title ?></h3>
	
					<h4><?= $sub_title ?></h4>
	
					<p><?= nl2br($body_text) ?></p>
					<a href="<?= $link ?>" class="btn btn-flexible" style="background:<?= $button_colour ?>">Read more</a>
				</div>
			<?php if($link) { ?></a> <? } ?>
		</div>

		<?php

		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance The widget options
	 * @param array $instance Previously saved values from database.
	 *
	 * @return string|void (DO NOT RETURN ANYTHING HERE THOUGH)
	 */
	public function form( $instance ) {
		// outputs the options form on admin
		$title = (isset($instance['title'])) ? $instance['title'] : __('Title!');
		$sub_title = (isset($instance['sub_title'])) ? $instance['sub_title'] : __('Subtitle!');
		$body_text = (isset($instance['body_text'])) ? $instance['body_text'] : __('Body Text!');
		$link = (isset($instance['link'])) ? $instance['link'] : __('add link http://');
		$background = (isset($instance['background'])) ? $instance['background'] : __('Add background image URL here');
		$background_colour = (isset($instance['background_colour'])) ? $instance['background_colour'] : __('Add background hex value here');
		$button_colour = (isset($instance['button_colour'])) ? $instance['button_colour'] : __('Add button background colour hex value here');
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'sub_title' ); ?>"><?php _e( 'Sub Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'sub_title' ); ?>" name="<?php echo $this->get_field_name( 'sub_title' ); ?>" type="text" value="<?php echo esc_attr( $sub_title ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'body_text' ); ?>"><?php _e( 'Body Text:' ); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id( 'body_text' ); ?>" name="<?php echo $this->get_field_name( 'body_text' ); ?>"><?php echo esc_attr( $body_text ); ?></textarea>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link:' ); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>"><?php echo esc_attr( $link ); ?></textarea>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'background' ); ?>"><?php _e( 'Background Image URL:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'background' ); ?>" name="<?php echo $this->get_field_name( 'background' ); ?>" type="text" value="<?php echo esc_attr( $background ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'background_colour' ); ?>"><?php _e( 'Background hex value:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'background_colour' ); ?>" name="<?php echo $this->get_field_name( 'background_colour' ); ?>" type="text" value="<?php echo esc_attr( $background_colour ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'button_colour' ); ?>"><?php _e( 'Button hex value:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'button_colour' ); ?>" name="<?php echo $this->get_field_name( 'button_colour' ); ?>" type="text" value="<?php echo esc_attr( $button_colour ); ?>" />
		</p>

	<?php

	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 * @return array|void
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['sub_title'] = (!empty($new_instance['sub_title'])) ? $new_instance['sub_title'] : '';
		$instance['body_text'] = (!empty($new_instance['body_text'])) ? $new_instance['body_text'] : '';
		$instance['link'] = (!empty($new_instance['link'])) ? strip_tags($new_instance['link']) : '';
		$instance['background'] = (!empty($new_instance['background'])) ? $new_instance['background'] : '';
		$instance['background_colour'] = (!empty($new_instance['background_colour'])) ? $new_instance['background_colour'] : '';
		$instance['button_colour'] = (!empty($new_instance['button_colour'])) ? $new_instance['button_colour'] : '';
		return $instance;
	}
}