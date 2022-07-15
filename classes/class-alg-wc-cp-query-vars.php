<?php
/**
 * Compare Products for WooCommerce - Query vars
 *
 * 
 */

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CP_Query_Vars' ) ) {

	class Alg_WC_CP_Query_Vars {

		/**
		 * Query var for creating an action.
		 *
		 * Values can be 'compare'
		 *
		 */
		const ACTION = 'alg_wc_cp_action';

		/**
		 * Query var for the product id to compare.
		 *
		 */
		const COMPARE_PRODUCT_ID = 'alg_wc_cp_pid';

		/**
		 * Var for opening modal
		 *
		 */
		const MODAL = 'alg_wc_cp_modal';

	}

}