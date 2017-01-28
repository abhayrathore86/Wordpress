<?php 
/**
 * Template Name: Movie Reviews
 **/
?>
<?php get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : '1';
			$args = array( 'nopaging' => false,'paged' => $paged,'post_type' => 'movie-reviews', 'posts_per_page' => 2 );
			$loop = new WP_Query( $args );?>
			<?php
			
			while ( $loop->have_posts() ) : $loop->the_post();
			    
			    echo '<div class="entry-content">';
			    echo '<h1><b>';
			    ?><a href="<?php the_permalink(); ?>"><?php the_title();?></a>
			    <?php
			    echo '</b></h1>';
			    echo '<p>';
			    the_post_thumbnail();
			    the_content();
			    echo '</p></div>';
			endwhile; // End of the loop.
			
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap --><center><?php previous_posts_link( '<button>« Newer Entries</button>' );?><?php next_posts_link( '<button>Older Entries »</button>', $loop->max_num_pages );?></center>

<?php get_footer();

?>