<?php 
/**
 * Template Name: All Custom Type
 **/
?>
<?php get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			foreach ( get_post_types( '', 'names' ) as $post_type ) {
				
			$args = array( 'post_type' => $post_type, 'posts_per_page' => 10 );
			$loop = new WP_Query( $args );
			if( $loop->have_posts() ){
				echo '<h1><i>Custom Post Type: '.$post_type.'</i></h1>';
			while ( $loop->have_posts() ) : $loop->the_post();
			    
			    echo '<div class="entry-content">';
			    echo '<h2><b>';
			    ?><a href="<?php the_permalink(); ?>"><?php the_title();?></a>
			    <?php
			    echo '</b></h2>';
			    echo '<p>';
			    the_post_thumbnail();
			    the_content();
			    echo '</p></div>';
			endwhile; // End of the loop.
			}
		}
			?>
			<?php	
?>
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap --><center><a id="more_posts"><button>Load More</button></a></center>

<?php get_footer();

?>