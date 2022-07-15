<?php
/**
 * Compare products for WooCommerce- Section Settings
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CP_Settings_Section' ) ) :

	class Alg_WC_CP_Settings_Section {

		protected $settings;
		protected $handle_autoload = true;

		/**
		 * Constructor.
		 */
		function __construct( $handle_autoload = true ) {
			$this->handle_autoload = $handle_autoload;
			if ( $this->handle_autoload ) {
				$this->get_settings( array() );
				$this->handle_autoload();
			}
			add_filter( 'woocommerce_get_sections_alg_wc_cp', array( $this, 'settings_section' ) );
			add_filter( 'woocommerce_get_settings_alg_wc_cp_' . $this->id, array(
				$this,
				'get_settings',
			), PHP_INT_MAX );
		}

		/**
		 * get_settings.
		 */
		function get_settings( $settings = array() ) {
			$this->settings = $settings;

			return $this->settings;
		}

		/**
		 * handle_autoload.
		 */
		function handle_autoload() {
			foreach ( $this->settings as $value ) {
				if ( isset( $value['default'] ) && isset( $value['id'] ) ) {
					$autoload = isset( $value['autoload'] ) ? ( bool ) $value['autoload'] : true;
					add_option( $value['id'], $value['default'], '', ( $autoload ? 'yes' : 'no' ) );
				}
			}
		}

		/**
		 * settings_section.
		 */
		function settings_section( $sections ) {
			$sections[ $this->id ] = $this->desc;

			return $sections;
		}

	}

endif;
