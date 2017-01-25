<?php 
/**
 * Template Name: Product Data
 **/
?>
<?php get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			//get posts of particular taxonomy
			/*$args = array(
'post_type' =>'products',
'tax_query' =>array(
			array(
			'taxonomy'=> 'type',
			'field' => 'slug',
			'terms' => 'electronics'
			)

			)
		);
			$products = new WP_Query( $args );
while ( $products->have_posts() ) : $products->the_post();
echo '<p>' .get_the_title(). '</p>';
endwhile;
wp_reset_postdata();*/
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : '1';
		$args = array( 'nopaging' => false,'paged' => $paged,'post_type' => 'products', 'posts_per_page' => 2 );
			$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) : $loop->the_post();
			    
			    echo '<div class="entry-content">';
			    echo '<h1><b>';
			    ?><a href="<?php the_permalink(); ?>"><?php the_title();?></a>
			    <?php
			    echo '</b></h1>';
			    echo '<p>';
			    the_post_thumbnail();
			    the_content();
			    
				//display all metadata on frontend
				$custom_field_keys = get_post_custom_keys(get_post()->ID);

				foreach ( $custom_field_keys as $key => $value ) {
				    $valuet = trim($value);
				    if ( '_' == $valuet{0} )
				        continue;
				    $mykey_values = get_post_custom_values( $value );
					  foreach ( $mykey_values as $key => $value1 ) {
					    echo $value . ' : ' . $value1 . '<br/>';
					  }
				}
			    echo '</p></div>';
			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap --><center><?php previous_posts_link( '<button>« Newer Entries</button>' );?><?php next_posts_link( '<button>Older Entries »</button>', $loop->max_num_pages );?></center>

<?php get_footer();

?>