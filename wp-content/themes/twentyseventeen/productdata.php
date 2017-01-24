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






			$args = array( 'post_type' => 'products', 'posts_per_page' => 2 );
			$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) : $loop->the_post();
			    
			    echo '<div class="entry-content">';
			    echo '<h1><b>';
			    ?><a href="<?php the_permalink(); ?>"><?php the_title();?></a>
			    <?php
			    echo '</b></h1>';
			    echo '<p>';
			    the_post_thumbnail();
			    the_content();/*
			    $product_colors = get_post_meta( get_post()->ID, 'color', false );
				foreach ( $product_colors as $color ) {
				echo 'color:' .$color ;
				}*/
				//display all metadata on frontend
				$myvals = get_post_meta(get_post()->ID);

				foreach($myvals as $key=>$val)
				{
				    echo $key . ' : ' . $val[0] . '<br/>';
				}
			    echo '</p></div>';
			endwhile; // End of the loop.
			

			
			


			?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap --><center><a id="more_posts"><button>Load More</button></a></center>

<?php get_footer();

?>