<?php
//this goes in functions.php near the top
function my_scripts_method() {
// register your script location, dependencies and version
   wp_register_script('custom_script',
   get_template_directory_uri() . '/js/jquery-3.1.1.js',
   array('jquery'),
   '1.0' );
 // enqueue the script
  wp_enqueue_script('custom_script');
  }
add_action('wp_enqueue_scripts', 'my_scripts_method');
// Our custom post type function
add_action( 'init', 'create_cars_taxonomy' );

function create_cars_taxonomy() {
	register_taxonomy(
		'cars',
		'post',
		array(
			'label' => 'Cars',
			'hierarchical' => true,
			'rewrite' => array(
				'slug' => 'car-model'
			)
		)
	);
}

function movie_reviews_init() {
    $args = array(
      'label' => 'Movie Reviews',
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'rewrite' => array('slug' => 'movie-reviews'),
        'query_var' => true,
        'menu_icon' => 'dashicons-video-alt',
        'supports' => array('title','editor','excerpt','trackbacks','custom-fields','comments','revisions','thumbnail','author','page-attributes'));
    register_post_type( 'movie-reviews', $args );
}
add_action( 'init', 'movie_reviews_init' );


function prowp_register_my_post_types() {
$labels = array(
'name' => 'Products',
'singular_name' => 'Product',
'add_new' => 'Add New Product',
'add_new_item' => 'Add New Product',
'edit_item' => 'Edit Product',
'new_item' => 'New Product',
'all_items' => 'All Products',
'view_item' => 'View Product',
'search_items' => 'Search Products',
'not_found' => 'No products found',
'not_found_in_trash' => 'No products found in Trash',
'parent_item_colon' => '',
'menu_name' => 'Products'
);
$args = array(
'labels'=>$labels,
'public' => true,
'show_ui' => true,
'capability_type' => 'post',
'hierarchical' => true,
'rewrite' => array('slug' => 'products'),
'query_var' => true,
'menu_icon' => 'dashicons-products',
'supports' => array(
'title','editor','excerpt','trackbacks','custom-fields','comments','revisions','thumbnail','author','page-attributes')
);

register_post_type( 'products', $args );
}
add_action( 'init', 'prowp_register_my_post_types' );

add_action( 'init', 'prowp_define_product_type_taxonomy' );
function prowp_define_product_type_taxonomy() {
$labels = array(
'name' => 'Type',
'singular_name' => 'Types',
'search_items' => 'Search Types',
'all_items' => 'All Types',
'parent_item' => 'Parent Type',
'parent_item_colon' => 'Parent Type:',
'edit_item' => 'Edit Type',
'update_item' => 'Update Type',
'add_new_item' => 'Add New Type',
'new_item_name' => 'New Type Name',
'menu_name' => 'Type');
$args = array(
'labels' => $labels,
'hierarchical' => true,
'query_var' => true,
'rewrite' => true
);
register_taxonomy( 'type', 'products', $args );
}

/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'smashing_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'smashing_post_meta_boxes_setup' );
/* Meta box setup function. */

/* Create one or more meta boxes to be displayed on the post editor screen. */
function smashing_add_post_meta_boxes() {

  add_meta_box("postcustom", "Size", "smashing_post_class_meta_box", "products", "side", "high", null);
}
/* Display the post meta box. */
function smashing_post_class_meta_box( $object, $box ) { ?>

  <?php wp_nonce_field( basename( __FILE__ ), 'smashing_post_class_nonce' ); ?>

  <p>
    <label for="smashing-post-class"><?php _e( "Add Size of Product :", 'example' ); ?></label>
   <br/>
    <input class="widefat" type="text" name="smashing-post-class" id="smashing-post-class" value="<?php echo esc_attr( get_post_meta( $object->ID, 'size', true ) ); ?>" size="30" />
  </p>
<?php }
/* Meta box setup function. */
function smashing_post_meta_boxes_setup() {

  /* Add meta boxes on the 'add_meta_boxes' hook. */
  add_action( 'add_meta_boxes', 'smashing_add_post_meta_boxes' );

  /* Save post meta on the 'save_post' hook. */
  add_action( 'save_post', 'smashing_save_post_class_meta', 10, 2 );
}
  /* Save the meta box's post metadata. */

