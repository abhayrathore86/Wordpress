<?php
	/*
	Plugin Name: Contact Us plugin
	Description: Building a Contact us plugin for demosite.
	Author: Developer 53
	Version: 1
	*/
	class my_contact_us extends WP_Widget {
		// constructor
		function my_contact_us() {
		// Give widget name here
		parent::__construct(false, $name = __('Contact Us plugin', 'wp_widget_plugin') );

	}
	// display widget
	function widget($args, $instance) {
	?>
	<form id="contact_form"  action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="GET">
	<h1><b>Contact Us Here</b></h1>
		<div class="row">
			<label for="name">Your name:</label>
			<input id="name" class="input" name="name" type="text" value="" size="30" /><br />
		</div>
		<div class="row">
			<label for="email">Your email:</label>
			<input id="email" class="input" name="email" type="text" value="" size="30" /><br />
		</div>
		<div class="row">
			<label for="message">Your message:</label>
			<textarea id="message" class="input" name="message" rows="7" cols="30"></textarea><br />
		</div>
		<input id="submit_button" type="submit" value="Send email" name="submit" />
	</form>		
	<br/>			
	<?php
	}
	}
	// register widget
	add_action('widgets_init', create_function('', 'return register_widget("my_contact_us");'));

	if (isset($_REQUEST['submit']) && $_REQUEST['name'] != '' && $_REQUEST['email'] != '' && $_REQUEST['message'] != ''  ) {
		global $wpdb;
		$tablename='wp_feedback_data';
		$name=$_REQUEST['name'];
		$email=$_REQUEST['email'];
		$message=$_REQUEST['message'];
		$to="lanetteam.bhumika@gmail.com";
		$subject="feedback";
		$data=array('name'=>$name,'email'=>$email,'message'=>$message);
		
		if($wpdb->insert( $tablename, $data)){
			echo "<script>alert('data inserted');</script>";
			$ref = $_SERVER['HTTP_REFERER'];
			header( 'refresh: 0; url='.$ref);
		}

	    //wp_mail( $to, $subject, $message, $headers);
	}
	
	?>
