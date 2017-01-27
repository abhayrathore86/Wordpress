<?php
/*
Plugin Name: Custom Widget
Plugin URI: https://inkthemes.com
Description: Building a Custom WordPress Widget.
Author: Developer 53
Version: 1
Author URI: https://inkthemes.com
*/
class my_plugin extends WP_Widget {

// constructor
function my_plugin() {
// Give widget name here
parent::__construct(false, $name = __('My Widget', 'wp_widget_plugin') );

}
// widget form creation

function form($instance) {

// Check values
if( $instance) {
		$title = esc_attr($instance['title']);
		$type = $instance['type'];
		$textarea = $instance['textarea'];
	} else {
		$title = '';
		$textarea = '';
		$type = '';
}

?>
<p>
<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'wp_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Type', 'wp_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>" type="text" value="<?php echo $type; ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id('textarea'); ?>"><?php _e('Description:', 'wp_widget_plugin'); ?></label>
<textarea class="widefat" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>" rows="7" cols="20" ><?php echo $textarea; ?></textarea>
</p>

<?php
}


function update($new_instance, $old_instance) {
$instance = $old_instance;
// Fields
$instance['title'] = strip_tags($new_instance['title']);
$instance['type'] = strip_tags($new_instance['type']);
$instance['textarea'] = strip_tags($new_instance['textarea']);
return $instance;
}

// display widget
function widget($args, $instance) {
extract( $args );

// these are the widget options
$title = apply_filters('widget_title', $instance['title']);
$type = $instance['type'];
$textarea = $instance['textarea'];
echo $before_widget;

// Display the widget
<<<<<<< HEAD
echo '<div class="widget-text wp_widget_plugin_box" style="width:269px; padding:5px 9px 20px 5px; border: 3px solid rgb(231, 15, 52); background: #DAF7A6  ; border-radius: 5px; margin: 10px 0 25px 0;">';
=======
echo '<div class="widget-text wp_widget_plugin_box" style="width:269px; padding:5px 9px 20px 5px; border: 3px solid rgb(231, 15, 52); background: #DAF7A6  ; border-radius: 35px; margin: 10px 0 25px 0;">';
>>>>>>> master
echo '<div class="widget-title" style="width: 90%; height:30px; margin-left:3%;font-size:20px; ">';

// Check if title is set
if ( $title ) {
echo $before_title . $title . $after_title ;
}
echo '</div>';

// Check if textarea is set
echo '<div class="widget-textarea" style="width: 90%; margin-left:3%; padding:5px; background-color: white; border-radius: 3px; min-height: 70px;">';
echo '<div class="widget-type" style="width: 90%; margin-left:3%; padding:3px; background-color: white; border-radius: 3px; min-height: 70px;">';
if( $type) {
echo '<p class="wp_widget_plugin_type" style="font-size:15px;border: 2px solid black;padding-left:8px;font-size:18 em;background-color:#FFA07A"><b>'.$type.'</b></p>';
}
if( $textarea ) {
echo '<p class="wp_widget_plugin_textarea" style="font-size:15px;">'.$textarea.'</p>';
}
echo '</div>';
echo '</div>';
echo $after_widget;
}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("my_plugin");'));


?>
