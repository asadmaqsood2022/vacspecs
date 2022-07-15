<?php
/**
 * Displays the post header
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */
?>

<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
<?php if ( ! is_page() ) : ?>
<div class="entry-meta mb-2">
	<?php lightspeed_posted_on(); ?>
</div><!-- .entry-meta -->

<?php the_post_thumbnail(); ?>

<?php endif; ?>
