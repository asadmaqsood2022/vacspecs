<?php
/**
 * Compare products for WooCommerce - Remove button
 *
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CP_Remove_Button' ) ) {

	class Alg_WC_CP_Remove_Button {

		/**
		 * Loads remove button template.
		 *
		 */
		public static function load_remove_button_template() {
			global $wp;
			$permalink_structure = get_option('permalink_structure') ;

			if(empty($permalink_structure)){
				if(is_shop()){
					$current_url =  get_post_type_archive_link('product');
				}else{
					$current_url = get_permalink(add_query_arg( array(), $wp->request ));
				}
			}else{
				$current_url = home_url( add_query_arg( array(), $wp->request ) ) . '/';
			}

			$btn_href_params =  array(
				Alg_WC_CP_Query_Vars::ACTION             => 'remove',
				Alg_WC_CP_Query_Vars::COMPARE_PRODUCT_ID => get_the_ID(),
			);

			if ( true === filter_var( get_option( Alg_WC_CP_Settings_Comparison_List::OPTION_USE_MODAL, true ), FILTER_VALIDATE_BOOLEAN ) ) {
				$btn_href_params[Alg_WC_CP_Query_Vars::MODAL] = 'open';
			}

			$params = array(
				'btn_data_action' => 'compare',
				'btn_class'       => 'alg-wc-cp-btn alg-wc-cp-remove-btn',
				'btn_label'       => __( 'Remove', 'compare-products-for-woocommerce' ),
				'btn_icon_class'  => 'fa fa-trash alg-wc-cp-icon',
				'btn_href'        => add_query_arg( $btn_href_params, $current_url ),
			);
			echo alg_wc_cp_locate_template( 'remove-button.php', $params );
		}
	}

}