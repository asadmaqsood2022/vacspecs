<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>
<?php $term = get_queried_object();

				// vars
$left_info = get_field('category_left_info', $term); 
$banner_txt = get_field('banner_text', $term);
?>
<div class="container">
	
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		
		<div class="main-top">
			<div class="category_inner">
				<h2 class="woocommerce-products-header__title page-title">
				<?php woocommerce_page_title(); ?></h2>
				
				 <?php if ( is_product() && has_term( 'central-vacuum', 'product_cat' ) || is_product_category( 'central-vacuum' ) ) {?>
				<div class="left_info_txt"><?php echo $left_info;?></div>
				</div>
				<div class="main_category_img"><img src="<?php echo get_field('category_right_image', $term);  ?>"></div>
				<?php } elseif ( is_product() && has_term( 'residential', 'product_cat' ) || is_product_category( 'residential' ) ) {?>
				<div class="left_info_txt"><?php echo $left_info;?></div>
				</div>
				<div class="main_category_img"><img src="<?php echo get_field('category_right_image', $term);  ?>"></div>
				<?php } elseif ( is_product() && has_term( 'commercial', 'product_cat' ) || is_product_category( 'commercial' ) ) {?>
					<div class="left_info_txt"><?php echo $left_info;?></div>
				</div>
				<div class="main_category_img"><img src="<?php echo get_field('category_right_image', $term);  ?>"></div>
				<?php } elseif ( is_product() && has_term( 'air-quality', 'product_cat' ) || is_product_category( 'air-quality' ) ) {?>
					<div class="left_info_txt"><?php echo $left_info;?></div>
				</div>
				<div class="main_category_img"><img src="<?php echo get_field('category_right_image', $term);  ?>"></div>
				<?php } elseif ( is_product() && has_term( 'cleaning-products', 'product_cat' ) || is_product_category( 'cleaning-products' ) ) {?>
					<div class="left_info_txt"><?php echo $left_info;?></div>
				</div>
				<div class="main_category_img"><img src="<?php echo get_field('category_right_image', $term);  ?>"></div>

				<?php } elseif ( is_product() && has_term( 'accessories-parts', 'product_cat' ) || is_product_category( 'accessories-parts' ) ) {?>
					<div class="left_info_txt"><?php echo $left_info;?></div>
				</div>
				<div class="main_category_img"><img src="<?php echo get_field('category_right_image', $term);  ?>"></div>
				
			<?php } else {
        
    }?>
		</div>
		</div>
	<?php endif; ?>




	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
	?>


	</div>

<div class="single-brand-content">
<div class="container">
	<?php if( $banner_txt ): ?>
	<div class="bannertxt"><?php echo $banner_txt;?></div>
	<?php endif; ?>
		<div class="row">
			<div class="col-lg-4">
				<div class="brand-categories">
			<?php 
			dynamic_sidebar('sidebar-archive'); ?>
			</div>
			</div>
			<div class="col-lg-8">
				<div class="brands-results">
<?php
if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	?>
	<div class="brands-search"> <?php do_action( 'woocommerce_before_shop_loop' ); ?> 
	</div>
	<div class="custom-products-design">
			<?php
	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();
?></div>
<?php

/**
 * Hook: woocommerce_after_shop_loop.
 *
 * @hooked woocommerce_pagination - 10
 */
do_action( 'woocommerce_after_shop_loop' );
} else {
/**
 * Hook: woocommerce_no_products_found.
 *
 * @hooked wc_no_products_found - 10
 */
do_action( 'woocommerce_no_products_found' );
}?>
			</div>
			</div>
	</div>

</div>
<?php

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );
?>

<?php
get_footer( 'shop' );
