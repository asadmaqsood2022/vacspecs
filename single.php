<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();
/* Start the Loop */
woocommerce_breadcrumb(); 
while ( have_posts() ) :
	the_post();
?>

<div class="main-title">
	<div class="container">
		<div class="main-top">
			<h2><?php the_title(); ?></h2>
		</div>
	</div>
</div>

<div class="single-post-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<div class="single-post-content">
					<p><?php echo get_the_date('j F Y'); ?> | <?php echo get_the_author(); ?></p>
					<div class="spc-img"><img src="<?php the_post_thumbnail_url(); ?>" alt=""></div>
					<?php the_content(); ?>
				</div>
			</div>
			
			<div class="col-lg-4">
				<div class="recent-posts">
					<h3>Recent posts</h3>
					<?php 
					$args = array('posts_per_page' => 5, 'post_type' => 'post');
					$query = new WP_Query($args);
					if ($query->have_posts()) :
						while ($query->have_posts()) :
								$query->the_post();
					?>
					<p><?php the_title(); ?></p>
					<?php endwhile; 
					wp_reset_postdata(); 
							else:  ?>
							<p>
							<?php _e( 'No Posts' ); ?>
							</p>
						<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php endwhile; // End of the loop. 
?>


<?php
get_footer();