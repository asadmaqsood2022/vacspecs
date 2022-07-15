<?php
/**
 * Compare products for WooCommerce - Settings
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CP_Settings' ) ) :

	class Alg_WC_CP_Settings extends WC_Settings_Page {

		/**
		 * Constructor.
		 */
		function __construct() {
			$this->id    = 'alg_wc_cp';
			$this->label = __( 'Compare Products', 'compare-products-for-woocommerce' );
			parent::__construct();
		}

		/**
		 * get_settings.
		 */
		function get_settings() {
			global $current_section;

			return apply_filters( 'woocommerce_get_settings_' . $this->id . '_' . $current_section, array() );
		}

	}

endif;