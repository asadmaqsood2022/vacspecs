<?php
/**
 * Compare products for WooCommerce  - Core Class
 *
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CP_Core' ) ) :

	class Alg_WC_CP_Core {

		/**
		 * Plugin version.
		 *
		 * @var   string
		 */
		public $version = '1.0.0';

		/**
		 * @var   Alg_WC_CP_Core The single instance of the class
		 */
		protected static $_instance = null;

		/**
		 * Main Alg_WC_CP_Core Instance
		 *
		 * Ensures only one instance of Alg_WC_CP_Core is loaded or can be loaded.
		 *
		 * @static
		 * @return  Alg_WC_CP_Core - Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Constructor.
		 *
		 */
		function __construct() {

			// Set up localization
			$this->handle_localization();

			// Init admin part
			//$this->init_admin();
			add_action( 'woocommerce_init', array( $this, 'init_admin' ), 20 );



			if ( true === filter_var( get_option( Alg_WC_CP_Settings_General::OPTION_ENABLE_PLUGIN, false ), FILTER_VALIDATE_BOOLEAN ) ) {

				// Manages buttons
				$this->handle_buttons();

				// Enqueue scripts
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

				// Manages query vars
				add_filter( 'query_vars', array( $this, 'handle_query_vars' ) );

				// Takes actions based on the requested url
				add_action( 'woocommerce_init', array( $this, 'route' ), 20 );

				// Creates comparison list
				add_action( 'wp_footer', array( $this, 'create_comparison_list' ) );

				// Start session if necessary
				add_action( 'init', array( $this, "handle_session" ), 1 );
				add_action( 'woocommerce_init', array( $this, "handle_session" ), 1 );

				// Manages Shortcodes
				$this->handle_shortcodes();

				add_action( 'widgets_init', array( $this, 'create_widgets' ) );

			}
		}

		/**
		 * Create widgets.
		 *
		 */
		public function create_widgets() {

			if ( true === filter_var( get_option( Alg_WC_CP_Settings_Comparison_List::OPTION_WIDGET_LINK, true ), FILTER_VALIDATE_BOOLEAN ) ) {
				register_widget( 'Alg_WC_CP_Widget_Link' );
			}
		}

		/**
		 * Manages Shortcodes
		 *
		 */
		private function handle_shortcodes() {
			add_shortcode( 'alg_wc_cp_table', array( Alg_WC_CP_Shortcodes::get_class_name(), 'create_comparison_list' ) );
		}

		/**
		 * Creates comparison list
		 *
		 */
		public function create_comparison_list() {
			if ( false === filter_var( get_option( Alg_WC_CP_Settings_Comparison_List::OPTION_USE_MODAL, true ), FILTER_VALIDATE_BOOLEAN ) ) {
				return;
			}

			if ( sanitize_text_field( get_query_var( Alg_WC_CP_Query_Vars::MODAL, false )) != 'open' ) {
				return;
			}

			echo Alg_WC_CP_Comparison_list::create_comparison_list();
		}

		/**
		 * Start session if necessary
		 *
		 */
		function handle_session() {
			if ( ! session_id() ) {
				session_start();
			}

		}

		/**
		 * Takes actions based on the requested url
		 *
		 */
		public function route() {
			$args   = $_GET;
			$args   = wp_parse_args( $args, array(
				Alg_WC_CP_Query_Vars::ACTION => '',
			) );
			$action = sanitize_text_field( $args[ Alg_WC_CP_Query_Vars::ACTION ] );

			if ( $action == 'compare' ) {

				// Add product to compare list
				$response = Alg_WC_CP_Comparison_list::add_product_to_comparison_list( $args );

				// Show WooCommerce notification
				Alg_WC_CP_Comparison_list::show_notification_after_comparing( $args );

			} else if ( $action == 'remove' ) {

				// Removes product from compare list
				$response = Alg_WC_CP_Comparison_list::remove_product_from_comparison_list( $args );

				// Show WooCommerce notification
				Alg_WC_CP_Comparison_list::show_notification_after_comparing( $args );
			}
		}

		/**
		 * Manages query vars
		 *
		 */
		public function handle_query_vars( $vars ) {
			$vars = Alg_WC_CP_Default_Button::handle_query_vars( $vars );
			$vars = Alg_WC_CP_Comparison_list::handle_query_vars( $vars );
			return $vars;
		}

		/**
		 * Load scripts and styles
		 *
		 */
		function enqueue_scripts() {
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			// Font awesome
			$css_file = '//maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css';
			$font_awesome_opt = get_option( Alg_WC_CP_Settings_General::OPTION_FONT_AWESOME, true );
			if ( filter_var( $font_awesome_opt, FILTER_VALIDATE_BOOLEAN ) !== false ) {
				if ( !wp_script_is( 'alg-font-awesome' ) ) {
					wp_register_style( 'alg-font-awesome', $css_file, array() );
					wp_enqueue_style( 'alg-font-awesome' );
				}
			}

			// Main css file
			// $css_file = 'assets/css/alg-wc-cp'.$suffix.'.css';
			// $css_ver = date( "ymd-Gis", filemtime( ALG_WC_CP_DIR . $css_file ) );
			// wp_register_style( 'alg-wc-compare-products', ALG_WC_CP_URL . $css_file, array(), $css_ver );
			// wp_enqueue_style( 'alg-wc-compare-products' );

			// Izimodal - A modal plugin (http://izimodal.marcelodolce.com)
			if ( true === filter_var( get_option( Alg_WC_CP_Settings_Comparison_List::OPTION_USE_MODAL, true ), FILTER_VALIDATE_BOOLEAN ) ) {
				wp_register_script( 'alg-wc-cp-izimodal', get_stylesheet_directory_uri().'/js/iziModal.min.js', array( 'jquery' ), false, true );
				wp_enqueue_script( 'alg-wc-cp-izimodal' );
				wp_register_style( 'alg-wc-cp-izimodal', get_stylesheet_directory_uri().'/css/iziModal.min.css', array(), false );
				wp_enqueue_style( 'alg-wc-cp-izimodal' );

				// Show comparison list
				if ( sanitize_text_field( get_query_var( Alg_WC_CP_Query_Vars::MODAL, false ) ) == 'open' ) {
					Alg_WC_CP_Comparison_list::show_comparison_list();
				}
			}
		}

		/**
		 * Manages buttons.
		 *
		 */
		private function handle_buttons(){
			Alg_WC_CP_Default_Button::manage_button_loading();
		}

		/**
		 * Enqueues admin scripts.
		 *
		 */
		function enqueue_admin_scripts($hook) {
			if ( $hook == 'woocommerce_page_wc-settings' && isset( $_GET['tab'] ) && $_GET['tab'] == 'alg_wc_cp' ) {
				Alg_WC_CP_Selectize::enqueue_scripts();
				Alg_WC_CP_Selectize::load_selectize();
			}
		}

		/**
		 * Init admin fields
		 *
		 */
		public function init_admin() {
			if ( is_admin() ) {
					add_filter( 'woocommerce_get_settings_pages', array( $this, 'add_woocommerce_settings_tab' ) );
				add_filter( 'plugin_action_links_' . ALG_WC_CP_BASENAME, array( $this, 'action_links' ) );
			}

			// Admin setting options inside WooCommerce
			new Alg_WC_CP_Settings_General();
			new Alg_WC_CP_Settings_Buttons();
			new Alg_WC_CP_Settings_Comparison_List();
			$this->create_custom_settings_fields();

			if ( is_admin() && get_option( 'alg_wc_cp_version', '' ) !== $this->version ) {
				update_option( 'alg_wc_cp_version', $this->version );
			}

			// Admin scripts
			add_action( 'admin_enqueue_scripts', array($this, 'enqueue_admin_scripts' ), 99 );
		}

		/**
		 * Create custom settings fields
		 *
		 */
		private function create_custom_settings_fields(){
			require_once( 'class-wccso-metabox.php' );
			WCCSO_Metabox::get_instance();
		}

		/**
		 * Show action links on the plugin screen
		 *
		 * @param   mixed $links
		 * @return  array
		 */
		function action_links( $links ) {
			$custom_links = array( '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=alg_wc_cp' ) . '">' . __( 'Settings', 'woocommerce' ) . '</a>' );
			return array_merge( $custom_links, $links );
		}

		/**
		 * Add settings tab to WooCommerce settings.
		 *
		 */
		function add_woocommerce_settings_tab( $settings ) {
			$settings[] = new Alg_WC_CP_Settings();
			return $settings;
		}

		/**
		 * Handle Localization
		 *
		 */
		public function handle_localization() {
			$locale = apply_filters( 'plugin_locale', get_locale(), 'compare-products-for-woocommerce' );
			load_textdomain( 'compare-products-for-woocommerce', WP_LANG_DIR . dirname( ALG_WC_CP_BASENAME ) . 'compare-products-for-woocommerce' . '-' . $locale . '.mo' );
			load_plugin_textdomain( 'compare-products-for-woocommerce', false, dirname( ALG_WC_CP_BASENAME ) . '/languages/' );
		}

		/**
		 * Method called when the plugin is activated
		 *
		 */
		public function on_install() {
			Alg_WC_CP_Comparison_list::create_page();
		}

		/**
		 * Method called when the plugin is uninstalled
		 *
		 */
		public static function on_uninstall() {
			Alg_WC_CP_Comparison_list::delete_page();
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

endif;