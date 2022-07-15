<?php
/**
 * Template part for displaying post archives and search results
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */


?>


<div class="card mt-2">
	<?php
	if (lightspeed_can_show_post_thumbnail() ): ?>
		<div class='img-wrap'>
			<?
			$thumb = get_the_post_thumbnail(get_the_ID(), 'medium');
			echo "<a href='" . get_the_permalink()."'>" . $thumb . "</a>";
			?>
		</div>
	<?php endif; ?>
	
	<div class="card-body">
		<h5 class="card-title"><?php the_title(); ?></h5>
		<?php lightspeed_posted_on();  ?>
		<p class="card-text">
			<?php
				//Display 10 words from the content...
				echo wp_trim_words(strip_shortcodes(get_the_content()), 30, "..."); 
			?>
		</p>
	</div>
    
     <div class="card-footer">
        <a href="<?php _e(get_the_permalink());?>" class="btn btn-primary">Read More</a>
    </div>
    
</div>

