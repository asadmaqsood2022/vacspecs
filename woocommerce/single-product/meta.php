<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<div class="product_meta_top">
	<!-- <span>Share <img src="http://localhost/vacspecs/wp-content/uploads/2021/02/envelope-solid.svg" alt="Share"></span> -->
	
<div id="print-product" class="card" style="display: none;">
<?php
$productId  = $product->get_id();
$product = wc_get_product( $productId );
?>
<h1 style="font-size:36px"> <?php echo $product->get_title();?></h1>

  <p style="font-size:24px; display:flex; flex-direction:row-reverse; justify-content:flex-end"><?php echo $product->get_price_html();?></p>
  
  <p style="font-size:24px"><?php echo $product_short_description = $product->get_short_description();?></p>
<?php $attributes = nt_product_attributes();?>
<div style="font-size:18px; width:100% ; margin-bottom:15px; color:#777">Available Colors are: <span style ="color:#000;font-size:21px"> <?php echo $attributes['color'];?></span></div>
<div style="font-size:18px; width:100%;color:#777">Available Sizes are: <span style ="color:#000;font-size:21px"><?php echo $attributes['size'];?></span></div>
  <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $productId ), 'single-post-thumbnail' );?>
  <img  src="<?php echo $image[0]; ?>" data-id="<?php echo $productId; ?>" style="width:1400px" />
</div>

<a href="#" id="print-button"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/print.png" alt="Print"><span>Print</span></a>

<iframe id="print-iframe" width="0" height="0"></iframe>
	
	</div>
</div>
<div class="product_meta">
	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?> <span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span></span>

	<?php endif; ?>

	<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>

	<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>


</div>