function smashing_save_post_class_meta( $post_id, $post ) {

  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['smashing_post_class_nonce'] ) || !wp_verify_nonce( $_POST['smashing_post_class_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  /* Get the post type object. */
  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  /* Get the posted data and sanitize it for use as an HTML class. */
  $new_meta_value = ( isset( $_POST['smashing-post-class'] ) ? sanitize_html_class( $_POST['smashing-post-class'] ) : '' );

  /* Get the meta key. */
  $meta_key = 'size';

  /* Get the meta value of the custom field key. */
  $meta_value = get_post_meta( $post_id, $meta_key, true );

  /* If a new meta value was added and there was no previous value, add it. */
  if ( $new_meta_value && '' == $meta_value )
    add_post_meta( $post_id, $meta_key, $new_meta_value, true );

  /* If the new meta value does not match the old value, update it. */
  elseif ( $new_meta_value && $new_meta_value != $meta_value )
    update_post_meta( $post_id, $meta_key, $new_meta_value );

  /* If there is no new meta value but an old value exists, delete it. */
  elseif ( '' == $new_meta_value && $meta_value )
    delete_post_meta( $post_id, $meta_key, $meta_value );
}

add_shortcode('custom_short','custom_fun');
function custom_fun(){
	echo "<h1><a href='www.google.com'>Click here to go to google</a></h1>";
}

function register_book_post() {
$labels = array(
'name' => 'Book',
'singular_name' => 'Book',
'add_new' => 'Add New Book',
'add_new_item' => 'Add New Book',
'edit_item' => 'Edit Book',
'new_item' => 'New Book',
'all_items' => 'All Books',
'view_item' => 'View Book',
'search_items' => 'Search Books',
'not_found' => 'No books found',
'not_found_in_trash' => 'No books found in Trash',
'parent_item_colon' => '',
'menu_name' => 'Books'
);
$args = array(
'labels'=>$labels,
'public' => true,
'show_ui' => true,
'capability_type' => 'post',
'hierarchical' => true,
'rewrite' => array('slug' => 'books'),
'query_var' => true,
'menu_icon' => 'dashicons-book-alt',
'supports' => array(
'title','editor','excerpt','trackbacks','custom-fields','comments','revisions','thumbnail','author','page-attributes')
);

register_post_type( 'Books', $args );
}
add_action( 'init', 'register_book_post' );
//short code

add_shortcode( 'mytwitter', 'prowp_twitter' );
function prowp_twitter($atts, $content = null) {
	extract( shortcode_atts( array('person' => 'brad'), $atts ) );
	if ( $person == 'brad' ) {
		return '<a href="http://twitter.com/williamsba">@williamsba</a>';
	}elseif ( $person == 'david' ) {
		return '<a href="http://twitter.com/mirmillo">@mirmillo</a>';
	}elseif ( $person == 'hal' ) {
		return '<a href="http://twitter.com/freeholdhal">@freeholdhal</a>';
	}
}

add_filter( 'the_content', 'prowp_profanity_filter' );
function prowp_profanity_filter( $content ) {
$profanities = array( 'sissy', 'dummy' );
$content= str_ireplace( $profanities, '[censored]', $content );
return $content;
}

add_action( 'comment_text', 'prowp_email_new_comment' );
function prowp_email_new_comment($content) {
 return $content;
}

add_filter ( 'the_content', 'prowp_subscriber_footer' );
function prowp_subscriber_footer( $content ) {
if( is_single() ) {
		$content.= '<h3>Enjoyed this article?</h3>';
		$content.= '<p>Subscribe to my
		<a href="http://example.com/feed">RSS feed</a>!</p>';
	}
	return $content;
}

// Custom widget added
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
echo '<div class="widget-text wp_widget_plugin_box" style="width:269px; padding:5px 9px 20px 5px; border: 3px solid rgb(231, 15, 52); background: #DAF7A6  ; border-radius: 35px; margin: 10px 0 25px 0;">';
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

