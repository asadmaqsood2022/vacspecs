<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */

// if (class_exists('acf') && class_exists('WooCommerce')) {
// 	add_filter('woocommerce_product_tabs', function($tabs) {
// 		global $post, $product;  // Access to the current product or post
		
// 		$custom_tabs_repeater = get_field('custom_tabs_repeater', $post->ID);
 
// 		if (!empty($custom_tabs_repeater)) {
// 			$counter = 0;
// 			$start_at_priority = 10;
// 			foreach ($custom_tabs_repeater as $custom_tab) {
// 				$tab_id = $counter . '_' . sanitize_title($custom_tab['tab_title']);
				
// 				$tabs[$tab_id] = [
// 					'title' => $custom_tab['tab_title'],
// 					'callback' => 'awp_custom_woocommerce_tabs',
// 					'priority' => $start_at_priority++
// 				];
// 				$counter++;
// 			}
// 		}
// 		return $tabs;
// 	});
 
// 	function awp_custom_woocommerce_tabs($key, $tab) {
// 		global $post;
 
// 		?><h2><?php echo $tab['title']; ?></h2><?php
 
// 		$custom_tabs_repeater = get_field('custom_tabs_repeater', $post->ID);
		
// 		$tab_id = explode('_', $key);
// 		$tab_id = $tab_id[0];
 
// 		echo $custom_tabs_repeater[$tab_id]['tab_contents'];
// 	}
// }

$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );
if ( ! empty( $product_tabs ) ) : ?>

	<div class="woocommerce-tabs wc-tabs-wrapper container">
		<ul class="tabs wc-tabs" role="tablist">
			<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
				<li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
					<a href="#tab-<?php echo esc_attr( $key ); ?>">
						<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
			<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
				<?php
				if ( isset( $product_tab['callback'] ) ) {
					call_user_func( $product_tab['callback'], $key, $product_tab );
				}
				?>
			</div>
		<?php endforeach; ?>

		<?php do_action( 'woocommerce_product_after_tabs' ); ?>
	</div>

<?php endif; ?>
