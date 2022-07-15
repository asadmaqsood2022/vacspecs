<?php
/**
 * Template name: Brands
 */

get_header();
?>

<?php 
$terms = get_terms( 'item', array(
    'hide_empty' => false,
) );
?>
<?php woocommerce_breadcrumb(); ?>
<div class="brands-wrapper">
	<div class="container">
		<h2>shop by Brand</h2>
		<div class="woocommerce">
			<ul class="products">
				<?php 
				$brands = get_terms( 'item', array(
					'hide_empty' => false,
				) );
				foreach ($brands as $brand) {
				?>
				<li class="product-category">
					<a href="<?php echo esc_url( get_term_link( $brand->term_id, 'item' ) ); ?>">
						<img src="<?php echo get_field('brand_image', $brand);  ?>">
						<h5><?php echo $brand->name;  ?></h5>
					</a>
				</li>
				<?php 
wp_reset_postdata();
			} 

				?>
			</ul>
		</div>
	</div>
</div>


<?php
get_footer();
?>