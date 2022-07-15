<?php
/**
 * Compare Products for WooCommerce - Shortcodes
 *
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CP_Shortcodes' ) ) {

	class Alg_WC_CP_Shortcodes {

		/**
		 * Creates a comparison list table.
		 *
		 */
		public static function create_comparison_list() {
			echo Alg_WC_CP_Comparison_list::create_comparison_list( array(
				'use_modal' => false,
			) );
		}

		/**
		 * Returns class name
		 *
		 * @return type
		 */
		public static function get_class_name() {
			return get_called_class();
		}
	}

}