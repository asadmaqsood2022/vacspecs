<?php
/**
 * Compare Products for WooCommerce - Session
 *
 * 
 */

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CP_Session' ) ) {

	class Alg_WC_CP_Session {

		/**
		 * Session var responsible for creating a compare list
		 *
		 * @since   1.0.0
		 */
		const VAR_COMPARE_LIST = 'alg-wc-cp-list';


	}

}