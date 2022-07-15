<?php
/**
 * Compare Products for WooCommerce - WooCommerce functions
 *
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CP_Woocommerce' ) ) {

	class Alg_WC_CP_Woocommerce {

		/**
		 * Add and store a notice.
		 * @param string $message     The text to display in the notice.
		 * @param string $notice_type The singular name of the notice type - either error, success or notice. [optional]
		 */
		public static function add_notice( $message, $notice_type = 'success' ) {
			if ( ! wc_has_notice( $message, $notice_type ) ) {
				wc_add_notice( $message, $notice_type = 'success' );
			}
		}

		/**
		 * Running with woocommerce version 3.0 or Higher
		 * @param string $version
		 *
		 * @return bool
		 */
		public static function version_check( $version = '3.0' ) {
			if ( class_exists( 'WooCommerce' ) ) {
				global $woocommerce;
				if ( version_compare( $woocommerce->version, $version, ">=" ) ) {
					return true;
				}
			}

			return false;
		}
	}
}